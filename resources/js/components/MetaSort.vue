<template>
    <div>
        <SlickList v-model="items" class="list-group-flush w-100" :useDragHandle="true" @input="updateList" >
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="list-group-item">
                <span v-handle class="handle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg>
                        </span>
                {{ item.name }}  {{ item.value }} {{ item.postfix }}
            </SlickItem>
        </SlickList>
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
                dragHandle: true
            };
        },
        methods: {
            updateList(list) {

                var ref = this;

                axios({
                    url: '/realestate/'+ref.realestateid+'/realEstateMeta/'+ref.metaid+'/sort',
                    method: "POST",
                    data: list
                })
            }
        }
    }

</script>

<style scoped>

</style>