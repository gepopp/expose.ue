<template>
    <div>
        <div class="row">
            <div class="col-6">
                <SlickList v-model="items" class="list-group-flush w-100" :useDragHandle="true" @input="updateList">
                    <SlickItem v-for="(item, index) in leftCol" :index="index" :key="index" class="list-group-item">
                <span v-handle class="handle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg>
                        </span>
                        {{ item.name }} {{ item.value }} {{ item.postfix }} -
                        <small v-text="item.column"></small>
                    </SlickItem>
                </SlickList>
            </div>
            <div class="col-6">
                <SlickList v-model="items" class="list-group-flush w-100" :useDragHandle="true" @input="updateList">
                    <SlickItem v-for="(item, index) in rightCol" :index="index" :key="index" class="list-group-item">
                <span v-handle class="handle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg>
                        </span>
                        {{ item.name }} {{ item.value }} {{ item.postfix }} -
                        <small v-text="item.column"></small>
                    </SlickItem>
                </SlickList>
            </div>
        </div>
    </div>
</template>

<script>
    import {SlickList, SlickItem, HandleDirective} from 'vue-slicksort';

    export default {
        name: "MetaSort",
        props: ['metas', 'metaid', 'realestateid'],
        directives: {handle: HandleDirective},
        components: {
            SlickItem,
            SlickList
        },
        data() {
            return {
                items: JSON.parse(this.metas),
                dragHandle: true,
            };
        },
        methods: {
            updateList(list) {

                var ref = this;

                axios({
                    url: '/realestate/' + ref.realestateid + '/realEstateMeta/' + ref.metaid + '/sort',
                    method: "POST",
                    data: list
                })
            }
        },
        computed: {
            leftCol: function(){
                var items = [];
                this.items.forEach(function (item) {
                    if(item.column == "left" || !item.column ){
                        items.push(item);
                    }
                });
                return items;
            },
            rightCol: function(){
                var items = [];
                this.items.forEach(function (item) {
                    if(item.column == "right"){
                        items.push(item);
                    }
                });
                return items;
            }
        }
    }

</script>

<style scoped>

</style>