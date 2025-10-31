import './bootstrap';
import { createApp } from 'vue';
// @ts-ignore
import LandingPage from './components/LandingPage.vue';
import './snow-effect';
import './spark-effect';
import './components/ContactReveal';

// Mount landing page component
const appElement = document.getElementById('app');
if (appElement) {
  const app = createApp(LandingPage);
  app.mount('#app');
}

