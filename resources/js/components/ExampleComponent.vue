
<template>
  <div class="container">
    <button class="btn btn-success" @click="updateLocation">Update Location</button>
    <div class="card-body">
      <div id="map" style="width:700px;height:500px;"></div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      map: null,
      marker: null,
      center: { lat: -25.344, lng: 131.036 },
      data: null,
      coordinates: []
    };
  },

  methods: {
    initMap() {
      this.map = new google.maps.Map(document.getElementById("map"), {
        center: this.center,
        zoom: 4
      });
      this.marker = new google.maps.Marker({
        map: this.map,
        position: this.center,
        animation: "bounce"
      });
    },

    updateMap() {
      let newPosition = { lat: this.data.lat, lng: this.data.long };
      this.map.setCenter(newPosition);
      this.marker.setPosition(newPosition);
      this.coordinates.push(
        new google.maps.LatLng(newPosition.lat, newPosition.lng)
      );
      var linePath = new google.maps.Polyline({
        path: this.coordinates,
        geodsic: true,
        map: this.map,
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 2
      });
    },
    updateLocation() {
      let randomNumber = Math.random();
      let position = {
        lat: 23.8103 + randomNumber,
        long: 90.4125 + randomNumber
      };
      axios.post("/api/map", position);
    }
  },

  mounted() {
    console.log("Component mounted.");
    this.initMap();
  },

  created() {
    Echo.private("send-location-channel").listen("SendLocationEvent", e => {
      this.data = e.location;
      this.updateMap();
      console.log(e);
    });
  }
};
</script>
