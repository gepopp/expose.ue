<template>
    <div>
        <SlickList v-model="items" class="list-group-flush w-100" :useDragHandle="true" @input="updateList">
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="list-group-item">
                <span v-handle class="handle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg></span>
                <span class="px-3">
                    <input type="checkbox" v-model="item.print" :disabled="!item.isPublic">
                </span>
                <strong>{{ item.kind }}</strong> {{ item.name }} <small>( {{ !item.isPublic ? 'nicht öffetnlich' : 'öffetnlich' }} )</small>

            </SlickItem>
        </SlickList>
        <button class="btn btn-success mt-5" @click="createPdf">erzeugen</button>
    </div>
</template>

<script>
    import {SlickList, SlickItem, HandleDirective} from 'vue-slicksort';

    export default {
        name: "PdfCreator",
        props: ['realestate', 'csrfToken'],
        directives: {handle: HandleDirective},
        components: {
            SlickItem,
            SlickList
        },
        data() {
            return {
                items: [],
                dragHandle: true,
                formurl: ''
            };
        },
        methods: {
            updateList(list) {
            },
            createPdf() {
                axios({
                    url: this.formurl,
                    method: 'POST',
                    data: this.items,
                    responseType: 'blob' //Force to receive data in a Blob Format
                }).then(response => {
                        const file = new Blob(
                            [response.data],
                            {type: 'application/pdf'});
                            const fileURL = URL.createObjectURL(file);
                        window.open(fileURL);
                    }).catch(error => {
                        console.log(error);
                    });
            }

        },
        mounted() {

            var realEstate = JSON.parse(this.realestate);

            this.formurl = '/pdfSortSelect/realEstate/' + realEstate.id + '/create';

            var items = this.items;

            this.items.push({
                'kind': 'Titelseite',
                'name': realEstate.name,
                object: 'TitlePage',
                'id': realEstate.id,
                print: true,
                isPublic: true
            });

            realEstate.meta.forEach(function (meta) {
                items.push({'kind': 'Daten Seite', 'name': meta.name, object: 'MetaPage', 'id': meta.id, print: meta.is_public, isPublic: meta.is_public});
            })

            realEstate.text.forEach(function (meta) {
                items.push({'kind': 'Textseite', 'name': meta.name, object: 'TextPage', 'id': meta.id, print: meta.is_public, isPublic: meta.is_public});
            })

            realEstate.location.forEach(function (meta) {
                items.push({
                    'kind': 'Lageseite',
                    'name': meta.name,
                    object: 'LocationPage',
                    'id': meta.id,
                    print: meta.is_public,
                    isPublic: meta.is_public
                });
            })

            realEstate.gallery.forEach(function (meta) {
                items.push({'kind': 'Bildseite', 'name': meta.name, object: 'ImagePage', 'id': meta.id, print: meta.is_public, isPublic: meta.is_public});
            })
        }
    }
</script>

<style scoped>

</style>