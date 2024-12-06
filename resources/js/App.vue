<template>
  <div class="viewer-container">
    <!-- Photo Viewer occupies the full screen -->
    <PhotoViewer @move="fetchPhoto" :photo="photo" />

    <!-- Map positioned in the bottom-right corner -->
    <Map :coordinates="coordinates" />
  </div>
</template>


<script>
import axios from "axios";
import PhotoViewer from "./components/PhotoViewer.vue";
import Map from "./components/Map.vue";

export default {
  components: { PhotoViewer, Map },
  data() {
    return {
      photo: {},
      coordinates: { lat: 0, lng: 0 },
    };
  },
  mounted() {
    this.fetchPhoto(window.photoData.id); // Fetch the first photo on load
  },
  methods: {
    fetchPhoto(id) {
      if (!id) return;
      axios.get(`/api/photos/${id}`).then((response) => {
        this.photo = response.data;
        this.coordinates = {
          lat: response.data.latitude,
          lng: response.data.longitude,
        };
      });
    },
    nextPhoto() {

    }
  },
};
</script>
<style>
.viewer-container {
  position: relative;
  width: 100%;
  height: 100vh; /* Full viewport height */
  overflow: hidden;
}

.viewer-container .map-container {
  position: absolute;
  bottom: 20px;
  right: 20px;
  width: 25%; /* Adjust as needed */
  height: 25%; /* Adjust as needed */
  z-index: 10; /* Ensure the map appears above the photo viewer */
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  border: 1px solid #ccc;
  background: #fff;
  border-radius: 4px;
}

.viewer-container .map-container:hover {
  /* Optional: Enlarge the map on hover */
  width: 35%;
  height: 35%;
}
</style>
