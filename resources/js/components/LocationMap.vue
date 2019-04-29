<template>
    <div>
        <label>Karte</label>
        <GmapMap style="height: 500px;"
                 :zoom="zoom"
                 :center="{lat: 0, lng: 0}"
                 :mapTypeId="type"
                 ref="mapRef"
                 @maptypeid_changed="typeChanged"
                 @center_changed="centerChanged"
                 @zoom_changed="zoomChanged"
                 :options="{
                       zoomControl: false,
                       mapTypeControl: true,
                       scaleControl: false,
                       streetViewControl: false,
                       rotateControl: false,
                       fullscreenControl: false,
                       disableDefaultUi: false
                    }">
            <GmapMarker v-if="this.marker_type == 1" label="★" :position="this.marker_location"/>
            <GmapCircle
                    v-if="this.marker_type == 2"
                    :center="this.marker_location"
                    :radius="this.umkreis"
                    :visible="true"
                    :options="{fillColor:'red',fillOpacity:.5,strokeColor: '#FF0000', strokeOpacity: 0.8,}"
            ></GmapCircle>
        </GmapMap>
        <GmapAutocomplete class="form-control" @place_changed="setPlace"></GmapAutocomplete>
        <label>Zoom</label>
        <input type="number" v-model.number="zoom" class="form-control" name="zoom">
        <input type="radio" id="two" :value="0" v-model="marker_type">
        <label for="two">Keine Markierung</label>
        <br>
        <input type="radio" id="one" :value="1" v-model="marker_type">
        <label for="one">Nadel</label>
        <br>
        <input type="radio" id="three" :value="2" v-model="marker_type">
        <label for="three">Umkreis</label>
        <br>

        <div v-if="this.marker_type == 2">
            <label>Umkreis</label>
            <input type="number" v-model.number="umkreis" class="form-control" name="radius" min="50">
        </div>
        <input v-model="type" type="hidden" name="type">
        <input :value="this.marker_type" type="hidden" name="marker">
        <input v-model="latlng" type="hidden" name="lat_lng">
        <input v-model="markerPosString" type="hidden" name="marker_location">
    </div>
</template>

<script>
    export default {
        name: "LocationMap",
        props: ['old_zoom', 'location', 'radius', 'marker', 'maptype', 'marker_pos'],
        data() {
            return {
                markers: [],
                place: null,
                marker_type: 1,
                marker_location: '',
                zoom: 1,
                umkreis: 100,
                type: 'roadmap',
                latlng: ''
            }
        },
        description: 'Autocomplete Example (#164)',
        methods: {
            setPlace(place) {
                this.place = place;
                this.latlng = this.place.geometry.location.lat() + ',' + this.place.geometry.location.lng();
                this.marker_location = { lat: this.place.geometry.location.lat(), lng: this.place.geometry.location.lng() };
                this.$refs.mapRef.panTo(place.geometry.location);
                this.$eventHub.$emit('upload-done');
            },
            typeChanged(type) {
                this.type = type;
            },
            centerChanged(center){
                this.latlng = center.lat() + ',' + center.lng();
            },
            zoomChanged(zoom){
                this.zoom = zoom;
            }
        },
        mounted() {
            this.$eventHub.$emit('upload-started', "Bitte einen Standort eingeben");


            if(this.marker_type == "Umkreis"){
                this.circle = true;
            }

            if(this.radius){

                this.umkreis = parseInt(this.radius) < 50 ? 50 : parseInt(this.radius) ;
            }

            if(this.old_zoom){
                this.zoom = this.old_zoom
            }


            if(this.maptype){
                this.type = this.maptype;
            }

            if(this.marker){
                this.marker_type = this.marker;
            }

            var instance = this;

            if(this.location){

                this.latlng = this.location;
                var split = this.location.split(',');
                var ref = this;


                this.$refs.mapRef.$mapPromise.then((map) => {
                    instance.$eventHub.$emit('upload-done');

                    map.setCenter({
                       lat: parseFloat(split[0]),
                       lng: parseFloat(split[1])
                    });
                    if(instance.marker_pos){

                        split = instance.marker_pos.split(',');
                        instance.marker_location = {
                            lat: parseFloat(split[0]),
                            lng: parseFloat(split[1])
                        }
                    }


                });
            }
        },
        computed:{
            markerPosString(){

                if(this.marker_location.lat && this.marker_location.lng){
                    return this.marker_location.lat + ',' + this.marker_location.lng;
                }
                return false;
            }
        },

    }
</script>

<style scoped>

</style>