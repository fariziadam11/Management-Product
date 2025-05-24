/**
 * Coding Test Application JavaScript
 * Modular JavaScript for Tailwind-based UI components
 */

// Core UI Module
const UICore = (function() {
    // Private variables
    const dropdownSelectors = {
        toggle: '[data-toggle="dropdown"]',
        menu: '.dropdown-menu',
        activeClass: 'show',
        hiddenClass: 'hidden'
    };

    // Initialize all UI components
    function init() {
        initSidebar();
        initDropdowns();
        initModals();
        initAlerts();
        initTables();
        
        // Dispatch event to notify initialization is complete
        document.dispatchEvent(new CustomEvent('ui-initialized'));
    }

    // Sidebar functionality
    function initSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggleTop');
        const sidebar = document.getElementById('sidebarMenu');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('md:flex');
            });
        }
    }

    // Dropdown functionality - compatible with both Bootstrap and Alpine.js
    function initDropdowns() {
        // Skip dropdowns managed by Alpine.js
        const dropdownToggles = document.querySelectorAll(`${dropdownSelectors.toggle}:not([x-data])`);
        
        // Remove existing listeners to prevent duplicates
        dropdownToggles.forEach(toggle => {
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);
            
            newToggle.addEventListener('click', handleDropdownToggle);
        });

        // Close dropdowns when clicking outside
        document.removeEventListener('click', handleDocumentClick);
        document.addEventListener('click', handleDocumentClick);
        
        // Close dropdowns when pressing escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllDropdowns();
            }
        });
        
        // Ensure Alpine.js dropdowns close when another one opens
        document.addEventListener('alpine:initialized', () => {
            if (window.Alpine) {
                // Listen for Alpine dropdown opens and close others
                document.addEventListener('click', function(e) {
                    // Check if the clicked element is a dropdown toggle with Alpine
                    if (e.target.closest('[x-data="dropdown"], [x-data="notifications"]')) {
                        // Close all non-Alpine dropdowns
                        closeAllDropdowns();
                    }
                });
            }
        });
    }

    function handleDropdownToggle(e) {
        e.preventDefault();
        e.stopPropagation();

        const targetId = this.getAttribute('aria-controls');
        const target = targetId ? document.getElementById(targetId) : this.nextElementSibling;

        if (target && target.classList.contains('dropdown-menu')) {
            // Close other open dropdowns
            closeAllDropdowns(target);

            // Toggle current dropdown
            target.classList.toggle(dropdownSelectors.hiddenClass);
        }
    }

    function closeAllDropdowns(except = null) {
        document.querySelectorAll(dropdownSelectors.menu).forEach(menu => {
            if (menu !== except && !menu.classList.contains(dropdownSelectors.hiddenClass)) {
                menu.classList.add(dropdownSelectors.hiddenClass);
            }
        });
    }

    function handleDocumentClick(e) {
        if (!e.target.closest('.dropdown') && !e.target.matches(dropdownSelectors.toggle)) {
            closeAllDropdowns();
        }
    }

    // Modal functionality
    function initModals() {
        // Global modal functions
        window.openModal = function(modalId) {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: modalId }));
        };

        window.closeModal = function(modalId) {
            window.dispatchEvent(new CustomEvent('close-modal', { detail: modalId }));
        };

        // Handle legacy modal triggers
        document.querySelectorAll('[data-toggle="modal"]').forEach(trigger => {
            const targetId = trigger.getAttribute('data-target');
            if (targetId) {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.openModal(targetId.replace('#', ''));
                });
            }
        });
    }

    // Alert dismissal
    function initAlerts() {
        const dismissButtons = document.querySelectorAll('[data-dismiss="alert"]');
        dismissButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alert = this.closest('[role="alert"]');
                if (alert) {
                    alert.remove();
                }
            });
        });
    }

    // Table functionality
    function initTables() {
        // Handle table sorting events from Alpine.js components
        window.addEventListener('sort-table', function(e) {
            const { tableId, field, direction } = e.detail;
            console.log(`Sorting table ${tableId} by ${field} in ${direction} order`);
            // Implement server-side sorting if needed
        });

        // Fix responsive tables
        document.querySelectorAll('.overflow-x-auto table').forEach(table => {
            const wrapper = table.closest('.overflow-x-auto');
            if (wrapper) {
                wrapper.style.display = 'block';
                wrapper.style.width = '100%';
            }
        });
    }

    // Public API
    return {
        init: init,
        openModal: function(id) { window.openModal(id); },
        closeModal: function(id) { window.closeModal(id); },
        closeDropdowns: closeAllDropdowns
    };
})();

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', UICore.init);
} else {
    UICore.init();
}

// Re-initialize UI when content is dynamically loaded (e.g., AJAX)
document.addEventListener('content-loaded', UICore.init);
