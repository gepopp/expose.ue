// FileUpload.vue

<template>
    <div>
        <vue-dropzone id="drop1" :options="config" @vdropzone-complete="afterComplete" @vdropzone-success="uploaded" @vdropzone-removed-file="remove"></vue-dropzone>
        <input type="hidden" :value="upload_id" name="titleimage_id">
    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";

    export default {
        data: () => ({
            config: {
                url: "/api/file",
                dictDefaultMessage: 'Titelbild hier ablegen.',
                addRemoveLinks: true,
                thumbnailWidth: 650,
                acceptedMimeTypes: 'image/*',

            },
            upload_id: 0
        }),
        components: {
            vueDropzone
        },
        methods: {
            afterComplete(file, response) {
            },
            uploaded(file, response){
                this.upload_id = response.id;
            },
            remove(file, error, xhr){

                axios({
                    url: '/api/file/' + this.upload_id + '/destroy',
                    method: 'DELETE',
                });


            }

        }
    };
</script>
<style>
    .dropzone .dz-preview {
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin: 0;
        width: 100%;
        min-height: 100px;
    }
    .dropzone .dz-preview .dz-image {
        border-radius: 20px;
        overflow: hidden;
        width: 100%;
        height: auto;
        position: relative;
        display: block;
        z-index: 10;
    }
    .dropzone .dz-preview .dz-image img {
        display: block;
        width: 100%;
        height: auto;

    }
</style>