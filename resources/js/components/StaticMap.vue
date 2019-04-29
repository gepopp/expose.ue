<template>

    <div>
        <img  :src="url" class="img-thumbnail img-fluid">
    </div>

</template>

<script>
    export default {
        name: "StaticMap",
        props: ['latlng', 'marker', 'radius', 'zoom', 'type', 'marker_location'],
        data(){
          return{
              url: ''
          }
        },
        methods: {
            GMapCircle(lat, lng, clat, clng, rad, detail = 8) {

                var uri = 'https://maps.googleapis.com/maps/api/staticmap?';
                var staticMapSrc = 'center=' + lat + ',' + lng;
                staticMapSrc += '&size=500x500';
                staticMapSrc += '&zoom=' + this.zoom;
                staticMapSrc += '&maptype=' + this.type;

                staticMapSrc += '&path=color:0xff0000:weight:0|fillcolor:0xff000055';
                var r = 6371;
                var pi = Math.PI;
                var _lat = (clat * pi) / 180;
                var _lng = (clng * pi) / 180;
                var d = (rad / 1000) / r;
                var i = 0;
                for (i = 0; i <= 360; i += detail) {
                    var brng = i * pi / 180;
                    var pLat = Math.asin(Math.sin(_lat) * Math.cos(d) + Math.cos(_lat) * Math.sin(d) * Math.cos(brng));
                    var pLng = ((_lng + Math.atan2(Math.sin(brng) * Math.sin(d) * Math.cos(_lat), Math.cos(d) - Math.sin(_lat) * Math.sin(pLat))) * 180) / pi;
                    pLat = (pLat * 180) / pi;
                    staticMapSrc += "|" + pLat + "," + pLng;
                }
                staticMapSrc += '&key=AIzaSyADsKyn2Dw9q_cQyxs30OfklCMwOXzhSow';
                return uri + encodeURI(staticMapSrc);
            }
        },
        mounted() {

         if(this.marker == 2){
             var split = this.latlng.split(',');
             var csplit = this.marker_location.split(',')
             this.url = this.GMapCircle(split[0], split[1], csplit[0], csplit[1], this.radius);
         }else if(this.marker == 1 ){
             this.url =  "https://maps.googleapis.com/maps/api/staticmap?center=" + this.latlng
                 + "&zoom=" + this.zoom
                 + "&maptype=" + this.type
                 + "&markers=color:red,label:*|" + this.marker_location
                 + "&size=500x500&key=AIzaSyADsKyn2Dw9q_cQyxs30OfklCMwOXzhSow";
            }else {
             this.url =  "https://maps.googleapis.com/maps/api/staticmap?center=" + this.latlng
                 + "&zoom=" + this.zoom
                 + "&maptype=" + this.type
                 + "&size=500x500&key=AIzaSyADsKyn2Dw9q_cQyxs30OfklCMwOXzhSow";
         }
        }
    }
</script>

<style scoped>

</style>