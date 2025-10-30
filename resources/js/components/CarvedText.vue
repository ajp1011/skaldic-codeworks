<template>
  <div class="carved-text-container" :class="{'icy-burn': showIcyBurn}">
    <span 
      v-for="(char, index) in textArray" 
      :key="index" 
      :class="{'carved-char': true, 'etched': charLoaded[index]}"
    >{{ char }}</span>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

interface Props {
  text: string;
  animationDelay?: number;
  startDelay?: number;
}

const props = withDefaults(defineProps<Props>(), {
  animationDelay: 20,
  startDelay: 800
});

const textArray = ref<string[]>([]);
const charLoaded = ref<boolean[]>([]);
const showIcyBurn = ref<boolean>(false);

const startCarvingEffect = () => {
  let charIndex = 0;
  const interval = setInterval(() => {
    if (charIndex < textArray.value.length) {
      charLoaded.value[charIndex] = true;
      charIndex++;
    } else {
      clearInterval(interval);
      // Trigger icy burn effect after all text is revealed
      setTimeout(() => {
        showIcyBurn.value = true;
        // Remove the effect after animation completes
        setTimeout(() => {
          showIcyBurn.value = false;
        }, 2000);
      }, 500);
    }
  }, props.animationDelay);
};

onMounted(() => {
  // Split the text into characters immediately
  textArray.value = props.text.split('');
  // Initialize all characters as not loaded (hidden)
  charLoaded.value = new Array(textArray.value.length).fill(false);
  
  // Start the animation after a delay
  setTimeout(() => {
    startCarvingEffect();
  }, props.startDelay);
});
</script>

<style scoped>
.carved-text-container {
  font-family: var(--font-secondary);
  font-size: 1rem;
  color: var(--icy-blue);
  font-weight: 300;
  letter-spacing: 0.02em;
  line-height: 1.6;
  max-width: 90%;
  margin: 0 auto;
  text-align: center;
  position: relative;
  background: linear-gradient(135deg, 
    rgba(45, 55, 72, 0.1) 0%, 
    rgba(26, 26, 26, 0.2) 100%);
  border-radius: 8px;
  padding: 1.5rem;
  border: 1px solid rgba(129, 199, 212, 0.1);
}

.carved-char {
  display: inline;
  opacity: 0;
  transition: opacity 0.3s ease-out;
  position: relative;
  color: var(--icy-blue);
  text-shadow: 
    /* Inner shadow for carved effect */
    inset 0 1px 2px rgba(0, 0, 0, 0.6),
    inset 0 -1px 1px rgba(255, 255, 255, 0.1),
    /* Outer glow */
    0 0 8px rgba(129, 199, 212, 0.3),
    0 1px 2px rgba(0, 0, 0, 0.4);
  background: linear-gradient(135deg, 
    rgba(129, 199, 212, 0.05) 0%, 
    rgba(0, 0, 0, 0.1) 50%, 
    rgba(129, 199, 212, 0.02) 100%);
  border-radius: 1px;
  padding: 0 0.5px;
}

.carved-char.etched {
  opacity: 1;
}

/* Icy Burn Effect */
.carved-text-container.icy-burn {
  animation: icyBurn 2s ease-in-out;
}

.carved-text-container.icy-burn .carved-char.etched {
  animation: icyFlash 2s ease-in-out;
}

@keyframes icyBurn {
  0% {
    box-shadow: 
      0 0 0 rgba(129, 199, 212, 0),
      0 0 0 rgba(255, 255, 255, 0),
      inset 0 0 0 rgba(129, 199, 212, 0);
  }
  25% {
    box-shadow: 
      0 0 20px rgba(129, 199, 212, 0.8),
      0 0 40px rgba(255, 255, 255, 0.6),
      inset 0 0 20px rgba(129, 199, 212, 0.3);
  }
  50% {
    box-shadow: 
      0 0 30px rgba(129, 199, 212, 1),
      0 0 60px rgba(255, 255, 255, 0.8),
      inset 0 0 30px rgba(129, 199, 212, 0.5);
  }
  75% {
    box-shadow: 
      0 0 20px rgba(129, 199, 212, 0.8),
      0 0 40px rgba(255, 255, 255, 0.6),
      inset 0 0 20px rgba(129, 199, 212, 0.3);
  }
  100% {
    box-shadow: 
      0 0 0 rgba(129, 199, 212, 0),
      0 0 0 rgba(255, 255, 255, 0),
      inset 0 0 0 rgba(129, 199, 212, 0);
  }
}

@keyframes icyFlash {
  0% {
    text-shadow: 
      inset 0 1px 2px rgba(0, 0, 0, 0.6),
      inset 0 -1px 1px rgba(255, 255, 255, 0.1),
      0 0 8px rgba(129, 199, 212, 0.3),
      0 1px 2px rgba(0, 0, 0, 0.4);
  }
  25% {
    text-shadow: 
      inset 0 1px 2px rgba(0, 0, 0, 0.6),
      inset 0 -1px 1px rgba(255, 255, 255, 0.3),
      0 0 20px rgba(129, 199, 212, 1),
      0 0 40px rgba(255, 255, 255, 0.8),
      0 1px 2px rgba(0, 0, 0, 0.4);
  }
  50% {
    text-shadow: 
      inset 0 1px 2px rgba(0, 0, 0, 0.6),
      inset 0 -1px 1px rgba(255, 255, 255, 0.5),
      0 0 30px rgba(129, 199, 212, 1.2),
      0 0 60px rgba(255, 255, 255, 1),
      0 1px 2px rgba(0, 0, 0, 0.4);
  }
  75% {
    text-shadow: 
      inset 0 1px 2px rgba(0, 0, 0, 0.6),
      inset 0 -1px 1px rgba(255, 255, 255, 0.3),
      0 0 20px rgba(129, 199, 212, 1),
      0 0 40px rgba(255, 255, 255, 0.8),
      0 1px 2px rgba(0, 0, 0, 0.4);
  }
  100% {
    text-shadow: 
      inset 0 1px 2px rgba(0, 0, 0, 0.6),
      inset 0 -1px 1px rgba(255, 255, 255, 0.1),
      0 0 8px rgba(129, 199, 212, 0.3),
      0 1px 2px rgba(0, 0, 0, 0.4);
  }
}

/* Add a subtle carved line effect */
.carved-text-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    linear-gradient(90deg, transparent 0%, rgba(129, 199, 212, 0.1) 50%, transparent 100%),
    linear-gradient(0deg, transparent 0%, rgba(0, 0, 0, 0.1) 50%, transparent 100%);
  border-radius: 8px;
  pointer-events: none;
  opacity: 0.3;
}

/* Responsive adjustments */
@media (width <= 640px) {
  .carved-text-container {
    font-size: 0.9rem;
    max-width: 95%;
    line-height: 1.5;
    padding: 1rem;
  }
}
</style>