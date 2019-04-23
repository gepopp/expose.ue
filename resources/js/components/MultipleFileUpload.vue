// FileUpload.vue

<template>
    <div>
        <vue-dropzone
                id="drop1"
                ref="gallery"
                :options="config"
                @vdropzone-queue-complete="afterComplete"
                @vdropzone-processing="processing"
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
        props: ['mfile', 'estate'],
        data: () => (
            {
            config: {
                url: "/api/file/galleryimages/realEstate/",
                dictDefaultMessage: 'Dateien hier ablegen.',
                addRemoveLinks: true,
                acceptedMimeTypes: 'image/*',
                thumbnailWidth: 150,
                thumbnailHeight: 150,
                dictRemoveFile: 'Bild löschen',
                maxFiles: 10
            },
            upload_id: [],
        }),
        components: {
            vueDropzone
        },
        methods: {

            uploaded(file, response) {
                this.upload_id.push(response.id);
                file.id = response.id;
            },
            remove(file, error, xhr) {

                axios({
                    url: '/api/file/' + file.id + '/destroy',
                    method: 'DELETE'
                });
                this.upload_id = this.upload_id.filter(function (ele) {
                    return ele != file.id;
                });
            },
            prepopulate() {

                if (typeof this.mfile == "undefined") return true;
                var files = JSON.parse(this.mfile);
                var gallery = this.$refs.gallery;
                var uploads = this.upload_id;

                files.forEach(function (file, index) {
                    gallery.manuallyAddFile({
                        size: file.size,
                        name: file.name,
                        type: file.type,
                        id: file.id
                    }, 'https://uehlein-expose.s3.eu-central-1.amazonaws.com/' + file.path);
                    uploads.push(file.id);
                })

            },
            processing(file) {
                this.$eventHub.$emit('upload-started');
            },
            afterComplete() {
                this.$eventHub.$emit('upload-done');

            },
        },
        mounted: function () {

        }
    };
</script>