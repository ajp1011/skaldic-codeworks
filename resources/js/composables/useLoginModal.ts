import { ref, onUnmounted } from 'vue';

/**
 * Composable for login modal state management
 */
export function useLoginModal() {
  const isOpen = ref(false);

  /**
   * Open the login modal
   */
  const open = () => {
    isOpen.value = true;
    document.body.style.overflow = 'hidden';
  };

  /**
   * Close the login modal
   */
  const close = () => {
    isOpen.value = false;
    document.body.style.overflow = '';
  };

  /**
   * Cleanup on unmount
   */
  onUnmounted(() => {
    document.body.style.overflow = '';
  });

  return {
    isOpen,
    open,
    close
  };
}
