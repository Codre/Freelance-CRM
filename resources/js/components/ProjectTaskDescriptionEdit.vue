<template>
    <div class="air-editor">
        <div id="air-editor">
            <slot></slot>
        </div>
        <b-badge class="status" variant="success" v-if="saved">{{ translate('ajax.saved') }}</b-badge>
        <b-badge class="status" variant="info" v-if="saving">{{ translate('ajax.saving') }}</b-badge>
    </div>
</template>

<script>
export default {
    name: "ProjectTaskDescriptionEdit",
    timeout: null,
    timeoutSaved: null,
    props: [
        'save_route'
    ],
    data() {
        return {
            saved: false,
            saving: false,
        };
    },
    mounted() {
        $('#air-editor').summernote({
            airMode: true,
            lang: 'ru-RU',
            callbacks: {
                onChange: function (contents, $editable) {
                    if (this.timeout) {
                        clearTimeout(this.timeout);
                    }
                    this.timeout = setTimeout(function () {
                        this.saving = true;
                        this.saved = false;

                        if (this.timeoutSaved) {
                            clearTimeout(this.timeoutSaved);
                        }

                        axios.patch(this.save_route, {
                            description: contents
                        }).then(function (response) {
                            this.saving = false;
                            this.saved = true;

                            this.timeoutSaved = setTimeout(function () {
                                this.saved = false;
                            }.bind(this), 3000);

                            if (!response.status) {
                                console.error(response);
                                swal(translate('errors.ajax.error.title'), translate('errors.ajax.error.message'), 'error');
                            }
                        }.bind(this)).catch(function (error) {
                            console.error(error);
                            swal(translate('errors.ajax.error.title'), translate('errors.ajax.error.message'), 'error');
                        });
                    }.bind(this), 3000);
                }.bind(this)
            }
        })
    }
}
</script>

<style scoped>
.air-editor {
    position: relative;
}

.air-editor .badge {
    position: absolute;
    bottom: 0;
    right: 0;
}
</style>
