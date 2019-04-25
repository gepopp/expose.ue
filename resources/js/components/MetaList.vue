<template>
    <div class="root">
        <SlickList v-model="items" class="list-group-flush" @input="updateList">
            <SlickItem  v-for="(item, index) in items" :index="index" :key="index" class="list-group-item">
                {{ item.name }}
            </SlickItem>
        </SlickList>
    </div>
</template>

<script>
    import { SlickList, SlickItem } from 'vue-slicksort';

    export default {
        name: "MetaList",
        props: ['metas'],
        components: {
            SlickItem,
            SlickList
        },
        data(){
            return {
                items: JSON.parse(this.metas),
            };
        },
        methods:{
            updateList(list){
                axios({
                    url: '/api/metasort',
                    method: 'POST',
                    data: list
                });
            }
        }
    }

</script>

<style scoped>

</style>