<template>
    <div class="root">
        <SlickList v-model="items" class="row" @input="updateList">
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="col-4">
                    <div class="form-group">
                        <label for="inlineFormInputGroup">{{ item.name }}</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="inlineFormInputGroup">
                            <div class="input-group-append">
                                <div class="input-group-text">{{ item.postfix }}</div>
                            </div>
                        </div>
                    </div>
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