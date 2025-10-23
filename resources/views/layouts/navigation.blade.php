<nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-700/60 shadow-sm sticky top-0 z-50 transition-colors duration-300">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 bg-gradient-to-r from-green-50/30 via-blue-50/30 to-purple-50/30 dark:from-slate-800/30 dark:via-slate-700/30 dark:to-slate-600/30 pointer-events-none transition-colors duration-300"></div>
    <!-- Primary Navigation Menu -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-xl font-bold text-slate-800 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105 p-2">
                            <img src="{{ asset('money-transfer.png') }}" alt="Money Transfer" class="w-8 h-8 object-contain">
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-slate-800 dark:text-slate-200">Kas Management</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Data Uang Kas</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div id="desktop-nav" class="hidden space-x-2 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-slate-100/80 dark:hover:bg-slate-700/80">
                        <img src="{{ asset('money.png') }}" alt="Dashboard" class="w-5 h-5 object-contain">
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ __('Beranda') }}</span>
                    </x-nav-link>
                    @can('view_weekly_payments')
                    <x-nav-link :href="route('weekly-payments.index')" :active="request()->routeIs('weekly-payments.*')" class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-slate-100/80 dark:hover:bg-slate-700/80">
                        <img src="{{ asset('calendar.png') }}" alt="Kas Mingguan" class="w-5 h-5 object-contain">
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ __('Kas Mingguan') }}</span>
                    </x-nav-link>
                    @endcan
                    @can('view_transactions')
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-slate-100/80 dark:hover:bg-slate-700/80">
                        <img src="{{ asset('searching.png') }}" alt="Log Kas" class="w-5 h-5 object-contain">
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ __('Log Kas') }}</span>
                    </x-nav-link>
                    @endcan

                    @can('view_payment_proofs')
                    <x-nav-link :href="route('payment-proofs.index')" :active="request()->routeIs('payment-proofs.*')" class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-slate-100/80 dark:hover:bg-slate-700/80">
                        <img src="{{ asset('receipt.png') }}" alt="Bukti Pembayaran" class="w-5 h-5 object-contain">
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ __('Bukti Pembayaran') }}</span>
                    </x-nav-link>
                    @endcan


                </div>
            </div>


            <!-- Dark Mode Toggle -->
            <div class="flex items-center ml-4">
                <button id="dark-mode-toggle" class="inline-flex items-center px-3 py-2 border border-slate-200 dark:border-slate-600 text-sm leading-4 font-medium rounded-xl text-slate-700 dark:text-slate-300 bg-white/80 dark:bg-slate-800/80 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 focus:outline-none transition-all duration-200 shadow-sm hover:shadow-md">
                    <div class="flex items-center justify-center">
                        <!-- Moon Icon (Light Mode) -->
                        <svg id="moon-icon" class="w-5 h-5 text-slate-600 dark:text-slate-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <!-- Sun Icon (Dark Mode) -->
                        <svg id="sun-icon" class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </button>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-200 dark:border-slate-600 text-sm leading-4 font-medium rounded-xl text-slate-700 dark:text-slate-300 bg-white/80 dark:bg-slate-800/80 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 focus:outline-none transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="flex items-center justify-center mr-3">
                                <img src="{{ asset('profile.png') }}" alt="Profile" class="w-8 h-8 object-contain">
                            </div>
                            <div class="text-left">
                                <div class="font-medium text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                            <img src="{{ asset('profile.png') }}" alt="Profile" class="w-4 h-4 object-contain">
                            <span>{{ __('Profile') }}</span>
                        </x-dropdown-link>

                        @can('view_settings')
                        <x-dropdown-link :href="route('settings.index')" class="flex items-center space-x-2">
                            <img src="{{ asset('seting.png') }}" alt="Settings" class="w-4 h-4 object-contain">
                            <span>{{ __('Settings') }}</span>
                        </x-dropdown-link>
                        @endcan

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" class="flex items-center space-x-2"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <img src="{{ asset('logout.png') }}" alt="Logout" class="w-4 h-4 object-contain">
                                <span>{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>



</nav>
