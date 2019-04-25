<template>
    <div>
        <label>Karte</label>
        <GmapMap style="height: 500px;"
                 :zoom="zoom"
                 :center="{lat: 0, lng: 0}"
                 :mapTypeId="type
"
                 ref="mapRef"
                 @maptypeid_changed="typeChanged"
                 :options="{
                       zoomControl: false,
                       mapTypeControl: true,
                       scaleControl: false,
                       streetViewControl: false,
                       rotateControl: false,
                       fullscreenControl: false,
                       disableDefaultUi: false
                    }">
            <GmapMarker v-if="this.place && !this.circle" label="★" :position="{
          lat: this.place.geometry.location.lat(),
          lng: this.place.geometry.location.lng(),
        }"/>
            <GmapCircle
                    v-if="this.place && this.circle"
                    :center="{
          lat: this.place.geometry.location.lat(),
          lng: this.place.geometry.location.lng(),
        }"
                    :radius="this.umkreis"
                    :visible="true"
                    :options="{fillColor:'red',fillOpacity:.5,strokeColor: '#FF0000', strokeOpacity: 0.8,}"
            ></GmapCircle>
        </GmapMap>
        <GmapAutocomplete class="form-control" @place_changed="setPlace"></GmapAutocomplete>
        <label>Zoom</label>
        <input type="number" v-model.number="zoom" class="form-control" name="zoom">
        <input type="radio" id="two" :value="false" v-model="circle">
        <label for="two">Stecknadel</label>
        <br>
        <input type="radio" id="one" :value="true" v-model="circle">
        <label for="one">Umkreis</label>
        <br>
        <div v-if="circle">
            <label>Umkreis</label>
            <input type="number" v-model.number="umkreis" class="form-control" name="radius">
        </div>
        <input v-model="type" type="hidden" name="type">
        <input :value="circle ? 'Umkreis':'Stecknadel'" type="hidden" name="marker">
        <input v-model="latlng" type="hidden" name="lat_lng">
    </div>
</template>

<script>
    export default {
        name: "LocationMap",
        props: ['old_zoom', 'location', 'radius', 'marker_type', 'maptype'],
        data() {
            return {
                markers: [],
                place: null,
                circle: false,
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
                this.$refs.mapRef.panTo(place.geometry.location);
                this.zoom = 14;
                this.$eventHub.$emit('upload-done');
            },
            typeChanged(type) {
                this.type = type;
            }
        },
        mounted() {
            this.$eventHub.$emit('upload-started', "Bitte einen Standort eingeben");


            if(this.marker_type == "Umkreis"){
                this.circle = true;
            }

            if(this.radius){
                this.umkreis = parseInt(this.radius);
            }

            if(this.old_zoom){
                this.zoom = this.old_zoom
            }

            console.log(this.maptype);

            if(this.maptype){
                console.log(this.maptype);
                this.type = this.maptype;
            }

            var ref = this;


            if(this.location){
                var split = this.location.split(',');
                this.$refs.mapRef.$mapPromise.then((map) => {
                    var gc = new google.maps.Geocoder();
                    gc.geocode({location: {lat: parseFloat(split[0]), lng: parseFloat(split[1])}}, function(results){
                        ref.setPlace(results[0]);
                    })
                });


            }


        },
    }
</script>

<style scoped>

</style>