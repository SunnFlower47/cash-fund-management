<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- PWA Meta Tags -->
    <meta name="application-name" content="Kas Management">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Kas Mgmt">
    <meta name="description" content="Aplikasi manajemen kas untuk organisasi">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="msapplication-config" content="/icons/browserconfig.xml">
    <meta name="msapplication-TileColor" content="#4f46e5">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="theme-color" content="#4f46e5">

    <!-- PWA Icons -->
    <link rel="apple-touch-icon" href="/money-transfer.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/money-transfer.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/money-transfer.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/money-transfer.png" color="#4f46e5">
    <link rel="shortcut icon" href="/money-transfer.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Prevent FOUC (Flash of Unstyled Content) for Dark Mode -->
    <script>
        // Apply dark mode immediately to prevent flash
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Alpine.js x-cloak CSS -->
    <style>
        [x-cloak] { display: none !important; }

        /* Prevent flash of light content */
        html:not(.dark) {
            background-color: #0f172a;
        }

        html.dark {
            background-color: #0f172a;
        }

        /* Smooth page transitions */
        body {
            transition: opacity 0.2s ease-in-out;
        }

        body.loading {
            opacity: 0.7;
        }

        /* Loading Animation - Bouncing Dots */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-dots {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .loading-dot {
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #10b981, #34d399);
            border-radius: 50%;
            animation: bounce 1.4s ease-in-out infinite both;
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
        }

        .loading-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .loading-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        .loading-dot:nth-child(3) {
            animation-delay: 0s;
        }

        .loading-dot:nth-child(4) {
            animation-delay: 0.16s;
        }

        .loading-dot:nth-child(5) {
            animation-delay: 0.32s;
        }

        @keyframes bounce {
            0%, 80%, 100% {
                transform: scale(0.8) translateY(0);
                opacity: 0.5;
            }
            40% {
                transform: scale(1.2) translateY(-20px);
                opacity: 1;
            }
        }

        /* Wave Animation */
        .loading-wave {
            position: relative;
            width: 60px;
            height: 60px;
            margin: 0 auto;
        }

        .loading-wave::before,
        .loading-wave::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid #10b981;
            border-radius: 50%;
            animation: wave 2s linear infinite;
        }

        .loading-wave::after {
            animation-delay: -1s;
        }

        @keyframes wave {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 0;
            }
        }
    </style>

    <!-- Preload critical pages -->
    <link rel="prefetch" href="{{ route('dashboard') }}">
    <link rel="prefetch" href="{{ route('transactions.index') }}">
    <link rel="prefetch" href="{{ route('payment-proofs.index') }}">
    <link rel="prefetch" href="{{ route('weekly-payments.index') }}">
    <link rel="prefetch" href="{{ route('settings.index') }}">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-green-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 transition-colors duration-300">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="text-center">
            <!-- Bouncing Dots -->
            <div class="loading-dots mb-4">
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
            </div>

            <!-- Wave Animation -->
            <div class="loading-wave mb-4"></div>

            <!-- Loading Text -->
            <p class="text-slate-300 text-sm font-medium">Loading...</p>
        </div>
    </div>

    <div class="min-h-screen pb-24 sm:pb-0">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700 border-b border-slate-200/60 dark:border-slate-600/60 shadow-sm transition-colors duration-300">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="pb-8">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Bottom Navigation Bar -->
    <div class="sm:hidden fixed bottom-0 left-0 right-0 z-[9999] bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-purple-200/60 dark:border-slate-700/60 shadow-lg transition-colors duration-300">
        <div class="flex items-center justify-between py-3 px-4">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center space-y-1.5 px-2 py-2 rounded-xl transition-all duration-200 min-w-0 flex-1 {{ request()->routeIs('dashboard') ? 'bg-purple-100/80 dark:bg-purple-900/80' : 'hover:bg-purple-50 dark:hover:bg-purple-900/50' }}">
                <div class="w-8 h-8 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-br from-indigo-500 to-purple-500' : 'bg-gradient-to-br from-indigo-400 to-purple-400' }} rounded-xl flex items-center justify-center shadow-sm">
                    <img src="{{ asset('money.png') }}" alt="Dashboard" class="w-4 h-4 object-contain">
                </div>
                <span class="text-xs font-medium {{ request()->routeIs('Dashboard') ? 'text-purple-700 dark:text-purple-300' : 'text-slate-600 dark:text-slate-400' }}">Beranda</span>
            </a>
            @can('view_weekly_payments')
            <!-- Kas Mingguan -->
            <a href="{{ route('weekly-payments.index') }}" class="flex flex-col items-center space-y-1.5 px-2 py-2 rounded-xl transition-all duration-200 min-w-0 flex-1 {{ request()->routeIs('weekly-payments.*') ? 'bg-green-100/80 dark:bg-green-900/80' : 'hover:bg-green-50 dark:hover:bg-green-900/50' }}">
                <div class="w-8 h-8 {{ request()->routeIs('weekly-payments.*') ? 'bg-gradient-to-br from-green-500 to-emerald-500' : 'bg-gradient-to-br from-green-400 to-emerald-400' }} rounded-xl flex items-center justify-center shadow-sm">
                    <img src="{{ asset('calendar.png') }}" alt="Kas Mingguan" class="w-4 h-4 object-contain">
                </div>
                <span class="text-xs font-medium {{ request()->routeIs('weekly-payments.*') ? 'text-green-700 dark:text-green-300' : 'text-slate-600 dark:text-slate-400' }}">Kas M</span>
            </a>
            @endcan
            @can('view_transactions')
            <!-- Log Kas -->
            <a href="{{ route('transactions.index') }}" class="flex flex-col items-center space-y-1.5 px-2 py-2 rounded-xl transition-all duration-200 min-w-0 flex-1 {{ request()->routeIs('transactions.*') ? 'bg-pink-100/80 dark:bg-pink-900/80' : 'hover:bg-pink-50 dark:hover:bg-pink-900/50' }}">
                <div class="w-8 h-8 {{ request()->routeIs('transactions.*') ? 'bg-gradient-to-br from-pink-500 to-rose-500' : 'bg-gradient-to-br from-pink-400 to-rose-400' }} rounded-xl flex items-center justify-center shadow-sm">
                    <img src="{{ asset('searching.png') }}" alt="Log Kas" class="w-4 h-4 object-contain">
                </div>
                <span class="text-xs font-medium {{ request()->routeIs('transactions.*') ? 'text-pink-700 dark:text-pink-300' : 'text-slate-600 dark:text-slate-400' }}">Log Kas</span>
            </a>
            @endcan

            @can('view_payment_proofs')
            <!-- Bukti Pembayaran -->
            <a href="{{ route('payment-proofs.index') }}" class="flex flex-col items-center space-y-1.5 px-2 py-2 rounded-xl transition-all duration-200 min-w-0 flex-1 {{ request()->routeIs('payment-proofs.*') ? 'bg-purple-100/80 dark:bg-purple-900/80' : 'hover:bg-purple-50 dark:hover:bg-purple-900/50' }}">
                <div class="w-8 h-8 {{ request()->routeIs('payment-proofs.*') ? 'bg-gradient-to-br from-purple-500 to-indigo-500' : 'bg-gradient-to-br from-purple-400 to-indigo-400' }} rounded-xl flex items-center justify-center shadow-sm">
                    <img src="{{ asset('receipt.png') }}" alt="Bukti Pembayaran" class="w-4 h-4 object-contain">
                </div>
                <span class="text-xs font-medium {{ request()->routeIs('payment-proofs.*') ? 'text-purple-700 dark:text-purple-300' : 'text-slate-600 dark:text-slate-400' }}">Bukti P</span>
            </a>
            @endcan



            <!-- Profile Menu -->
            <div class="relative flex-1 min-w-0" x-data="{ open: false }">
                <button @click="open = !open" class="flex flex-col items-center space-y-1.5 px-2 py-2 rounded-xl transition-all duration-200 hover:bg-purple-50 dark:hover:bg-purple-900/50 w-full">
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-xl flex items-center justify-center shadow-sm">
                        <span class="text-white text-xs font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Profile</span>
                </button>

                <!-- Profile Dropdown -->
                <div x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     x-cloak
                     class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-48 bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-2xl shadow-xl border border-purple-200/60 dark:border-slate-700/60 py-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 dark:hover:bg-purple-900/50 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        <div class="flex items-center justify-center">
                                     <img src="{{ asset('profile.png') }}" alt="Profile" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Profile</span>
                    </a>
                    @can('view_settings')
                    <a href="{{ route('settings.index') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 dark:hover:bg-purple-900/50 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('seting.png') }}" alt="Settings" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Settings</span>
                    </a>
                    @endcan
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 px-4 py-3 hover:bg-pink-50 dark:hover:bg-pink-900/50 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] w-full text-left">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('logout.png') }}" alt="Logout" class="w-6 h-6 object-contain">
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Smooth Navigation with Loading Animation -->
    <script>
        // Add loading state for navigation
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="/"]');
            const loadingOverlay = document.getElementById('loadingOverlay');

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Skip if it's a download link or external link
                    if (this.hasAttribute('download') || this.target === '_blank') {
                        return;
                    }

                    // Show loading animation
                    loadingOverlay.classList.add('show');
                    document.body.classList.add('loading');

                    // Hide loading animation after page loads
                    window.addEventListener('load', function() {
                        setTimeout(() => {
                            loadingOverlay.classList.remove('show');
                            document.body.classList.remove('loading');
                        }, 300);
                    });
                });
            });

            // Hide loading on page load
            window.addEventListener('load', function() {
                setTimeout(() => {
                    loadingOverlay.classList.remove('show');
                    document.body.classList.remove('loading');
                }, 500);
            });
        });
    </script>

    <!-- SweetAlert2 for Success Messages -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#10b981',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    <!-- SweetAlert2 for Error Messages -->
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    <!-- SweetAlert2 for Warning Messages -->
    @if(session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: '{{ session('warning') }}',
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    <!-- SweetAlert2 for Info Messages -->
    @if(session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: '{{ session('info') }}',
            confirmButtonColor: '#3b82f6',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    <!-- PWA Service Worker Registration -->
    <script>
        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('Service Worker registered successfully:', registration.scope);
                    })
                    .catch(function(error) {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }

        // PWA Install Prompt
        let deferredPrompt;
        let installButton;

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome 67 and earlier from automatically showing the prompt
            e.preventDefault();
            // Stash the event so it can be triggered later
            deferredPrompt = e;
            // Show install button
            showInstallButton();
        });

        function showInstallButton() {
            // Create install button if it doesn't exist
            if (!document.getElementById('pwa-install-btn')) {
                const installBtn = document.createElement('button');
                installBtn.id = 'pwa-install-btn';
                installBtn.innerHTML = `
                    <div class="fixed top-4 right-4 z-50 bg-gradient-to-r from-purple-500 to-pink-500 text-white px-3 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 sm:px-4">
                        <div class="flex items-center space-x-2">
                            <img src="/money-transfer.png" alt="Install" class="w-4 h-4 sm:w-5 sm:h-5">
                            <span class="text-xs sm:text-sm font-semibold">Install</span>
                        </div>
                    </div>
                `;
                installBtn.onclick = installApp;
                document.body.appendChild(installBtn);

                // Hide install button on mobile when scrolling to bottom (near mobile nav)
                let isNearBottom = false;
                window.addEventListener('scroll', () => {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const windowHeight = window.innerHeight;
                    const documentHeight = document.documentElement.scrollHeight;

                    // Check if user is near bottom (within 100px of mobile nav)
                    const nearBottom = (scrollTop + windowHeight) >= (documentHeight - 100);

                    if (nearBottom !== isNearBottom) {
                        isNearBottom = nearBottom;
                        const installDiv = installBtn.querySelector('div');
                        if (installDiv) {
                            installDiv.style.opacity = isNearBottom ? '0.3' : '1';
                            installDiv.style.pointerEvents = isNearBottom ? 'none' : 'auto';
                        }
                    }
                });
            }
        }

        function installApp() {
            if (deferredPrompt) {
                // Show the install prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    // Clear the deferredPrompt
                    deferredPrompt = null;
                    // Hide install button
                    const installBtn = document.getElementById('pwa-install-btn');
                    if (installBtn) {
                        installBtn.remove();
                    }
                });
            }
        }

        // Hide install button when app is installed
        window.addEventListener('appinstalled', (evt) => {
            console.log('PWA was installed');
            const installBtn = document.getElementById('pwa-install-btn');
            if (installBtn) {
                installBtn.remove();
            }
        });

        // Check if app is already installed
        if (window.matchMedia('(display-mode: standalone)').matches) {
            console.log('App is running in standalone mode');
        }

        // Dark Mode Toggle
        function initDarkMode() {
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const moonIcon = document.getElementById('moon-icon');
            const sunIcon = document.getElementById('sun-icon');
            const html = document.documentElement;

            console.log('Initializing dark mode...');
            console.log('Toggle element:', darkModeToggle);
            console.log('Moon icon:', moonIcon);
            console.log('Sun icon:', sunIcon);

            if (!darkModeToggle) {
                console.error('Dark mode toggle not found');
                return;
            }

            // Check for saved theme preference or default to 'dark'
            const currentTheme = localStorage.getItem('theme') || 'dark';
            console.log('Current theme from localStorage:', currentTheme);

            // Apply theme immediately
            if (currentTheme === 'dark') {
                html.classList.add('dark');
                console.log('Applied dark class');
            } else {
                html.classList.remove('dark');
                console.log('Removed dark class');
            }

            // Update icon based on current theme
            updateDarkModeIcon();

            // Add click event listener
            darkModeToggle.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Dark mode toggle clicked!');

                const isDark = html.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateDarkModeIcon();

                console.log('Theme changed to:', isDark ? 'dark' : 'light');
                console.log('HTML classes:', html.className);
            };

            function updateDarkModeIcon() {
                const isDark = html.classList.contains('dark');
                console.log('Updating icons, isDark:', isDark);

                if (moonIcon && sunIcon) {
                    if (isDark) {
                        moonIcon.classList.add('hidden');
                        sunIcon.classList.remove('hidden');
                    } else {
                        moonIcon.classList.remove('hidden');
                        sunIcon.classList.add('hidden');
                    }
                }
            }
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDarkMode);
        } else {
            initDarkMode();
        }
    </script>

</body>
</html>
