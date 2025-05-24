<!-- Scripts -->
<!-- Load jQuery only if not already loaded -->
@if (!request()->hasCookie('jquery_loaded'))
    <script>
        (function() {
            if (window.jQuery) return;
            
            var script = document.createElement('script');
            script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
            script.integrity = 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=';
            script.crossOrigin = 'anonymous';
            script.async = true;
            
            // Set a cookie to indicate jQuery is loaded
            script.onload = function() {
                document.cookie = 'jquery_loaded=true; path=/; max-age=31536000; samesite=lax';
            };
            
            // Fallback to local copy if CDN fails
            script.onerror = function() {
                var fallback = document.createElement('script');
                fallback.src = '{{ asset('js/jquery-3.6.0.min.js') }}';
                document.head.appendChild(fallback);
            };
            
            document.head.appendChild(script);
        })();
    </script>
@endif

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

<!-- Load Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Custom Application JavaScript -->
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fix for grid layout issues -->
<style>
    /* Fix for responsive grid layout */
    .grid {
        display: grid;
    }
    
    /* Ensure proper overflow handling in tables */
    .overflow-x-auto {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Fix for modal positioning */
    [x-cloak] { display: none !important; }
    
    /* Ensure dropdowns position correctly */
    .dropdown-menu {
        position: absolute;
        z-index: 1000;
    }
    
    /* Fix for mobile responsiveness */
    @media (max-width: 640px) {
        .sm\:grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .sm\:grid-cols-2.force-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>
@yield('scripts')
