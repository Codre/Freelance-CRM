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
                            <b>{{ item.time }}</b>
                        </b-td>
                        <b-td>
                            <div v-if="!isEditing(item.id)" v-html="item.comment"></div>
                            <b-form :action="store_url + item.id" inline v-if="isEditing(item.id)" :id="'time_comment_form_' + item.id" method="POST">
                                <input name="_method" type="hidden" value="PATCH" />
                                <input name="_token" type="hidden" :value="csrf" />
                                <b-textarea name="comment" :value="item.comment"
                                            :placeholder="translate('projects.times.item.form.comment.placeholder')"></b-textarea>
                            </b-form>
                        </b-td>
                        <b-td>
                            <div>{{ item.who }}</div>
                            <div class="text-muted"><small>{{ item.date }}</small></div>
                        </b-td>
                        <b-td>
                            <div v-if="isEditing(item.id)">
                                <b-button @click="submit(item.id)" variant="success" v-b-tooltip
                                          :title="translate('projects.times.item.form.buttons.save')">
                                    <b-icon icon="check"></b-icon>
                                </b-button>
                                <b-button @click="toggleEdit(item.id)" variant="danger" v-b-tooltip
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
    props: ['list', 'user_id', 'store_url', 'csrf'],
    data() {
        return {
            editing: []
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
                    canEdit: item.user.id === parseInt(vue.user_id)
                };
            });
        }
    },
    methods: {
        submit: function(id) {
            $('#time_comment_form_' + id).submit();
            this.toggleEdit(id);
        },
        isEditing: function (id) {
            return this.editing.indexOf(id) >= 0
        },
        toggleEdit: function(id) {
            if (this.isEditing(id)) {
                this.editing.splice(this.editing.indexOf(id), 1);
            } else {
                this.editing.push(id);
            }
        }
    }
}
</script>
