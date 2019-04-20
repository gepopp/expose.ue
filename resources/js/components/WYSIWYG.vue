<template>
    <div>
        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
        <input type="hidden" v-model="editorData" :name="this.name">
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        name: 'app',
        props: ['name', 'content'],
        data() {
            return {
                editor: ClassicEditor,
                editorData: this.content,
                editorConfig: {
                    removePlugins: [ 'Heading', 'Image' ],
                    toolbar: [ 'bold', 'italic', 'Link', 'blockQuote', 'NumberedList',  'BulletedList' ]
                },
            };
        }
    }
</script>
<style>
    .ck-editor__editable {
        min-height: 300px;
    }
</style>