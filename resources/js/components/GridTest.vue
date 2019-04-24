<template>
    <div>
        <grid
                :draggable="true"
                :sortable="true"
                :items="items"
                :height="100"
                :width="100">
            <template slot="cell" scope="props">
                <div>hello</div>
            </template>
        </grid>
    </div>
</template>

<script>
    import Grid from 'vue-js-grid';

    export default {
        name: "GridTest",
        components: {
            Grid
        },
        props:{
            items: ['hello', 'world']
        }
    }
</script>
