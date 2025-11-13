import { ref, computed } from 'vue';
import type { AxiosError } from 'axios';

/**
 * Composable for theme management
 */
export function useTheme() {
  const currentTheme = ref<'nordic-minimalism' | 'forgecraft'>('nordic-minimalism');

  const initTheme = () => {
    // Try to get theme from cookie
    const cookieValue = document.cookie
      .split('; ')
      .find(row => row.startsWith('theme='))
      ?.split('=')[1];

    if (cookieValue === 'nordic-minimalism' || cookieValue === 'forgecraft') {
      currentTheme.value = cookieValue;
    }
  };

  const themes = [
    { value: 'nordic-minimalism', label: 'Nordic Minimalism' },
    { value: 'forgecraft', label: 'Forgecraft Modern' },
  ];

  const switchTheme = async (theme: 'nordic-minimalism' | 'forgecraft') => {
    console.log('switchTheme called with:', theme, 'currentTheme:', currentTheme.value);
    
    if (theme === currentTheme.value) {
      console.log('Theme is already set, skipping');
      return;
    }

    try {
      const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
      
      if (!csrfToken) {
        console.error('CSRF token not found');
        return;
      }

      console.log('Sending theme update request to /theme with theme:', theme);
      
      const response = await window.axios.post('/theme', 
        { theme },
        {
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
          },
        }
      );

      console.log('Theme update response:', response.data);

      currentTheme.value = theme;
      
      console.log('Reloading page with new theme...');
      window.location.reload();
    } catch (error) {
      console.error('Failed to update theme:', error);
      if (error instanceof Error && 'response' in error) {
        const axiosError = error as AxiosError;
        if (axiosError.response) {
          console.error('Response error:', axiosError.response.status, axiosError.response.data);
        }
      }
    }
  };

  const currentThemeLabel = computed(() => {
    return themes.find(t => t.value === currentTheme.value)?.label || 'Nordic Minimalism';
  });

  initTheme();

  return {
    currentTheme,
    themes,
    switchTheme,
    currentThemeLabel,
  };
}

