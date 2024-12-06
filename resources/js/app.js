import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';

// Import your Vue components
import PhotoViewer from './components/PhotoViewer.vue';
import Map from './components/Map.vue';
import App from './App.vue'
import 'photo-sphere-viewer/dist/photo-sphere-viewer.css'; // Import PSV CSS
import 'photo-sphere-viewer/dist/plugins/markers.css';

const app = createApp(App);

// Register your components globally
app.component('photo-viewer', PhotoViewer);
app.component('map-component', Map);

// Mount the app to a DOM element with the ID 'app'
app.mount('#app');

window.Alpine = Alpine;

Alpine.start();
