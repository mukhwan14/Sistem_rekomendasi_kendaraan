<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm fixed w-full top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- 1. Logo (Left) -->
            <div class="shrink-0 flex items-center">
                <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('user.dashboard') }}" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="text-xl font-bold text-gray-800 tracking-tight">AutoExpert</span>
                </a>
            </div>

            <!-- 2. Navigation Links (Center) -->
            <div class="hidden sm:flex space-x-8">
                @if(Auth::user()->hasRole('admin'))
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-base font-medium">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.rules.index')" :active="request()->routeIs('admin.rules.*')" class="text-base font-medium">
                        {{ __('Kelola Rules') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.diagnosis_questions.index')" :active="request()->routeIs('admin.diagnosis_questions.*')" class="text-base font-medium">
                        {{ __('Pertanyaan Diagnosa') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.consultations.index')" :active="request()->routeIs('admin.consultations.*')" class="text-base font-medium">
                        {{ __('Laporan Konsultasi') }}
                    </x-nav-link>
                @else
                    <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')" class="text-base font-medium">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('consultation.create')" :active="request()->routeIs('consultation.create')" class="text-base font-medium">
                        {{ __('Konsultasi Baru') }}
                    </x-nav-link>
                    <x-nav-link :href="route('consultation.index')" :active="request()->routeIs('consultation.index')" class="text-base font-medium">
                        {{ __('Riwayat') }}
                    </x-nav-link>
                @endif
            </div>

            <!-- 3. Settings Dropdown (Right) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-gray-50 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150 gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.rules.index')" :active="request()->routeIs('admin.rules.*')">
                    {{ __('Kelola Rules') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.diagnosis_questions.index')" :active="request()->routeIs('admin.diagnosis_questions.*')">
                    {{ __('Pertanyaan Diagnosa') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.consultations.index')" :active="request()->routeIs('admin.consultations.*')">
                    {{ __('Laporan Konsultasi') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('consultation.create')" :active="request()->routeIs('consultation.create')">
                    {{ __('Konsultasi Baru') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('consultation.index')" :active="request()->routeIs('consultation.index')">
                    {{ __('Riwayat') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
