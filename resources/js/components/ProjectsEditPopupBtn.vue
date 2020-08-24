<template>
    <span>
        <b-button variant="primary" class="btn-sm"
                  v-b-tooltip.hover :title="lang.btn"
                  @click="loadModel">
            <slot></slot>
        </b-button>

        <b-modal id="projects-popups-edit"
                 ref="modal"
                 @hidden="resetModal"
                 @ok="handleOk"
                 @show="resetModal"
                 :cancel-disabled="!loaded"
                 :ok-disabled="!loaded"
                 :ok-title="lang.modal.ok"
                 :cancel-title="lang.modal.cancel"
                 :title="lang.modal.title">
            <p class="text-center" v-if="!loaded"><b-spinner></b-spinner></p>
            <form ref="form" @submit.stop.prevent="handleSubmit" v-if="loaded">
                <b-form-group
                    :state="nameState"
                    :label="lang.form.name.label"
                    label-for="name-input"
                    :invalid-feedback="lang.form.name.feedback"
                >
                    <b-form-input
                        id="name-input"
                        name="name"
                        v-model="name"
                        :state="nameState"
                        :placeholder="lang.form.name.placeholder"
                        required
                    ></b-form-input>
                </b-form-group>
            </form>
        </b-modal>
    </span>
</template>

<script>
export default {
    props: [
        'route_edit', 'route_update'
    ],
    data() {
        return {
            name: '',
            nameState: null,
            submittedNames: [],
            loaded: false,
            lang: {
                btn: this.translate('projects.general.index.item.edit'),
                modal: {
                    title: this.translate('projects.edit.title'),
                    ok: this.translate('projects.edit.form.submit'),
                    cancel: this.translate('forms.cancel'),
                },
                form: {
                    name: {
                        feedback: this.translate('projects.edit.form.validate.name.required'),
                        label: this.translate('projects.edit.form.name.label'),
                        placeholder: this.translate('projects.edit.form.name.placeholder'),
                    }
                }
            }
        }
    },
    methods: {
        loadModel() {
            this.$refs['modal'].show();
            axios.get(this.route_edit).then(function (response) {
                this.loaded = true;
                this.name = response.data.name;
            }.bind(this)).catch(function (error) {
                console.error(error);
                swal(tranlate('errors.ajax.error.title'), tranlate('errors.ajax.error.message'), 'error');
            });
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            return valid
        },
        resetModal() {
            this.name = ''
            this.nameState = null
            this.loaded = false;
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault()
            this.handleSubmit()
        },
        handleSubmit() {
            if (!this.checkFormValidity()) {
                return
            }

            this.loaded = false;

            axios.patch(this.route_update, {
                name: this.name,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }).then(function (response) {
                this.$refs['modal'].hide();
                if (!response.data.status) {
                    swal(tranlate('errors.ajax.error.title'), tranlate('errors.ajax.error.message'), 'error');
                } else {
                    $('.js-project-name[data-id=25]').html(response.data.data.name);
                }
            }.bind(this)).catch(function (error) {
                console.error(error);
                this.$refs['modal'].hide();
                swal(tranlate('errors.ajax.error.title'), tranlate('errors.ajax.error.message'), 'error');
            });
        }
    }
}
</script>
