<template>
    <div class="row">
        <SlickList lockAxis="y" v-model="items" class="list-group-flush" @input="updateList" :useDragHandle="true" style="max-height: 500px;overflow-x:scroll">
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="col-4">
                {{ item.name}}
            </SlickItem>
        </SlickList>
    </div>
</template>

<script>
    import {SlickList, SlickItem, HandleDirective} from 'vue-slicksort';
    export default {
        name: "MetaForm",
        directives: {handle: HandleDirective},
        props: ['metas'],
        components: {
            SlickItem,
            SlickList,
        },
        data() {
            return {
                items: JSON.parse(this.images),
                handle: true,
                useWindowAsScrollContainer: true

            };
        },
    }
</script>

<style scoped>

</style>