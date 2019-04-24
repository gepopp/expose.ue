<template>
    <div class="root">
        <SlickList v-model="items" class="row">
            <SlickItem :axis="xy" v-for="(item, index) in items" :index="index" :key="index" class="col-4">

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