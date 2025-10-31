
/**
 * Composable for managing scroll reveal animations using Intersection Observer
 */
export function useScrollAnimations() {
  let observer: IntersectionObserver | null = null;
  const elementsToAnimate: HTMLElement[] = [];

  /**
   * Setup Intersection Observer for scroll animations
   */
  const setupObserver = () => {
    const options: IntersectionObserverInit = {
      root: null,
      rootMargin: '0px 0px -100px 0px',
      threshold: 0.1
    };

    observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
        }
      });
    }, options);

    // Observe all registered elements
    elementsToAnimate.forEach(el => {
      if (el) {
        el.classList.add('scroll-reveal');
        observer?.observe(el);
      }
    });
  };

  /**
   * Register an element for scroll animation
   */
  const registerElement = (element: HTMLElement | null) => {
    if (element && !elementsToAnimate.includes(element)) {
      elementsToAnimate.push(element);
    }
  };

  /**
   * Register multiple elements for scroll animation
   */
  const registerElements = (elements: (HTMLElement | null)[]) => {
    elements.forEach(el => {
      if (el) {
        registerElement(el);
      }
    });
  };

  /**
   * Animate hero elements with staggered delay
   */
  const animateHeroStaggered = (
    heroTitle: HTMLElement | null,
    heroAccent: HTMLElement | null,
    heroTagline: HTMLElement | null,
    heroCta: HTMLElement | null
  ) => {
    if (heroTitle) {
      setTimeout(() => {
        heroTitle.classList.add('revealed');
      }, 300);
    }
    if (heroAccent) {
      setTimeout(() => {
        heroAccent.classList.add('revealed');
      }, 600);
    }
    if (heroTagline) {
      setTimeout(() => {
        heroTagline.classList.add('revealed');
      }, 900);
    }
    if (heroCta) {
      setTimeout(() => {
        heroCta.classList.add('revealed');
      }, 1200);
    }
  };

  /**
   * Initialize animations
   */
  const init = () => {
    setTimeout(() => {
      setupObserver();
    }, 100);
  };

  /**
   * Cleanup observer on unmount
   */
  const cleanup = () => {
    observer?.disconnect();
  };

  return {
    registerElement,
    registerElements,
    animateHeroStaggered,
    init,
    cleanup
  };
}
