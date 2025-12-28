<nav x-data="{ open: false }" class="bg-gray-800 nav-container sticky top-0 z-40">
    
    {{-- Carga de ciudades por seguridad --}}
    @php
        $navCities = \App\Models\Location::orderBy('name')->pluck('name');
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logofinal.png') }}" alt="BASE" class="h-16 w-auto" />
                </a>
            </div>

            <div class="hidden md:flex space-x-8 items-center flex-1 justify-center">
                {{-- ENLACES CORREGIDOS A COLOR BLANCO --}}
                <a href="{{ route('home') }}" 
                   class="px-3 py-2 text-sm font-medium border-b-2 transition {{ request()->routeIs('home') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }}">
                    Inicio
                </a>
                <a href="{{ route('events.index') }}" 
                   class="px-3 py-2 text-sm font-medium border-b-2 transition {{ request()->routeIs('events.index') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }}">
                    Eventos
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-3 py-2 text-sm font-medium border-b-2 transition {{ request()->routeIs('contact') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }}">
                    Contacto
                </a>

                <form action="{{ route('events.index') }}" method="GET">
                    <select 
                        name="location" 
                        onchange="this.form.submit()" 
                        class="bg-gray-700 border border-gray-600 text-gray-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent w-48 cursor-pointer"
                    >
                        <option value="" class="text-gray-400">📍 Ubicación...</option>
                        <option value="">-- Ver todas --</option>
                        
                        @foreach($navCities as $city)
                            <option value="{{ $city }}" {{ request('location') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('cart.index') }}" class="relative text-gray-300 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                @endauth

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Rol: {{ ucfirst(Auth::user()->role) }}</p>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('cart.index')">Mi Carrito</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm font-medium transition mr-4">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="bg-white text-gray-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition">Registrarse</a>
                    @endauth
                </div>
            </div>

            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-gray-800">
        <div class="pt-2 pb-2 px-4 border-b border-gray-700">
             <form action="{{ route('events.index') }}" method="GET">
                <select name="location" onchange="this.form.submit()" class="block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">📍 Ubicación...</option>
                    @foreach($navCities as $city)
                        <option value="{{ $city }}" {{ request('location') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            {{-- Enlaces Móviles Corregidos --}}
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('home') ? 'border-indigo-400 text-white bg-gray-900' : 'border-transparent text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300' }}">
                Inicio
            </a>
            <a href="{{ route('events.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('events.index') ? 'border-indigo-400 text-white bg-gray-900' : 'border-transparent text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300' }}">
                Eventos
            </a>
            <a href="{{ route('contact') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('contact') ? 'border-indigo-400 text-white bg-gray-900' : 'border-transparent text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300' }}">
                Contacto
            </a>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-700">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Profile') }}
                    </a>
                    <a href="{{ route('cart.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
                        Mi Carrito
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-700">
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
                    Registrarse
                </a>
            </div>
        @endauth
    </div>
</nav>