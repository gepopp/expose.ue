<template>
    <div>
        <SlickList v-model="items" class="list-group-flush w-100" :useDragHandle="true" @input="updateList">
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="list-group-item">
                <span v-handle class="handle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg></span>
                <span class="px-3">
                    <label :for="index">
                        <input type="checkbox" v-model="item.print" :disabled="!item.isPublic" :id="index">
                         <strong>{{ item.kind }}</strong>
                    </label>
                </span>
                {{ item.name }} <small>( {{ !item.isPublic ? 'nicht öffetnlich' : 'öffetnlich' }} )</small>

            </SlickItem>
        </SlickList>
        <div class="d-flex">
            <div>
                <button class="btn btn-success mt-3" @click="createPdf">erzeugen</button>
            </div>
            <div class="lds-facebook" v-if="loading"><div></div><div></div><div></div></div>
            <a :href="download" v-if="download != ''">download</a>
        </div>
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
                formurl: '',
                loading: false,
                download: ''
            };
        },
        methods: {
            updateList(list) {
            },
            createPdf() {
                this.loading = true;
                var ref = this;

                axios({
                    url: this.formurl,
                    method: 'POST',
                    data: this.items,
                    //responseType: 'blob' //Force to receive data in a Blob Format
                }).then(response => {

                    ref.download = response.data;
                    ref.loading = false;
                    //
                    // const file = new Blob(
                    //         [response.data],
                    //         {type: 'application/pdf'});
                    //         const fileURL = URL.createObjectURL(file);
                    //     window.open(fileURL);

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
    .lds-facebook {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
    }
    .lds-facebook div {
        display: inline-block;
        position: absolute;
        left: 6px;
        width: 13px;
        background: grey;
        animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
    }
    .lds-facebook div:nth-child(1) {
        left: 6px;
        animation-delay: -0.24s;
    }
    .lds-facebook div:nth-child(2) {
        left: 26px;
        animation-delay: -0.12s;
    }
    .lds-facebook div:nth-child(3) {
        left: 45px;
        animation-delay: 0;
    }
    @keyframes lds-facebook {
        0% {
            top: 6px;
            height: 51px;
        }
        50%, 100% {
            top: 19px;
            height: 26px;
        }
    }

</style>