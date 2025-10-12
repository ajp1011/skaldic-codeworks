import './bootstrap';
import { createApp } from 'vue';
// @ts-ignore
import App from './components/App.vue';
// @ts-ignore
import CarvedText from './components/CarvedText.vue';
// @ts-ignore
import ForgedText from './components/ForgedText.vue';
// Import both theme effects (will only initialize if container exists)
import './snow-effect';
import './spark-effect';
import './components/ContactReveal';

const appElement = document.getElementById('app');
if (appElement) {
  const app = createApp(App);
  app.mount('#app');
}

// Dynamically mount tagline component based on theme
const carvedElement = document.getElementById('carved-tagline');
if (carvedElement) {
  // Check for spark container to determine theme
  const isForgecraft = document.getElementById('spark-container') !== null;
  
  const taglineText = "At Skaldic Codeworks, we turn ideas into secure, scalable web applications, guiding clients from concept to completion through clear communication, thoughtful architecture, and expert craftsmanship. If you have a story to tell, we can bring it to life.";
  
  const taglineApp = isForgecraft 
    ? createApp(ForgedText, { text: taglineText, animationDelay: 15, startDelay: 800 })
    : createApp(CarvedText, { text: taglineText, animationDelay: 20, startDelay: 800 });
  
  taglineApp.mount('#carved-tagline');
}
