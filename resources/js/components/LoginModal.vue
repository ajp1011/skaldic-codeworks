<template>
  <Teleport to="body">
    <Transition name="modal">
      <div v-if="isOpen" class="modal-overlay" @click.self="closeModal">
        <div class="modal-container" @keydown.esc="closeModal">
          <div class="modal-header">
            <div class="modal-logo">
              <img src="/images/skaldic-codeworks-logo-white.png" alt="Skaldic Codeworks Logo">
            </div>
            <h2 class="modal-title">Login</h2>
            <div class="modal-accent-line"></div>
            <button class="modal-close" @click="closeModal" aria-label="Close modal">
              <span>×</span>
            </button>
          </div>
          
          <form @submit.prevent="handleSubmit" class="auth-form">
            <div class="form-group">
              <label for="email" class="form-label">Email</label>
              <input 
                id="email" 
                type="email" 
                v-model="form.email" 
                class="form-input"
                :class="{ 'input-error': errors.email }"
                required 
                autofocus
                placeholder="your@email.com"
              >
              <p v-if="errors.email" class="error-message">{{ errors.email }}</p>
            </div>
            
            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input 
                id="password" 
                type="password" 
                v-model="form.password" 
                class="form-input"
                :class="{ 'input-error': errors.password }"
                required
                placeholder="Enter your password"
              >
              <p v-if="errors.password" class="error-message">{{ errors.password }}</p>
            </div>
            
            <div class="form-group-checkbox">
              <label for="remember" class="checkbox-label">
                <input 
                  id="remember" 
                  type="checkbox" 
                  v-model="form.remember" 
                  class="form-checkbox"
                >
                <span>Remember me</span>
              </label>
            </div>
            
            <div v-if="generalError" class="form-error">
              <p class="error-message">{{ generalError }}</p>
            </div>
            
            <div class="form-actions">
              <button 
                type="submit" 
                class="nordic-button nordic-button-full"
                :disabled="isSubmitting"
              >
                <span v-if="isSubmitting">Logging in...</span>
                <span v-else>Login</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, watch, onMounted, nextTick } from 'vue';

interface Props {
  isOpen: boolean;
}

interface Emits {
  (e: 'close'): void;
  (e: 'success'): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const form = ref({
  email: '',
  password: '',
  remember: false
});

const errors = ref<Record<string, string>>({});
const generalError = ref<string>('');
const isSubmitting = ref(false);
const csrfToken = ref<string>('');

// Get CSRF token from meta tag
const getCsrfToken = () => {
  const token = document.querySelector('meta[name="csrf-token"]');
  if (token) {
    return token.getAttribute('content') || '';
  }
  return '';
};

// Close modal
const closeModal = () => {
  if (!isSubmitting.value) {
    emit('close');
    // Reset form after close animation
    setTimeout(() => {
      form.value = { email: '', password: '', remember: false };
      errors.value = {};
      generalError.value = '';
    }, 300);
  }
};

// Handle form submission
const handleSubmit = async () => {
  if (isSubmitting.value) return;
  
  // Clear previous errors
  errors.value = {};
  generalError.value = '';
  isSubmitting.value = true;

  try {
    // Create FormData for form submission
    const formData = new FormData();
    formData.append('email', form.value.email);
    formData.append('password', form.value.password);
    if (form.value.remember) {
      formData.append('remember', '1');
    }

    const response = await fetch('/login', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData,
      credentials: 'same-origin',
      redirect: 'manual'
    });

    const isSuccess = response.ok || 
                     response.status === 302 || 
                     response.status === 0 ||
                     (response.type as string) === 'opaqueredirect';
    
    if (isSuccess) {
      emit('success');
      window.location.href = '/dashboard';
      return;
    }

    if ((response.type as string) === 'opaqueredirect') {
      emit('success');
      window.location.href = '/dashboard';
      return;
    }

    if (response.status === 422) {
      try {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          const data = await response.json();
          if (data.errors) {
            const formattedErrors: Record<string, string> = {};
            for (const [field, messages] of Object.entries(data.errors)) {
              if (Array.isArray(messages) && messages.length > 0) {
                formattedErrors[field] = messages[0];
              } else if (typeof messages === 'string') {
                formattedErrors[field] = messages;
              }
            }
            errors.value = formattedErrors;
          } else if (data.message) {
            generalError.value = data.message;
          }
        } else {
          generalError.value = 'Validation failed';
        }
      } catch (parseError) {
        generalError.value = 'Validation failed';
      }
    } else if (response.status !== 0) {
      try {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          const data = await response.json();
          if (data.message) {
            generalError.value = data.message;
          } else {
            generalError.value = 'Invalid email or password';
          }
        } else {
          generalError.value = 'Invalid email or password';
        }
      } catch (parseError) {
        generalError.value = 'Invalid email or password';
      }
    }
  } catch (error) {
    console.error('Login error:', error);
    generalError.value = 'An error occurred. Please try again.';
  } finally {
    isSubmitting.value = false;
  }
};

watch(() => props.isOpen, (isOpen) => {
  if (isOpen) {
    nextTick(() => {
      const emailInput = document.getElementById('email') as HTMLInputElement;
      if (emailInput) {
        emailInput.focus();
      }
    });
  }
});

onMounted(() => {
  csrfToken.value = getCsrfToken();
  
  if (!csrfToken.value) {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
      const [name, value] = cookie.trim().split('=');
      if (name === 'XSRF-TOKEN') {
        csrfToken.value = decodeURIComponent(value);
        break;
      }
    }
  }
});
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.85);
  backdrop-filter: blur(8px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
  padding: var(--spacing-xl);
  overflow-y: auto;
}

.modal-container {
  position: relative;
  width: 100%;
  max-width: 450px;
  background: var(--gradient-primary);
  border: 1px solid rgb(129 199 212 / 30%);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg), var(--shadow-glow);
  padding: var(--spacing-2xl);
  margin: auto;
}

.modal-header {
  text-align: center;
  margin-bottom: var(--spacing-xl);
  position: relative;
}

.modal-logo {
  margin-bottom: var(--spacing-lg);
  display: flex;
  justify-content: center;
}

.modal-logo img {
  width: 80px;
  height: 80px;
  animation: scaleIn 0.5s ease-out;
}

.modal-title {
  font-family: var(--font-accent);
  font-size: 2rem;
  font-weight: 600;
  color: var(--off-white);
  margin-bottom: var(--spacing-md);
  letter-spacing: -0.02em;
}

.modal-accent-line {
  width: 60px;
  height: 2px;
  background: var(--gradient-accent);
  margin: var(--spacing-md) auto;
  border-radius: var(--radius-sm);
}

.modal-close {
  position: absolute;
  top: 0;
  right: 0;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
  border: 1px solid rgb(129 199 212 / 30%);
  border-radius: var(--radius-sm);
  color: var(--metallic-silver);
  font-size: 1.5rem;
  line-height: 1;
  cursor: pointer;
  transition: all var(--transition-base);
}

.modal-close:hover {
  border-color: var(--icy-blue);
  color: var(--off-white);
  background: rgba(129, 199, 212, 0.1);
}

.modal-close span {
  display: block;
  margin-top: -2px;
}

/* Form Styles */
.auth-form {
  margin-top: var(--spacing-xl);
  text-align: left;
}

.form-group {
  margin-bottom: var(--spacing-lg);
}

.form-label {
  display: block;
  font-family: var(--font-secondary);
  font-size: 0.925rem;
  font-weight: 500;
  color: var(--off-white);
  margin-bottom: var(--spacing-xs);
  letter-spacing: 0.01em;
}

.form-input {
  width: 100%;
  padding: 0.75rem var(--spacing-md);
  font-family: var(--font-secondary);
  font-size: 1rem;
  color: var(--off-white);
  background: var(--deep-charcoal);
  border: 1px solid rgb(129 199 212 / 30%);
  border-radius: var(--radius-sm);
  outline: none;
  transition: all var(--transition-base);
  box-sizing: border-box;
}

.form-input::placeholder {
  color: var(--metallic-silver);
  opacity: 0.6;
}

.form-input:focus {
  border-color: var(--icy-blue);
  box-shadow: 0 0 0 3px rgb(129 199 212 / 20%);
}

.form-input.input-error {
  border-color: #ef4444;
}

.error-message {
  margin-top: var(--spacing-xs);
  font-family: var(--font-secondary);
  font-size: 0.875rem;
  color: #ef4444;
}

.form-group-checkbox {
  margin-bottom: var(--spacing-lg);
}

.checkbox-label {
  display: flex;
  align-items: center;
  font-family: var(--font-secondary);
  font-size: 0.925rem;
  color: var(--metallic-silver);
  cursor: pointer;
}

.form-checkbox {
  width: 1.125rem;
  height: 1.125rem;
  margin-right: 0.625rem;
  cursor: pointer;
  accent-color: var(--icy-blue);
}

.form-error {
  margin-bottom: var(--spacing-lg);
  padding: var(--spacing-md);
  background: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.3);
  border-radius: var(--radius-sm);
}

.form-actions {
  margin-top: var(--spacing-xl);
}

.nordic-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.nordic-button:disabled:hover {
  transform: none;
  background: var(--gradient-primary);
}

/* Modal Transitions */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .modal-container,
.modal-leave-active .modal-container {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  transform: scale(0.9) translateY(-20px);
  opacity: 0;
}

/* Responsive Design */
@media (width <= 768px) {
  .modal-overlay {
    padding: var(--spacing-md);
  }

  .modal-container {
    padding: var(--spacing-xl) var(--spacing-lg);
  }

  .modal-title {
    font-size: 1.75rem;
  }

  .modal-logo img {
    width: 60px;
    height: 60px;
  }
}
</style>
