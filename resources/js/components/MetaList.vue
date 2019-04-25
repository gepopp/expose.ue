<template>
    <div class="root">
        <SlickList v-model="items" class="list-group-flush" @input="updateList">
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="list-group-item">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg></span>
                {{ item.name }}
            </SlickItem>
        </SlickList>
    </div>
</template>

<script>
    import {SlickList, SlickItem} from 'vue-slicksort';

    export default {
        name: "MetaList",
        props: ['metas'],
        components: {
            SlickItem,
            SlickList
        },
        data() {
            return {
                items: JSON.parse(this.metas),
            };
        },
        methods: {
            updateList(list) {
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