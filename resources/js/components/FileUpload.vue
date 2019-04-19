// FileUpload.vue

<template>
    <div>
        <vue-dropzone
                id="drop1"
                ref="titleimage"
                :options="config"
                @vdropzone-complete="afterComplete"
                @vdropzone-success="uploaded"
                @vdropzone-removed-file="remove"
                @vdropzone-mounted="prepopulate"
        ></vue-dropzone>
        <input type="hidden" :value="upload_id" name="titleimage_id">
    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";

    export default {
        props: ['mfile'],
        data: () => ({
            config: {
                url: "/api/file",
                dictDefaultMessage: 'Titelbild hier ablegen.',
                addRemoveLinks: true,
                acceptedMimeTypes: 'image/*',
                thumbnailWidth: null,
                thumbnailHeight: null,

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
                this.upload_id = '';


            },
            prepopulate(){


                if(typeof this.mfile == "undefined") return true;
                    var file = JSON.parse(this.mfile);
                    this.$refs.titleimage.manuallyAddFile({size: file.size, name: file.name, type: file.type }, 'https://uehlein-expose.s3.eu-central-1.amazonaws.com/' + file.path);
                    this.upload_id = file.id;

            }
        },
        mounted: function () {

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