// FileUpload.vue

<template>
    <div :class="{ 'single-upload' : this.maxfiles == '1'}">
        <vue-dropzone
                id="drop1"
                ref="uploader"
                :options="config"
                @vdropzone-complete="afterComplete"
                @vdropzone-success="uploaded"
                @vdropzone-removed-file="remove"
                @vdropzone-mounted="prepopulate"
                @vdropzone-processing="processing"
        ></vue-dropzone>
        <input type="hidden" :value="upload_id" name="file_id">
    </div>
</template>


<script>
    import vueDropzone from "vue2-dropzone";
    export default {
        components: { vueDropzone },
        props: ['mfile', 'folder', 'uploadable', 'uploadableid', 'maxfiles'],
        data: () => ({
            config: {
                url: 'file',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                withCredentials: true,
                dictDefaultMessage: 'Datei hier ablegen.',
                addRemoveLinks: true,
                //acceptedMimeTypes: 'image/*',
                dictRemoveFile: 'Bild löschen',
                thumbnailWidth: null,
                thumbnailHeight: null,
            },
            upload_id: []
        }),
        methods: {
            uploaded(file, response) {
                this.upload_id.push(response.id);
                file.id = response.id;
            },
            remove(file, error, xhr) {
                axios({
                    url: '/file/' + file.id,
                    method: 'DELETE',
                });
                this.upload_id = this.upload_id.filter(function (ele) {
                    return ele != file.id;
                });
            },
            processing(file) {
                this.$eventHub.$emit('upload-started', "Warte auf Upload");
            },
            afterComplete() {
                this.$eventHub.$emit('upload-done');
            },
            prepopulate() {

                if (this.mfile == "null" || typeof this.mfile == "undefined") return true;
                var files = JSON.parse(this.mfile);
                var uploader = this.$refs.uploader;
                var upload_id = this.upload_id;
                var maxfiles = this.maxfiles;

                files.forEach(function (file) {


                    var thumb = maxfiles == "1" ?  file.path : file.thumb_name;

                    uploader.manuallyAddFile({
                        size: file.size,
                        name: file.name,
                        type: file.type,
                        id: file.id
                    }, 'https://uehlein-expose.s3.eu-central-1.amazonaws.com/' + thumb );
                    upload_id.push(file.id);
                });
            }

        },
        mounted: function () {

            this.$refs.uploader.setOption('thumbnailWidth', 150);
            this.$refs.uploader.setOption('thumbnailHeight', 150);

            if(typeof this.uploadable != "undefined" && typeof this.uploadableid != 'undefined'){
                this.$refs.uploader.setOption('url', '/file/'+this.folder+'/' + this.uploadable + '/' + this.uploadableid);
            }else{
                this.$refs.uploader.setOption('url', '/file/' + this.folder);
            }
            this.$refs.uploader.setOption('maxFiles', this.maxfiles);

        },
    };
</script>
<style>
    .single-upload .dropzone .dz-preview {
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin: 0;
        width: 100%;
        min-height: 100px;
    }

    .single-upload .dropzone .dz-preview .dz-image {
        border-radius: 0;
        overflow: hidden;
        width: 100%;
        height: auto;
        position: relative;
        display: block;
        z-index: 10;
    }

    .single-upload .dropzone .dz-preview .dz-image img {
        display: block;
        width: 100%;
        height: auto;

    }
    .dropzone .dz-preview .dz-image {
        border-radius: 0;
    }
</style>