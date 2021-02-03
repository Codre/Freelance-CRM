<template>
    <div>
        <b-button variant="primary" class="m-1"
                  v-b-modal.projects-popups-create>{{ lang.btn }}
        </b-button>

        <b-modal id="projects-popups-create"
                 ref="modal"
                 @hidden="resetModal"
                 @ok="handleOk"
                 @show="resetModal"
                 :ok-title="lang.modal.ok"
                 :cancel-title="lang.modal.cancel"
                 :title="lang.modal.title">

            <form ref="form" method="post" :action="route" @submit.stop.prevent="handleSubmit">
                <slot></slot>
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
    </div>
</template>

<script>
export default {
    props: [
      'route'
    ],
    data() {
        return {
            name: '',
            nameState: null,
            submittedNames: [],
            lang: {
                btn: this.translate('docs.company.create.company'),
                modal: {
                    title: this.translate('docs.company.create.company'),
                    ok: this.translate('forms.create'),
                    cancel: this.translate('forms.cancel'),
                },
                form: {
                    name: {
                        feedback: this.translate('docs.company.create.form.validate.name.required'),
                        label: this.translate('docs.company.create.form.name.label'),
                        placeholder: this.translate('docs.company.create.form.name.placeholder'),
                    }
                }
            }
        }
    },
    methods: {
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            return valid
        },
        resetModal() {
            this.name = ''
            this.nameState = null
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault()
            this.handleSubmit()
        },
        handleSubmit() {
            if (!this.checkFormValidity()) {
                return
            }

            this.$refs.form.submit();

            this.$nextTick(() => {
                this.$bvModal.hide('modal-prevent-closing')
            })
        }
    }
}
</script>
