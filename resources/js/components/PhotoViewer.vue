<template>
  <div id="photo-viewer" class="photo-viewer"></div>
</template>

<script>
import { Viewer } from 'photo-sphere-viewer';
import { shallowRef } from 'vue';
import {MarkersPlugin} from 'photo-sphere-viewer/dist/plugins/markers';

export default {
  props: ['photo'],
  setup(props, { emit }) {
    const viewer = shallowRef(null);
    const angle = shallowRef(null);
    const initializeViewer = (photoUrl, photoId, movements) => {
      if (viewer.value) {
        viewer.value.destroy(); // Destroy previous instance
      }
      viewer.value = new Viewer({
        container: document.getElementById('photo-viewer'),
        panorama: photoUrl,
        plugins: [
          [MarkersPlugin], // Enable the Markers Plugin
        ],
        navbar: false,
        caption: '360° View',
      });

      if(viewer.value !== null) {
        const markersPlugin = viewer.value.getPlugin(MarkersPlugin);

        movements.forEach(item => {
          markersPlugin.addMarker({
            id: item.id,
            longitude: item.pivot.angle,
            latitude: '0deg',
            image: '/pin-blue.png',
            width: 30,
            height: 30,
            orientation: 'vertical-right',
          });

          // Handle click events for the marker
          markersPlugin.on('select-marker', (e, marker) => {
            if (marker.id === item.id) {
              emit('move', item.id);
              console.log(item.id);
            }
          });
        })

      }
    };


    return {
      viewer,
      initializeViewer,
      angle
    };
  },
  watch: {
    photo: {
      immediate: true,
      handler(newPhoto) {
        if (newPhoto?.url) {
          this.initializeViewer(newPhoto.url, newPhoto.id, newPhoto.movements);
        }
      },
    },
  },
  beforeUnmount() {
    if (this.viewer) {
      this.viewer.destroy(); // Clean up the viewer instance
    }
  },
};
</script>

<style>
.psv-marker{
  background-size: cover;
}
 .photo-viewer {
   width: 100%;
   height: 100%;
 }
</style>
