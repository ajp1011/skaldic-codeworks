import { ref, onMounted, onUnmounted } from 'vue';

/**
 * Composable for navigation scroll detection
 */
export function useNavigationScroll() {
  const isScrolled = ref(false);

  /**
   * Handle scroll event for navigation state
   */
  const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
  };

  /**
   * Setup scroll listener
   */
  const setup = () => {
    window.addEventListener('scroll', handleScroll);
  };

  /**
   * Cleanup scroll listener
   */
  const cleanup = () => {
    window.removeEventListener('scroll', handleScroll);
  };

  return {
    isScrolled,
    setup,
    cleanup
  };
}
