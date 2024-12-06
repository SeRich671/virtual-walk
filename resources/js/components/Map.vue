<template>
  <div id="map" class="map-container"></div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css'; // Import Leaflet styles

export default {
  props: ['coordinates'], // Accepts latitude and longitude as props
  data() {
    return {
      map: null, // The Leaflet map instance
      marker: null, // Marker instance
    };
  },
  mounted() {
    this.initializeMap();
  },
  watch: {
    coordinates: {
      deep: true, // Watch for changes in the coordinates prop
      handler(newCoords) {
        if (this.marker && this.map) {
          // Update the marker's position
          this.marker.setLatLng([newCoords.lat, newCoords.lng]);
          // Update the map's view to the new coordinates
          this.map.setView([newCoords.lat, newCoords.lng], 18); // Adjust zoom if needed
        }
      },
    },
  },
  methods: {
    initializeMap() {
      // Initialize the map and set its initial view to the passed coordinates
      this.map = L.map('map').setView([this.coordinates.lat, this.coordinates.lng], 16);

      // Add a tile layer from OpenStreetMap
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);

      // Add a marker to the map at the initial coordinates
      this.marker = L.marker([this.coordinates.lat, this.coordinates.lng]).addTo(this.map);
    },
  },
};
</script>
