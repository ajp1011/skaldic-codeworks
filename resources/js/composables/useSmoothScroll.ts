/**
 * Composable for smooth scrolling functionality
 */
export function useSmoothScroll() {
  /**
   * Smoothly scroll to an element
   */
  const scrollTo = (selector: string) => {
    const element = document.querySelector(selector);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  /**
   * Handle smooth scroll from click event
   */
  const handleScrollClick = (event: Event) => {
    event.preventDefault();
    const target = event.target as HTMLElement;
    const href = target.getAttribute('href');
    if (href && href.startsWith('#')) {
      scrollTo(href);
    }
  };

  return {
    scrollTo,
    handleScrollClick
  };
}
