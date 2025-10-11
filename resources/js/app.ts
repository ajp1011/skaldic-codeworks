import './bootstrap';
import { createApp } from 'vue';
// @ts-ignore
import App from './components/App.vue';
// @ts-ignore
import CarvedText from './components/CarvedText.vue';
import './snow-effect';
import './components/ContactReveal';

const appElement = document.getElementById('app');
if (appElement) {
  const app = createApp(App);
  app.mount('#app');
}

const carvedElement = document.getElementById('carved-tagline');
if (carvedElement) {
  const carvedApp = createApp(CarvedText, {
    text: "At Skaldic Codeworks, we turn ideas into secure, scalable web applications, guiding clients from concept to completion through clear communication, thoughtful architecture, and expert craftsmanship. If you have a story to tell, we can bring it to life.",
    animationDelay: 20,
    startDelay: 800
  });
  carvedApp.mount('#carved-tagline');
}
