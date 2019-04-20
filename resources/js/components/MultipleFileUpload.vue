// FileUpload.vue

<template>
    <div>
        <vue-dropzone
                id="drop1"
                ref="gallery"
                :options="config"
                @vdropzone-complete="afterComplete"
                @vdropzone-success="uploaded"
                @vdropzone-removed-file="remove"
                @vdropzone-mounted="prepopulate"
        ></vue-dropzone>
        <input type="hidden" :value="upload_id" name="uploaded">
    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";
    export default {
        props: ['mfile'],
        data: () => ({
            config: {
                url: "/api/file",
                dictDefaultMessage: 'Dateien hier ablegen.',
                addRemoveLinks: true,
                acceptedMimeTypes: 'image/*',
                thumbnailWidth: 150,
                thumbnailHeight: 150,
                dictRemoveFile: 'Bild löschen',
                maxFiles: 10

            },
            upload_id: []
        }),
        components: {
            vueDropzone
        },
        methods: {
            afterComplete(file, response) {
            },
            uploaded(file, response){
                this.upload_id.push( response.id );
            },
            remove(file, error, xhr){

                // axios.post({
                //     url: '/api/file/' + this.upload_id + '/destroy',
                // });
                // this.upload_id.filter(function(ele){
                //     return ele != value;
                // });


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