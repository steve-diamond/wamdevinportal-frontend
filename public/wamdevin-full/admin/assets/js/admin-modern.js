/**
 * WAMDEVIN Admin Dashboard - Modern JavaScript
 * Version: 2.0.0
 * Last Updated: February 2026
 * Description: Consolidated, modern ES6+ JavaScript for admin dashboard
 */

'use strict';

// ==============================================
// ADMIN DASHBOARD CORE MODULE
// ==============================================

const WamdevinAdmin = (function() {
    
    // Private variables
    let initialized = false;
    const config = {
        sidebarExpandedClass: 'ttr-opened-sidebar',
        sidebarPinnedClass: 'ttr-pinned-sidebar',
        mobileBreakpoint: 991
    };
    
    // ==============================================
    // SIDEBAR MANAGEMENT
    // ==============================================
    
    const Sidebar = {
        init() {
            this.bindEvents();
            this.checkViewport();
            this.restoreState();
        },
        
        bindEvents() {
            // Toggle sidebar button
            const toggleBtn = document.querySelector('.ttr-toggle-sidebar');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => this.toggle());
            }
            
            // Collapse sidebar button
            const collapseBtn = document.querySelector('.ttr-sidebar-toggle-button');
            if (collapseBtn) {
                collapseBtn.addEventListener('click', () => this.toggle());
                
                // Keyboard accessibility
                collapseBtn.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.toggle();
                    }
                });
            }
            
            // Submenu toggles
            document.querySelectorAll('.ttr-sidebar-navi .ttr-material-button[aria-haspopup="true"]').forEach(toggle => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.toggleSubmenu(toggle);
                });
            });
            
            // Close sidebar on overlay click (mobile)
            const overlay = document.querySelector('.ttr-overlay');
            if (overlay) {
                overlay.addEventListener('click', () => this.close());
            }
            
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => this.checkViewport(), 250);
            });
        },
        
        toggle() {
            document.body.classList.toggle(config.sidebarExpandedClass);
            this.updateAriaStates();
            this.saveState();
        },
        
        open() {
            document.body.classList.add(config.sidebarExpandedClass);
            this.updateAriaStates();
        },
        
        close() {
            document.body.classList.remove(config.sidebarExpandedClass);
            this.updateAriaStates();
        },
        
        toggleSubmenu(toggle) {
            const parent = toggle.parentElement;
            const isExpanded = parent.classList.contains('show');
            
            // Close all other submenus
            document.querySelectorAll('.ttr-sidebar-navi li.show').forEach(item => {
                if (item !== parent) {
                    item.classList.remove('show');
                    const btn = item.querySelector('.ttr-material-button[aria-haspopup="true"]');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                }
            });
            
            // Toggle current submenu
            parent.classList.toggle('show');
            toggle.setAttribute('aria-expanded', !isExpanded);
        },
        
        updateAriaStates() {
            const isExpanded = document.body.classList.contains(config.sidebarExpandedClass);
            const toggleBtn = document.querySelector('.ttr-toggle-sidebar');
            if (toggleBtn) {
                toggleBtn.setAttribute('aria-expanded', isExpanded);
            }
        },
        
        checkViewport() {
            const isMobile = window.innerWidth <= config.mobileBreakpoint;
            if (isMobile) {
                document.body.classList.remove(config.sidebarPinnedClass);
            } else {
                document.body.classList.add(config.sidebarPinnedClass);
            }
        },
        
        saveState() {
            const isExpanded = document.body.classList.contains(config.sidebarExpandedClass);
            try {
                localStorage.setItem('wamdevin_admin_sidebar', isExpanded ? 'expanded' : 'collapsed');
            } catch (e) {
                console.warn('Could not save sidebar state:', e);
            }
        },
        
        restoreState() {
            try {
                const state = localStorage.getItem('wamdevin_admin_sidebar');
                if (state === 'collapsed' && window.innerWidth > config.mobileBreakpoint) {
                    document.body.classList.remove(config.sidebarExpandedClass);
                }
            } catch (e) {
                console.warn('Could not restore sidebar state:', e);
            }
        }
    };
    
    // ==============================================
    // SEARCH FUNCTIONALITY
    // ==============================================
    
    const Search = {
        init() {
            this.bindEvents();
        },
        
        bindEvents() {
            const searchToggle = document.querySelector('.ttr-search-toggle');
            const searchClose = document.querySelector('.ttr-search-close');
            const searchBar = document.querySelector('.ttr-search-bar');
            
            if (searchToggle) {
                searchToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.open();
                });
            }
            
            if (searchClose) {
                searchClose.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.close();
                });
            }
            
            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && searchBar?.classList.contains('show')) {
                    this.close();
                }
            });
        },
        
        open() {
            const searchBar = document.querySelector('.ttr-search-bar');
            const searchInput = document.querySelector('.ttr-search-input');
            
            if (searchBar) {
                searchBar.classList.add('show');
                if (searchInput) {
                    setTimeout(() => searchInput.focus(), 100);
                }
            }
        },
        
        close() {
            const searchBar = document.querySelector('.ttr-search-bar');
            if (searchBar) {
                searchBar.classList.remove('show');
            }
        }
    };
    
    // ==============================================
    // NOTIFICATIONS
    // ==============================================
    
    const Notifications = {
        init() {
            this.bindEvents();
        },
        
        bindEvents() {
            // Dismiss notification buttons
            document.querySelectorAll('.notification-time .fa-close').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.dismiss(btn);
                });
            });
        },
        
        dismiss(btn) {
            const listItem = btn.closest('li');
            if (listItem) {
                listItem.style.opacity = '0';
                listItem.style.transform = 'translateX(100%)';
                listItem.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    listItem.remove();
                    this.updateBadge();
                }, 300);
            }
        },
        
        updateBadge() {
            const notificationLists = document.querySelectorAll('.noti-box-list ul');
            let totalCount = 0;
            
            notificationLists.forEach(list => {
                totalCount += list.children.length;
            });
            
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                badge.textContent = totalCount;
                badge.setAttribute('aria-label', `${totalCount} unread notifications`);
                
                if (totalCount === 0) {
                    badge.style.display = 'none';
                }
            }
        }
    };
    
    // ==============================================
    // COUNTER ANIMATION
    // ==============================================
    
    const Counter = {
        init() {
            this.observeCounters();
        },
        
        observeCounters() {
            const counters = document.querySelectorAll('.counter');
            
            if (!counters.length) return;
            
            // Use Intersection Observer for performance
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.dataset.counted) {
                        this.animateCounter(entry.target);
                        entry.target.dataset.counted = 'true';
                    }
                });
            }, {
                threshold: 0.5
            });
            
            counters.forEach(counter => observer.observe(counter));
        },
        
        animateCounter(element) {
            const target = parseFloat(element.textContent);
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            };
            
            updateCounter();
        }
    };
    
    // ==============================================
    // TOOLTIPS
    // ==============================================
    
    const Tooltips = {
        init() {
            // Initialize Bootstrap tooltips if available
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(
                    document.querySelectorAll('[data-bs-toggle="tooltip"]')
                );
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }
    };
    
    // ==============================================
    // UTILITIES
    // ==============================================
    
    const Utils = {
        // Format numbers with commas
        formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        
        // Debounce function
        debounce(func, wait) {
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
        
        // Show toast notification (simple implementation)
        showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `admin-toast admin-toast-${type}`;
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
                color: white;
                padding: 16px 24px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                animation: slideInRight 0.3s ease;
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    };
    
    // ==============================================
    // PUBLIC API
    // ==============================================
    
    return {
        init() {
            if (initialized) {
                console.warn('WamdevinAdmin already initialized');
                return;
            }
            
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.initModules());
            } else {
                this.initModules();
            }
            
            initialized = true;
        },
        
        initModules() {
            Sidebar.init();
            Search.init();
            Notifications.init();
            Counter.init();
            Tooltips.init();
            
            console.log('WAMDEVIN Admin Dashboard v2.0.0 initialized');
        },
        
        // Expose utilities
        utils: Utils,
        
        // Expose modules for external access
        sidebar: {
            open: () => Sidebar.open(),
            close: () => Sidebar.close(),
            toggle: () => Sidebar.toggle()
        },
        
        search: {
            open: () => Search.open(),
            close: () => Search.close()
        }
    };
    
})();

// ==============================================
// AUTO-INITIALIZE
// ==============================================

WamdevinAdmin.init();

// Make available globally
window.WamdevinAdmin = WamdevinAdmin;

// ==============================================
// LOADING SCREEN HANDLER
// ==============================================

window.addEventListener('load', function() {
    setTimeout(function() {
        const loader = document.getElementById('admin-loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(function() {
                loader.style.display = 'none';
            }, 300);
        }
    }, 100);
});
