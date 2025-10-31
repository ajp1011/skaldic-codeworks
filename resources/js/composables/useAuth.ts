import { ref } from 'vue';

/**
 * Composable for authentication state management
 */
export function useAuth() {
  const isAuthenticated = ref(false);

  /**
   * Check authentication status from DOM
   */
  const checkAuth = () => {
    const authCheck = document.querySelector('[data-authenticated]');
    isAuthenticated.value = authCheck?.getAttribute('data-authenticated') === 'true';
  };

  /**
   * Update authentication state
   */
  const setAuthenticated = (value: boolean) => {
    isAuthenticated.value = value;
  };

  return {
    isAuthenticated,
    setAuthenticated,
    checkAuth
  };
}
