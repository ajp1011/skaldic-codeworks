<template>
  <div class="landing-page">
    <!-- Navigation -->
    <nav class="landing-nav" :class="{ 'scrolled': isScrolled }">
      <div class="nav-container">
        <div class="nav-logo">
          <img src="/images/skaldic-codeworks-logo-white.png" alt="Skaldic Codeworks Logo">
          <span>Skaldic Codeworks</span>
        </div>
        <div class="nav-links">
          <a href="#about" @click.prevent="smoothScroll">About</a>
          <a href="#services" @click.prevent="smoothScroll">Services</a>
          <a href="#contact" @click.prevent="smoothScroll">Contact</a>
          <div class="theme-dropdown">
            <select 
              :value="selectedTheme" 
              @change="handleThemeChange($event)"
              class="theme-select"
              aria-label="Select theme"
            >
              <option 
                v-for="theme in themes" 
                :key="theme.value" 
                :value="theme.value"
              >
                {{ theme.label }}
              </option>
            </select>
          </div>
          <a v-if="isAuthenticated" href="/dashboard" class="nav-button">Dashboard</a>
          <button v-else @click="openLoginModal" class="nav-button">Log In</button>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
      <div class="hero-content" ref="heroContent">
        <div class="hero-logo">
          <img src="/images/skaldic-codeworks-logo-white.png" alt="Skaldic Codeworks Logo">
        </div>
        <h1 class="hero-title" ref="heroTitle">Skaldic Codeworks</h1>
        <div class="hero-accent-line" ref="heroAccent"></div>
        <p class="hero-tagline" ref="heroTagline">
          I turn ideas into secure, scalable web applications, 
          guiding clients from concept to completion through clear communication, 
          thoughtful architecture, and expert craftsmanship. If you have a story to tell, 
          I can bring it to life.
        </p>
        <div class="hero-cta" ref="heroCta">
          <a href="#about" @click.prevent="smoothScroll" class="nordic-button hero-button">Explore My Work</a>
        </div>
      </div>
      <div class="scroll-indicator">
        <div class="scroll-arrow"></div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about" ref="aboutSection">
      <div class="section-container">
        <h2 class="section-title" ref="aboutTitle">About</h2>
        <div class="about-content">
          <div class="about-text" ref="aboutText">
            <p>
              I'm Alexander Perry, a dynamic and adaptable engineering leader and product strategist 
              with over a decade of experience driving innovation and team success across multiple 
              technology stacks. I'm an expert in PHP and Laravel, with extensive experience 
              architecting and refactoring large-scale systems for performance and maintainability.
            </p>
            <p>
              My background includes significant cybersecurity expertise. I understand the critical 
              importance of building secure applications from the ground up, with deep knowledge of 
              security best practices, threat mitigation, and compliance requirements.
            </p>
            <p>
              I have a proven track record in leading cross-functional teams, fostering collaboration, 
              managing lean budgets, and delivering impactful products on time. I'm passionate about 
              mentoring engineers, building scalable SaaS platforms, and aligning technical execution 
              with business goals while maintaining the highest security standards.
            </p>
          </div>
          <div class="about-competencies" ref="aboutCompetencies">
            <h3 class="competencies-title">Core Competencies</h3>
            <div class="competencies-grid">
              <div class="competency-item">
                <h4 class="competency-category">Languages & Frameworks</h4>
                <p class="competency-list">PHP (Laravel Expert), JavaScript (Vue.js, React), HTML5, CSS3, Python, Perl, C#, Java</p>
              </div>
              <div class="competency-item">
                <h4 class="competency-category">Databases</h4>
                <p class="competency-list">MySQL, MariaDB, Percona, NoSQL</p>
              </div>
              <div class="competency-item">
                <h4 class="competency-category">Tools & Platforms</h4>
                <p class="competency-list">AWS, Linode, Git, REST APIs, Unit & Functional Testing</p>
              </div>
              <div class="competency-item">
                <h4 class="competency-category">Security & Cybersecurity</h4>
                <p class="competency-list">Security Best Practices, Threat Mitigation, Secure Architecture, Compliance, Application Security (gained through extensive experience at Galactic Advisors)</p>
              </div>
              <div class="competency-item">
                <h4 class="competency-category">Leadership & Product</h4>
                <p class="competency-list">Agile/SCRUM (Product Owner & SCRUM Master), Strategic Planning, Technical Roadmapping, Cross-Functional Collaboration</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section class="services-section" id="services" ref="servicesSection">
      <div class="section-container">
        <h2 class="section-title" ref="servicesTitle">Services</h2>
        <div class="services-grid" ref="servicesGrid">
          <div class="service-card" v-for="(service, index) in services" :key="index" :ref="(el: HTMLElement | null) => { if (el) serviceCards[index] = el }">
            <div class="service-icon">{{ service.icon }}</div>
            <h3 class="service-title">{{ service.title }}</h3>
            <p class="service-description">{{ service.description }}</p>
          </div>
        </div>
      </div>
    </section>


    <!-- Contact Section -->
    <section class="contact-section" id="contact" ref="contactSection">
      <div class="section-container">
        <h2 class="section-title" ref="contactTitle">Contact</h2>
        <div class="contact-content" ref="contactContent">
          <div class="contact-info">
            <p class="contact-text">
              Have a project in mind? Let's discuss how I can bring your vision to life.
            </p>
            <div class="contact-methods">
              <div class="contact-email" title="Click to reveal email">
                <span class="reveal-trigger" data-type="email">Click to show email</span>
                <span class="contact-hidden" style="display:none;"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Honeypot for bot detection -->
      <div style="position:absolute;left:-9999px;" aria-hidden="true">
        <span>fakeemail@scraperbait.com</span>
      </div>
    </section>

    <!-- Login Modal -->
    <LoginModal :isOpen="isLoginModalOpen" @close="closeLoginModal" @success="handleLoginSuccess" />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
// @ts-ignore
import LoginModal from './LoginModal.vue';
import { useAuth } from '../composables/useAuth';
import { useLoginModal } from '../composables/useLoginModal';
import { useNavigationScroll } from '../composables/useNavigationScroll';
import { useSmoothScroll } from '../composables/useSmoothScroll';
import { useScrollAnimations } from '../composables/useScrollAnimations';
import { useTheme } from '../composables/useTheme';

// Composables
const { isAuthenticated, setAuthenticated, checkAuth } = useAuth();
const { isOpen: isLoginModalOpen, open: openLoginModal, close: closeLoginModal } = useLoginModal();
const { isScrolled, setup: setupNavigationScroll, cleanup: cleanupNavigationScroll } = useNavigationScroll();
const { handleScrollClick: smoothScroll } = useSmoothScroll();
const {
  registerElements,
  animateHeroStaggered,
  init: initScrollAnimations,
  cleanup: cleanupScrollAnimations
} = useScrollAnimations();
const { currentTheme, themes, switchTheme } = useTheme();

const getInitialTheme = (): 'nordic-minimalism' | 'forgecraft' => {
  const appElement = document.getElementById('app');
  const dataTheme = appElement?.getAttribute('data-theme');
  
  if (dataTheme === 'nordic-minimalism' || dataTheme === 'forgecraft') {
    console.log('Theme from data attribute:', dataTheme);
    return dataTheme;
  }
  
  try {
    const cookies = document.cookie.split(';');
    let cookieValue: string | undefined;
    
    for (const cookie of cookies) {
      const trimmed = cookie.trim();
      if (trimmed.startsWith('theme=')) {
        cookieValue = trimmed.substring(6);
        break;
      }
    }
    
    if (cookieValue) {
      const decoded = decodeURIComponent(cookieValue).trim();
      console.log('Theme from cookie:', decoded);
      
      if (decoded === 'nordic-minimalism' || decoded === 'forgecraft') {
        return decoded;
      }
    }
  } catch (error) {
    console.error('Error reading theme cookie:', error);
  }
  
  console.log('No valid theme found, defaulting to nordic-minimalism');
  return 'nordic-minimalism';
};

const initialTheme = getInitialTheme();
const selectedTheme = ref<'nordic-minimalism' | 'forgecraft'>(initialTheme);
console.log('Initial selectedTheme value:', selectedTheme.value);

const handleThemeChange = (event: Event) => {
  const target = event.target as HTMLSelectElement;
  const value = target.value as 'nordic-minimalism' | 'forgecraft';
  
  console.log('Theme change handler called, value:', value, 'current:', selectedTheme.value);
  
  if (!value || (value !== 'nordic-minimalism' && value !== 'forgecraft')) {
    console.error('Invalid theme value:', value);
    return;
  }
  
  selectedTheme.value = value;
  
  console.log('Switching theme from', currentTheme.value, 'to', value);
  switchTheme(value);
};

const heroContent = ref<HTMLElement | null>(null);
const heroTitle = ref<HTMLElement | null>(null);
const heroAccent = ref<HTMLElement | null>(null);
const heroTagline = ref<HTMLElement | null>(null);
const heroCta = ref<HTMLElement | null>(null);
const aboutTitle = ref<HTMLElement | null>(null);
const aboutText = ref<HTMLElement | null>(null);
const aboutCompetencies = ref<HTMLElement | null>(null);
const servicesTitle = ref<HTMLElement | null>(null);
const serviceCards = ref<(HTMLElement | null)[]>([]);
const contactTitle = ref<HTMLElement | null>(null);
const contactContent = ref<HTMLElement | null>(null);

const services = [
  {
    icon: '⚡',
    title: 'Web Development',
    description: 'Custom web applications built with modern frameworks and best practices.'
  },
  {
    icon: '🎨',
    title: 'UI/UX Design',
    description: 'Beautiful, intuitive interfaces that prioritize user experience.'
  },
  {
    icon: '🔒',
    title: 'Security',
    description: 'Secure applications with robust authentication and data protection.'
  },
  {
    icon: '📱',
    title: 'Responsive Design',
    description: 'Applications that work seamlessly across all devices and screen sizes.'
  }
];

const handleLoginSuccess = () => {
  closeLoginModal();
  setAuthenticated(true);
};

onMounted(() => {
  checkAuth();
  
  const initialTheme = getInitialTheme();
  console.log('onMounted: Setting selectedTheme to:', initialTheme);
  selectedTheme.value = initialTheme;
  
  currentTheme.value = initialTheme;
  console.log('Synced currentTheme.value to:', currentTheme.value);
  
  nextTick(() => {
    const selectElement = document.querySelector('.theme-select') as HTMLSelectElement | null;
    if (selectElement) {
      selectElement.value = initialTheme;
      console.log('Forced select element value to:', selectElement.value, 'expected:', initialTheme);
      
      if (selectElement.value !== initialTheme) {
        console.error('Select value mismatch! Element value:', selectElement.value, 'Expected:', initialTheme);
        selectElement.value = initialTheme;
      }
    } else {
      console.error('Select element not found!');
    }
  });
  
  setupNavigationScroll();
  
  // Register elements for scroll animation
  registerElements([
    aboutTitle.value,
    aboutText.value,
    aboutCompetencies.value,
    servicesTitle.value,
    ...serviceCards.value.filter(Boolean),
    contactTitle.value,
    contactContent.value
  ]);

  // Animate hero with staggered delay
  animateHeroStaggered(
    heroTitle.value,
    heroAccent.value,
    heroTagline.value,
    heroCta.value
  );

  // Initialize scroll animations
  initScrollAnimations();
});

onUnmounted(() => {
  cleanupNavigationScroll();
  cleanupScrollAnimations();
});
</script>

<style scoped>
.landing-page {
  width: 100%;
  min-height: 100vh;
}
</style>
