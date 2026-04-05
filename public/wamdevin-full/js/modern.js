/**
 * WAMDEVIN - Modern JavaScript
 * Version: 2.0.0
 * Last Updated: February 2026
 * Description: Consolidated, modern ES6+ JavaScript for enhanced interactivity and performance
 */

'use strict';

// ============================================
// 1. GLOBAL CONFIGURATION
// ============================================

const WAMDEVIN = {
  config: {
    animationDuration: 300,
    scrollOffset: 100,
    debounceDelay: 250,
  },
  
  // Utility functions
  utils: {
    /**
     * Debounce function to limit how often a function can fire
     */
    debounce(func, wait = 250) {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    },

    /**
     * Throttle function to limit function execution rate
     */
    throttle(func, limit = 250) {
      let inThrottle;
      return function(...args) {
        if (!inThrottle) {
          func.apply(this, args);
          inThrottle = true;
          setTimeout(() => inThrottle = false, limit);
        }
      };
    },

    /**
     * Check if element is in viewport
     */
    isInViewport(element, offset = 0) {
      const rect = element.getBoundingClientRect();
      return (
        rect.top >= 0 - offset &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + offset &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    },

    /**
     * Smooth scroll to element
     */
    smoothScrollTo(target, offset = 0) {
      const element = typeof target === 'string' ? document.querySelector(target) : target;
      if (!element) return;

      const elementPosition = element.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - offset;

      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      });
    },

    /**
     * Get computed style value
     */
    getStyle(element, property) {
      return window.getComputedStyle(element).getPropertyValue(property);
    },

    /**
     * Add event listener to multiple elements
     */
    addEventListeners(elements, event, handler) {
      elements.forEach(element => {
        element.addEventListener(event, handler);
      });
    }
  }
};

// ============================================
// 2. LOADING SCREEN
// ============================================

const LoadingScreen = {
  init() {
    window.addEventListener('load', () => {
      const loader = document.getElementById('loading-icon-bx');
      if (loader) {
        setTimeout(() => {
          loader.classList.add('hidden');
          setTimeout(() => {
            loader.style.display = 'none';
          }, 300);
        }, 500);
      }
    });
  }
};

// ============================================
// 3. MOBILE NAVIGATION
// ============================================

const MobileNav = {
  init() {
    const menuToggle = document.querySelector('.navbar-toggler, .menuicon');
    const menuContainer = document.getElementById('menuDropdown');
    const body = document.body;

    if (!menuToggle || !menuContainer) return;

    // Toggle menu
    menuToggle.addEventListener('click', (e) => {
      e.preventDefault();
      const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
      
      menuToggle.setAttribute('aria-expanded', !isExpanded);
      menuToggle.classList.toggle('collapsed');
      menuContainer.classList.toggle('show');
      menuContainer.classList.toggle('collapse');
      body.classList.toggle('menu-open');
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!menuToggle.contains(e.target) && !menuContainer.contains(e.target)) {
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.classList.add('collapsed');
        menuContainer.classList.remove('show');
        menuContainer.classList.add('collapse');
        body.classList.remove('menu-open');
      }
    });

    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && menuContainer.classList.contains('show')) {
        menuToggle.click();
      }
    });

    // Handle submenu toggles on mobile
    const subMenuToggles = document.querySelectorAll('.menu-links .nav-item.has-submenu > a');
    subMenuToggles.forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        if (window.innerWidth <= 991) {
          e.preventDefault();
          const parent = toggle.parentElement;
          parent.classList.toggle('active');
        }
      });
    });
  }
};

// ============================================
// 4. STICKY HEADER
// ============================================

const StickyHeader = {
  lastScroll: 0,
  
  init() {
    const header = document.querySelector('.sticky-header');
    if (!header) return;

    const handleScroll = WAMDEVIN.utils.throttle(() => {
      const currentScroll = window.pageYOffset;

      if (currentScroll > 100) {
        header.classList.add('is-sticky');
      } else {
        header.classList.remove('is-sticky');
      }

      // Hide header on scroll down, show on scroll up
      if (currentScroll > this.lastScroll && currentScroll > 300) {
        header.style.transform = 'translateY(-100%)';
      } else {
        header.style.transform = 'translateY(0)';
      }

      this.lastScroll = currentScroll;
    }, 100);

    window.addEventListener('scroll', handleScroll);
  }
};

// ============================================
// 5. SEARCH BOX
// ============================================

const SearchBox = {
  init() {
    const searchBtn = document.getElementById('quik-search-btn');
    const searchBox = document.querySelector('.nav-search-bar');
    const searchRemove = document.getElementById('search-remove');
    const searchInput = searchBox?.querySelector('input[type="text"]');

    if (!searchBtn || !searchBox) return;

    // Open search
    searchBtn.addEventListener('click', (e) => {
      e.preventDefault();
      searchBox.classList.add('show');
      searchInput?.focus();
    });

    // Close search
    searchRemove?.addEventListener('click', (e) => {
      e.preventDefault();
      searchBox.classList.remove('show');
      searchInput.value = '';
    });

    // Close on escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && searchBox.classList.contains('show')) {
        searchBox.classList.remove('show');
      }
    });
  }
};

// ============================================
// 6. SCROLL REVEAL ANIMATION
// ============================================

const ScrollReveal = {
  init() {
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          // Optionally unobserve after revealing
          // observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(element => {
      observer.observe(element);
    });
  }
};

// ============================================
// 7. COUNTER ANIMATION
// ============================================

const CounterAnimation = {
  init() {
    const counters = document.querySelectorAll('.counter, .stat-number[data-count]');
    if (counters.length === 0) return;

    const animateCounter = (element) => {
      const target = parseInt(element.getAttribute('data-count') || element.textContent.replace(/[^0-9]/g, ''));
      const duration = 2000;
      const increment = target / (duration / 16);
      let current = 0;

      const updateCounter = () => {
        current += increment;
        if (current < target) {
          element.textContent = Math.floor(current).toLocaleString();
          requestAnimationFrame(updateCounter);
        } else {
          element.textContent = target.toLocaleString();
        }
      };

      updateCounter();
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
          entry.target.classList.add('counted');
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.5
    });

    counters.forEach(counter => {
      observer.observe(counter);
    });
  }
};

// ============================================
// 8. LAZY LOADING IMAGES
// ============================================

const LazyLoad = {
  init() {
    // Modern browsers with native lazy loading
    if ('loading' in HTMLImageElement.prototype) {
      const images = document.querySelectorAll('img[data-src]');
      images.forEach(img => {
        img.src = img.dataset.src;
        if (img.dataset.srcset) {
          img.srcset = img.dataset.srcset;
        }
        img.removeAttribute('data-src');
        img.removeAttribute('data-srcset');
      });
    } else {
      // Fallback for older browsers
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            if (img.dataset.srcset) {
              img.srcset = img.dataset.srcset;
            }
            img.removeAttribute('data-src');
            img.removeAttribute('data-srcset');
            observer.unobserve(img);
          }
        });
      });

      const images = document.querySelectorAll('img[data-src]');
      images.forEach(img => observer.observe(img));
    }
  }
};

// ============================================
// 9. SMOOTH SCROLL FOR ANCHOR LINKS
// ============================================

const SmoothScroll = {
  init() {
    const links = document.querySelectorAll('a[href^="#"]:not([href="#"])');
    
    links.forEach(link => {
      link.addEventListener('click', (e) => {
        const targetId = link.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
          e.preventDefault();
          const headerOffset = 80;
          WAMDEVIN.utils.smoothScrollTo(targetElement, headerOffset);
          
          // Update URL without triggering scroll
          history.pushState(null, null, targetId);
          
          // Update focus for accessibility
          targetElement.setAttribute('tabindex', '-1');
          targetElement.focus();
        }
      });
    });
  }
};

// ============================================
// 10. BACK TO TOP BUTTON
// ============================================

const BackToTop = {
  init() {
    // Create button if it doesn't exist
    let backToTopBtn = document.querySelector('.back-to-top');
    
    if (!backToTopBtn) {
      backToTopBtn = document.createElement('button');
      backToTopBtn.className = 'back-to-top';
      backToTopBtn.innerHTML = '<i class="fa fa-arrow-up"></i>';
      backToTopBtn.setAttribute('aria-label', 'Back to top');
      backToTopBtn.setAttribute('title', 'Back to top');
      document.body.appendChild(backToTopBtn);
    }

    // Show/hide button based on scroll position
    const toggleButton = WAMDEVIN.utils.throttle(() => {
      if (window.pageYOffset > 300) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    }, 100);

    window.addEventListener('scroll', toggleButton);

    // Scroll to top on click
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
};

// ============================================
// 11. FORM VALIDATION
// ============================================

const FormValidation = {
  init() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
      form.addEventListener('submit', (e) => {
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
        }
        form.classList.add('was-validated');
      });

      // Real-time validation
      const inputs = form.querySelectorAll('input, select, textarea');
      inputs.forEach(input => {
        input.addEventListener('blur', () => {
          if (input.checkValidity()) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
          } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
          }
        });
      });
    });
  }
};

// ============================================
// 12. CAROUSEL INITIALIZATION
// ============================================

const CarouselInit = {
  init() {
    // Owl Carousel initialization (if jQuery and Owl Carousel are loaded)
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.owlCarousel !== 'undefined') {
      jQuery('.owl-carousel').each(function() {
        const $carousel = jQuery(this);
        const options = {
          items: $carousel.data('items') || 1,
          loop: $carousel.data('loop') !== false,
          autoplay: $carousel.data('autoplay') !== false,
          autoplayTimeout: $carousel.data('autoplay-timeout') || 5000,
          autoplayHoverPause: true,
          nav: $carousel.data('nav') !== false,
          dots: $carousel.data('dots') !== false,
          responsive: $carousel.data('responsive') || {
            0: { items: 1 },
            768: { items: $carousel.data('items-md') || 2 },
            992: { items: $carousel.data('items-lg') || 3 },
            1200: { items: $carousel.data('items') || 4 }
          }
        };
        $carousel.owlCarousel(options);
      });
    }
  }
};

// ============================================
// 13. DROPDOWN MENU ENHANCEMENTS
// ============================================

const DropdownMenu = {
  init() {
    const dropdowns = document.querySelectorAll('.dropdown, .custom-dropdown');
    
    dropdowns.forEach(dropdown => {
      const toggle = dropdown.querySelector('.dropbtn, .dropdown-toggle');
      const menu = dropdown.querySelector('.dropdown-content, .dropdown-menu');
      
      if (!toggle || !menu) return;

      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        // Close other dropdowns
        document.querySelectorAll('.dropdown-content.show, .dropdown-menu.show').forEach(otherMenu => {
          if (otherMenu !== menu) {
            otherMenu.classList.remove('show');
          }
        });
       
        menu.classList.toggle('show');
      });

      // Handle dropdown item selection
      const items = menu.querySelectorAll('li, .dropdown-item');
      items.forEach(item => {
        item.addEventListener('click', (e) => {
          const value = item.getAttribute('data-value');
          const text = item.textContent.trim();
          
          // Update button text if needed
          const btnText = toggle.querySelector('.dropdown-text');
          if (btnText) {
            btnText.textContent = text;
          } else {
            toggle.innerHTML = text + ' <span class="arrow">▼</span>';
          }
          
          menu.classList.remove('show');
          
          // Emit custom event
          dropdown.dispatchEvent(new CustomEvent('dropdown-change', {
            detail: { value, text }
          }));
        });
      });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
      document.querySelectorAll('.dropdown-content.show, .dropdown-menu.show').forEach(menu => {
        menu.classList.remove('show');
      });
    });
  }
};

// ============================================
// 14. TAB FUNCTIONALITY
// ============================================

const Tabs = {
  init() {
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    
    tabButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = button.getAttribute('data-tab-target');
        const targetPanel = document.querySelector(targetId);
        
        if (!targetPanel) return;

        // Remove active class from all buttons in this tab group
        const tabGroup = button.closest('[role="tablist"]');
        if (tabGroup) {
          tabGroup.querySelectorAll('[data-tab-target]').forEach(btn => {
            btn.classList.remove('active');
            btn.setAttribute('aria-selected', 'false');
          });
        }

        // Remove active class from all panels
        const allPanels = document.querySelectorAll('[role="tabpanel"]');
        allPanels.forEach(panel => {
          panel.classList.remove('active');
          panel.setAttribute('hidden', '');
        });

        // Add active class to clicked button and target panel
        button.classList.add('active');
        button.setAttribute('aria-selected', 'true');
        targetPanel.classList.add('active');
        targetPanel.removeAttribute('hidden');
      });
    });
  }
};

// ============================================
// 15. MODAL FUNCTIONALITY
// ============================================

const Modal = {
  init() {
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    
    modalTriggers.forEach(trigger => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        const modalId = trigger.getAttribute('data-modal-target');
        const modal = document.querySelector(modalId);
        
        if (modal) {
          this.open(modal);
        }
      });
    });

    // Close buttons
    const closeButtons = document.querySelectorAll('[data-modal-close]');
    closeButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const modal = button.closest('.modal');
        if (modal) {
          this.close(modal);
        }
      });
    });

    // Close on backdrop click
    document.querySelectorAll('.modal').forEach(modal => {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          this.close(modal);
        }
      });
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const openModal = document.querySelector('.modal.show');
        if (openModal) {
          this.close(openModal);
        }
      }
    });
  },

  open(modal) {
    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    
    // Focus first focusable element
    const focusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    if (focusable) {
      setTimeout(() => focusable.focus(), 100);
    }
  },

  close(modal) {
    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
};

// ============================================
// 16. ACCESSIBILITY ENHANCEMENTS
// ============================================

const Accessibility = {
  init() {
    // Add skip to main content link
    this.addSkipLink();
    
    // Enhance keyboard navigation
    this.enhanceKeyboardNav();
    
    // Add aria labels where missing
    this.addAriaLabels();
  },

  addSkipLink() {
    if (document.querySelector('.skip-to-main')) return;

    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.className = 'skip-to-main';
    skipLink.textContent = 'Skip to main content';
    document.body.insertBefore(skipLink, document.body.firstChild);
  },

  enhanceKeyboardNav() {
    // Add keyboard navigation to custom elements
    const interactiveElements = document.querySelectorAll('[role="button"]:not(button)');
    
    interactiveElements.forEach(element => {
      if (!element.hasAttribute('tabindex')) {
        element.setAttribute('tabindex', '0');
      }

      element.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          element.click();
        }
      });
    });
  },

  addAriaLabels() {
    // Add aria-labels to icons without text
    const iconButtons = document.querySelectorAll('a > i:only-child, button > i:only-child');
    
    iconButtons.forEach(icon => {
      const parent = icon.parentElement;
      if (!parent.getAttribute('aria-label') && !parent.getAttribute('title')) {
        const iconClass = icon.className;
        let label = 'Link'; // Default label
        
        // Try to determine label from icon class
        if (iconClass.includes('facebook')) label = 'Facebook';
        else if (iconClass.includes('twitter')) label = 'Twitter';
        else if (iconClass.includes('linkedin')) label = 'LinkedIn';
        else if (iconClass.includes('search')) label = 'Search';
        else if (iconClass.includes('close') || iconClass.includes('times')) label = 'Close';
        else if (iconClass.includes('menu') || iconClass.includes('bars')) label = 'Menu';
        
        parent.setAttribute('aria-label', label);
      }
    });
  }
};

// ============================================
// 17. PERFORMANCE MONITORING
// ============================================

const Performance = {
  init() {
    if ('PerformanceObserver' in window) {
      // Monitor Largest Contentful Paint
      try {
        const lcpObserver = new PerformanceObserver((entryList) => {
          const entries = entryList.getEntries();
          const lastEntry = entries[entries.length - 1];
          console.log('LCP:', lastEntry.renderTime || lastEntry.loadTime);
        });
        lcpObserver.observe({ entryTypes: ['largest-contentful-paint'] });
      } catch (e) {
        console.warn('LCP monitoring not supported');
      }

      // Monitor First Input Delay
      try {
        const fidObserver = new PerformanceObserver((entryList) => {
          const entries = entryList.getEntries();
          entries.forEach((entry) => {
            console.log('FID:', entry.processingStart - entry.startTime);
          });
        });
        fidObserver.observe({ entryTypes: ['first-input'] });
      } catch (e) {
        console.warn('FID monitoring not supported');
      }
    }
  }
};

// ============================================
// 18. INITIALIZE ALL MODULES
// ============================================

class App {
  init() {
    // DOM ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.ready());
    } else {
      this.ready();
    }

    // Window loaded
    window.addEventListener('load', () => this.loaded());
  }

  ready() {
    console.log('WAMDEVIN - Initializing...');
    
    // Initialize modules
    MobileNav.init();
    StickyHeader.init();
    SearchBox.init();
    ScrollReveal.init();
    CounterAnimation.init();
    LazyLoad.init();
    SmoothScroll.init();
    BackToTop.init();
    FormValidation.init();
    DropdownMenu.init();
    Tabs.init();
    Modal.init();
    Accessibility.init();
    
    // Initialize if jQuery is available
    if (typeof jQuery !== 'undefined') {
      CarouselInit.init();
    }

    console.log('WAMDEVIN - Ready!');
  }

  loaded() {
    LoadingScreen.init();
    
    // Performance monitoring (development only)
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
      Performance.init();
    }

    console.log('WAMDEVIN - Fully loaded!');
  }
}

// Start the application
const app = new App();
app.init();

// Export for external use
window.WAMDEVIN = WAMDEVIN;
