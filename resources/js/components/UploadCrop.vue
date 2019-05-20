<template>
    <div class="row">
        <div class="col-6">
            <clipper-fixed
                    :ratio="ratio"
                    class="my-clipper"
                    ref="clipper"
                    :src="imgURL"
                    @load="imageLoaded"
                    bg-color="white"
            ></clipper-fixed>

        </div>
        <div class="col-6 d-flex" v-if="!resultURL">
            <div class="loader bg-dark w-100 d-flex align-self-stretch align-items-center justify-content-center">
            </div>
        </div>
        <div class="col-6" v-if="resultURL">
            <img class="result img-fluid d-block" :src="resultURL" alt="">
        </div>
        <input type="hidden" name="file_data" :value="resultURL">
        <input type="hidden" name="file_changed" :value="fileChanged">
        <div class="col-12">
            <div class="mt-3">
                <clipper-upload v-model="imgURL" class="btn btn-primary btn-sm">hochladen</clipper-upload>
                <a @click="getResult" v-if="imgURL" class="btn btn-success btn-sm">zuschneiden</a>
            </div>
        </div>
    </div>
</template>
<script>
    import VuejsClipper from 'vuejs-clipper';
    import ClipperFixed from "vuejs-clipper/src/components/clipper-fixed";
    import ClipperBasic from "vuejs-clipper/src/components/clipper-basic";

    export default {
        name: "UploadCrop",
        props: ['ratio', 'existingimage'],
        components: {ClipperBasic, ClipperFixed, VuejsClipper},
        data: () => {
            return {
                src: [],
                imgURL: false,
                resultURL: '',
                fileChanged: false,
                spinner: false
            }
        },
        methods: {
            getResult: function () {
                const canvas = this.$refs.clipper.clip();//call component's clip method
                this.resultURL = canvas.toDataURL("image/jpg", 1);//canvas->image
                this.fileChanged = true;
                this.$eventHub.$emit('upload-done');

            },
            imageLoaded: (img) => {
            },

        },
        mounted() {

            this.$eventHub.$emit('upload-started', "Bitte ein Bild einfügen");
            if (typeof this.existingimage != "undefined") {
                this.resultURL = this.existingimage;
                this.imgURL = this.existingimage;
                this.$eventHub.$emit('upload-done');
            }
        }
    }
</script>

<style>

</style>