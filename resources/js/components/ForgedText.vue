<template>
  <div class="forged-text-container" :class="{'ember-burn': showEmberBurn}">
    <span 
      v-for="(char, index) in textArray" 
      :key="index" 
      :class="{'forged-char': true, 'heated': charLoaded[index]}"
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
  animationDelay: 15,
  startDelay: 800
});

const textArray = ref<string[]>([]);
const charLoaded = ref<boolean[]>([]);
const showEmberBurn = ref<boolean>(false);

const startForgingEffect = () => {
  let charIndex = 0;
  const interval = setInterval(() => {
    if (charIndex < textArray.value.length) {
      charLoaded.value[charIndex] = true;
      charIndex++;
    } else {
      clearInterval(interval);
      // Trigger ember burn effect after all text is revealed
      setTimeout(() => {
        showEmberBurn.value = true;
        // Keep the subtle glow, don't remove it
      }, 300);
    }
  }, props.animationDelay);
};

onMounted(() => {
  textArray.value = props.text.split('');
  charLoaded.value = new Array(textArray.value.length).fill(false);
  
  setTimeout(() => {
    startForgingEffect();
  }, props.startDelay);
});
</script>

<style scoped>
.forged-text-container {
  font-family: var(--font-secondary);
  font-size: 1rem;
  color: var(--ember-orange);
  font-weight: 400;
  letter-spacing: 0.03em;
  line-height: 1.6;
  max-width: 90%;
  margin: 0 auto;
  text-align: center;
  position: relative;
  background: linear-gradient(135deg, 
    rgba(58, 58, 58, 0.3) 0%, 
    rgba(10, 10, 10, 0.5) 100%);
  border-radius: 6px;
  padding: 1.5rem;
  border: 2px solid rgba(255, 107, 53, 0.2);
  box-shadow: 
    0 4px 16px rgba(0, 0, 0, 0.6),
    inset 0 1px 1px rgba(255, 107, 53, 0.1);
}

.forged-char {
  display: inline;
  opacity: 0;
  transition: opacity 0.3s ease-out, text-shadow 0.3s ease-out;
  position: relative;
  color: var(--ember-orange);
  text-shadow: 
    0 0 5px rgba(255, 107, 53, 0.4),
    0 1px 3px rgba(0, 0, 0, 0.8);
}

.forged-char.heated {
  opacity: 1;
  animation: heatUp 0.4s ease-out;
}

/* Heat-up animation when character appears */
@keyframes heatUp {
  0% {
    opacity: 0;
    color: var(--iron-gray);
    text-shadow: 0 0 2px rgba(107, 107, 107, 0.5);
  }
  50% {
    color: #ffa600;
    text-shadow: 
      0 0 15px rgba(255, 166, 0, 0.8),
      0 0 25px rgba(255, 107, 53, 0.6);
  }
  100% {
    opacity: 1;
    color: var(--ember-orange);
    text-shadow: 
      0 0 5px rgba(255, 107, 53, 0.4),
      0 1px 3px rgba(0, 0, 0, 0.8);
  }
}

/* Ember Burn Effect - dramatic glow without text color change */
.forged-text-container.ember-burn {
  animation: emberBurn 2.5s ease-in-out;
}

.forged-text-container.ember-burn .forged-char.heated {
  animation: emberGlow 2.5s ease-in-out;
}

@keyframes emberBurn {
  0% {
    box-shadow: 
      0 4px 16px rgba(0, 0, 0, 0.6),
      inset 0 1px 1px rgba(255, 107, 53, 0.1);
  }
  25% {
    box-shadow: 
      0 0 30px rgba(255, 107, 53, 0.8),
      0 0 50px rgba(255, 166, 0, 0.6),
      inset 0 0 20px rgba(255, 107, 53, 0.3);
  }
  50% {
    box-shadow: 
      0 0 40px rgba(255, 107, 53, 1),
      0 0 70px rgba(255, 166, 0, 0.8),
      inset 0 0 30px rgba(255, 107, 53, 0.5);
  }
  75% {
    box-shadow: 
      0 0 30px rgba(255, 107, 53, 0.8),
      0 0 50px rgba(255, 166, 0, 0.6),
      inset 0 0 20px rgba(255, 107, 53, 0.3);
  }
  100% {
    box-shadow: 
      0 4px 16px rgba(0, 0, 0, 0.6),
      0 0 20px rgba(255, 107, 53, 0.3),
      inset 0 1px 1px rgba(255, 107, 53, 0.1);
  }
}

/* Text glow intensifies but color stays consistent */
@keyframes emberGlow {
  0% {
    text-shadow: 
      0 0 5px rgba(255, 107, 53, 0.4),
      0 1px 3px rgba(0, 0, 0, 0.8);
  }
  25% {
    text-shadow: 
      0 0 20px rgba(255, 107, 53, 1),
      0 0 35px rgba(255, 166, 0, 0.9),
      0 1px 3px rgba(0, 0, 0, 0.8);
  }
  50% {
    text-shadow: 
      0 0 30px rgba(255, 107, 53, 1.2),
      0 0 50px rgba(255, 166, 0, 1),
      0 0 70px rgba(193, 68, 14, 0.8),
      0 1px 3px rgba(0, 0, 0, 0.8);
  }
  75% {
    text-shadow: 
      0 0 20px rgba(255, 107, 53, 1),
      0 0 35px rgba(255, 166, 0, 0.9),
      0 1px 3px rgba(0, 0, 0, 0.8);
  }
  100% {
    text-shadow: 
      0 0 8px rgba(255, 107, 53, 0.5),
      0 0 15px rgba(255, 166, 0, 0.3),
      0 1px 3px rgba(0, 0, 0, 0.8);
  }
}

/* Metal texture overlay */
.forged-text-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    linear-gradient(90deg, transparent 0%, rgba(255, 107, 53, 0.05) 50%, transparent 100%),
    linear-gradient(0deg, transparent 0%, rgba(0, 0, 0, 0.2) 50%, transparent 100%);
  border-radius: 6px;
  pointer-events: none;
  opacity: 0.4;
}

/* Responsive adjustments */
@media (width <= 640px) {
  .forged-text-container {
    font-size: 0.9rem;
    max-width: 95%;
    line-height: 1.5;
    padding: 1rem;
  }
}
</style>
