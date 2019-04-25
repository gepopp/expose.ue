<template>
    <div>
        <div class="form-group mb-0 mt-3">
            <button type="submit" class="btn btn-primary btn-sm btn-block" :disabled="disabled">
                {{ buttonText }}
            </button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "UploadLockedSubmitButton",
        data: function () {
            return {
                disabled: false,
                buttonText: "speichern"
            }
        },
        created(){
            this.$eventHub.$on('upload-started', this.disable);
            this.$eventHub.$on('upload-done', this.enable);

        },
        methods:{
            disable(event){
                this.disabled = true;
                this.buttonText = event;
            },
            enable(){
                this.disabled = false;
                this.buttonText = "speichern"
            }
        }

    }
</script>

<style scoped>

</style>