<template>
    <div>
        <div class="row">
            <div class="col-6">
                <SlickList v-model="leftCol" class="list-group-flush w-100" :useDragHandle="true" @input="updateList">
                    <SlickItem v-for="(item, index) in leftCol" :index="index" :key="index" class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span v-handle class="handle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg></span>
                                {{ item.name }} {{ item.value }} {{ item.postfix }}
                            </div>
                            <div>
                                <a @click="moveTo(index, item)">
                                    <img src="/img/double_arrow.svg" width="25" height="25" >
                                </a>
                            </div>
                        </div>
                    </SlickItem>
                </SlickList>
            </div>
            <div class="col-6">
                <SlickList v-model="rightCol" class="list-group-flush w-100" :useDragHandle="true" @input="updateList">
                    <SlickItem v-for="(item, index) in rightCol" :index="index" :key="index" class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                               <span v-handle class="handle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 9H4v2h16V9zM4 15h16v-2H4v2z"/></svg></span>
                                {{ item.name }} {{ item.value }} {{ item.postfix }}
                            </div>
                            <div>
                                <a @click="moveTo(index, item)">
                                    <img src="/img/double_arrow.svg" width="25" height="25" >
                                </a>
                            </div>
                        </div>
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
                rightCol: [],
                leftCol: []
            };
        },
        methods: {
            updateList(list) {
                var ref = this;
                axios({
                    url: '/realestate/' + ref.realestateid + '/realEstateMeta/' + ref.metaid + '/sort',
                    method: "POST",
                    data: ref.leftCol.concat(ref.rightCol),
                    rightCol: [],
                })
            },
            moveTo(index, item){



                if(item.column == "left"){
                    item.column = "right";
                    this.rightCol.push(item);
                    this.leftCol.splice(index, 1);
                } else {
                    item.column = "left";
                    this.leftCol.push(item);
                    this.rightCol.splice(index, 1);

                }
                this.updateList(null);
            }
        },
        mounted: function(){

            let ref = this;
            this.items.forEach(function(item){
                if(item.column ==  "left"){
                    ref.leftCol.push(item);
                } else {
                    ref.rightCol.push(item);

                }
            })

        }
    }

</script>

<style scoped>

</style>