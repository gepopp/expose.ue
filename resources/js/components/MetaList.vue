<template>
    <div class="root">
        <SlickList lockAxis="y" v-model="items" class="list-group-flush" @input="updateList">
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="list-group-item">
                <span class="mr-2">{{ index }}</span><span class="float-right">{{ item.name }} ( {{ item.postfix }} )</span>
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
                dragHandle: true
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