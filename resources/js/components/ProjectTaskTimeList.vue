<template>
    <div>
        <b-card no-body>
            <b-table-simple hover responsive>
                <b-thead>
                    <b-tr>
                        <b-th>{{ translate('projects.times.item.header.time') }}</b-th>
                        <b-th>{{ translate('projects.times.item.header.comment') }}</b-th>
                        <b-th>{{ translate('projects.times.item.header.who') }}</b-th>
                        <b-th></b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr v-for="item in items" v-bind:key="item.id">
                        <b-td>
                            <b v-if="!isEditing(item.id)">{{ item.time }}</b>
                            <input v-if="isEditing(item.id)" type="time" class="form-control" v-model="item.time" />
                        </b-td>
                        <b-td>
                            <div v-if="!isEditing(item.id)" v-html="item.comment"></div>
                            <b-textarea v-if="isEditing(item.id)" name="comment" v-model="item.comment" class="form-control"
                                        :placeholder="translate('projects.times.item.form.comment.placeholder')"></b-textarea>
                        </b-td>
                        <b-td>
                            <div>{{ item.who }}</div>
                            <div class="text-muted"><small>{{ item.date }}</small></div>
                        </b-td>
                        <b-td>
                            <div v-if="isEditing(item.id)">
                                <b-button @click="submit(item.id)" variant="success" v-b-tooltip :disabled="saving"
                                          :title="translate('projects.times.item.form.buttons.save')">
                                    <b-spinner v-if="saving" small></b-spinner>
                                    <b-icon icon="check"></b-icon>
                                </b-button>
                                <b-button @click="toggleEdit(item.id)" variant="danger" v-b-tooltip :disabled="saving"
                                          :title="translate('projects.times.item.form.buttons.cancel')">
                                    <b-icon icon="x-circle"></b-icon>
                                </b-button>
                            </div>
                            <div v-if="!isEditing(item.id)">
                                <b-button @click="toggleEdit(item.id)" v-if="item.canEdit" v-b-tooltip
                                          :title="translate('projects.times.item.form.buttons.edit')"><b-icon icon="pencil"></b-icon></b-button>
                            </div>
                        </b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "ProjectTaskTimeList",
    props: ['list', 'user_id', 'store_url', 'can'],
    data() {
        return {
            editing: [],
            saving: false,
            state: {}
        }
    },
    computed: {
        items: function () {
            var vue = this;
            return JSON.parse(this.list).map(function (item) {
                const time = item.total,
                    h = Math.floor(time / 60),
                    m = time - h * 60;
                return {
                    id: item.id,
                    time: (h < 10 ? '0' + h : h) + ':' + (m < 10 ? '0' + m : m),
                    comment: nl2br(item.comment),
                    who: item.user.name,
                    date: item.date,
                    canEdit: item.user.id === parseInt(vue.user_id) && this.can
                };
            }.bind(this));
        }
    },
    methods: {
        getItem(id) {
            const item = this.items.filter(function (item) {
                return item.id === id;
            });

            return Object.assign({}, item[0]);
        },
        resetItem(id) {
            this.items.forEach(function(item, key) {
               if (item.id === id) {
                   this.items[key] = this.state[id];
               }
            }.bind(this));
        },
        submit: function(id) {
            const item = this.getItem(id);

            this.saving = true;

            axios.patch(this.store_url + id, {
                time : item.time,
                comment: item.comment
            }).then(function (response) {
                this.saving = false;
                this.state[id] = item;
                this.toggleEdit(id);
            }.bind(this)).catch(function(error) {
                console.error(error);
                swal(translate('errors.ajax.error.title'), translate('errors.ajax.error.message'), 'error');
                this.saving = false;
            }.bind(this));
        },
        isEditing: function (id) {
            return this.editing.indexOf(id) >= 0
        },
        toggleEdit: function(id) {
            if (this.isEditing(id)) {
                this.editing.splice(this.editing.indexOf(id), 1);
                this.resetItem(id);
            } else {
                this.editing.push(id);
                this.state[id] = this.getItem(id);
            }
        }
    }
}
</script>
