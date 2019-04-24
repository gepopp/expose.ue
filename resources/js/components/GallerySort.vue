<template>
    <div class="root">
        <SlickList lockAxis="y" v-model="items" class="list-group-flush" @input="updateList" :useDragHandle="true" style="max-height: 500px;overflow-x:scroll">
            <SlickItem v-for="(item, index) in items" :index="index" :key="index" class="list-group-item">

                <div class="row">
                    <div class="col-1">
                         <span v-handle class="handle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg>
                        </span>
                    </div>
                    <div class="col-2">
                        <img :src="get_url(item)" class="mr-3">
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            <label>Bildunterschrift</label>
                            <input type="text" class="form-control" v-model.lazy="item.alt" @blur="save(item)">
                        </div>
                    </div>
                </div>
            </SlickItem>
        </SlickList>

    </div>
</template>

<script>
    import {SlickList, SlickItem, HandleDirective} from 'vue-slicksort';
    export default {
        name: "GallerySort",
        directives: {handle: HandleDirective},
        props: ['images'],
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
        methods: {
            updateList(list) {
                axios({
                    url: '/sort/gallery',
                    method: "POST",
                    data: list

                });
            },
            get_url(item) {
                return "https://uehlein-expose.s3.eu-central-1.amazonaws.com/" + item.thumb_name;
            },
            save(item){
                axios({
                    url: '/file/' + item.id,
                    method: 'PUT',
                    data: item
                });
            }
        },

    }

</script>

<style>
   body{
       max-height: 100vh;
   }
</style>