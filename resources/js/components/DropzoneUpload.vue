<template>
    <div>
        <vue-dropzone id="dropzone" :options="dropzoneOptions"></vue-dropzone>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: "DropzoneUpload",
    props: ['action'],
    components: {
        vueDropzone: vue2Dropzone
    },
    data: function () {
        return {
            dropzoneOptions: {
                dictDefaultMessage: this.translate('projects.tasks.files.upload.message'),
                url: this.action,
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
