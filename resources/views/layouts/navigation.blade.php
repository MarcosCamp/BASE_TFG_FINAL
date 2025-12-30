{{-- Iniciamos Alpine aquí para controlar el carrito desde cualquier punto del nav --}}
<nav x-data="{ open: false, cartOpen: {{ session('cart_updated') ? 'true' : 'false' }} }" class="bg-gray-800 nav-container sticky top-0 z-40">
    
    @php
        $navCities = \App\Models\Location::orderBy('name')->pluck('name');
        // Calculamos cantidad total para la burbuja roja del icono
        $cartCount = 0;
        if(session('cart')) {
            foreach(session('cart') as $item) {
                $cartCount += $item['quantity'];
            }
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            {{-- LOGO --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logofinal.png') }}" alt="BASE" class="h-16 w-auto" />
                </a>
            </div>

            {{-- MENÚ CENTRAL --}}
            <div class="hidden md:flex space-x-8 items-center flex-1 justify-center">
                <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium border-b-2 transition {{ request()->routeIs('home') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white' }}">Inicio</a>
                <a href="{{ route('events.index') }}" class="px-3 py-2 text-sm font-medium border-b-2 transition {{ request()->routeIs('events.index') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white' }}">Eventos</a>
                <a href="{{ route('contact') }}" class="px-3 py-2 text-sm font-medium border-b-2 transition {{ request()->routeIs('contact') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white' }}">Contacto</a>

                <form action="{{ route('events.index') }}" method="GET">
                    <select name="location" onchange="this.form.submit()" class="bg-gray-700 border border-gray-600 text-gray-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-white w-48 cursor-pointer">
                        <option value="" class="text-gray-400">📍 Ubicación...</option>
                        <option value="">-- Ver todas --</option>
                        @foreach($navCities as $city)
                            <option value="{{ $city }}" {{ request('location') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            {{-- ICONOS DERECHA --}}
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    {{-- Botón Carrito (Abre el slide-over) --}}
                    <button @click="cartOpen = !cartOpen" class="relative text-gray-300 hover:text-white transition focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown Usuario --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <x-dropdown-link :href="route('cart.index')">Mi Carrito</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm font-medium transition mr-4">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="bg-white text-gray-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition">Registrarse</a>
                @endauth
            </div>
            
            {{-- Botón Móvil --}}
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL (Existente) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-gray-800">
       {{-- ... (Tu código del menú móvil que ya tenías) ... --}}
    </div>

    {{-- ========================================== --}}
    {{-- MINI-CARRITO DESPLEGABLE (SLIDE-OVER)      --}}
    {{-- ========================================== --}}
    
    <div x-show="cartOpen" 
         @click="cartOpen = false"
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity z-40"></div>

    <div class="fixed inset-y-0 right-0 max-w-md w-full flex z-50 pointer-events-none"
         x-show="cartOpen"
         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full">
         
        <div class="pointer-events-auto w-screen max-w-md">
            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                    <div class="flex items-start justify-between">
                        <h2 class="text-lg font-medium text-gray-900">Carrito de compras</h2>
                        <div class="ml-3 flex h-7 items-center">
                            <button type="button" @click="cartOpen = false" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Cerrar panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                        <li class="flex py-6">
                                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                @if(isset($details['image']))
                                                    <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="h-full w-full object-cover object-center">
                                                @else
                                                    <div class="h-full w-full bg-gray-200 flex items-center justify-center text-xs">Sin img</div>
                                                @endif
                                            </div>

                                            <div class="ml-4 flex flex-1 flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3><a href="#">{{ $details['name'] }}</a></h3>
                                                        <p class="ml-4">{{ number_format($details['price'] * $details['quantity'], 2) }}€</p>
                                                    </div>
                                                    <p class="mt-1 text-sm text-gray-500">{{ $details['artist'] ?? 'Artista' }}</p>
                                                </div>
                                                <div class="flex flex-1 items-end justify-between text-sm">
                                                    <p class="text-gray-500">Cant: {{ $details['quantity'] }}</p>
                                                    
                                                    {{-- Botón Eliminar --}}
                                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-indigo-600 hover:text-indigo-500">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="py-6 text-center text-gray-500">Tu carrito está vacío.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                    @php
                        $subtotal = 0;
                        if(session('cart')) {
                            foreach(session('cart') as $item) {
                                $subtotal += $item['price'] * $item['quantity'];
                            }
                        }
                    @endphp
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Subtotal</p>
                        <p>{{ number_format($subtotal, 2) }}€</p>
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500">Impuestos calculados al finalizar compra.</p>
                    <div class="mt-6">
                        <a href="{{ route('cart.index') }}" class="flex items-center justify-center rounded-md border border-transparent bg-gray-900 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-gray-800">
                            Ir al Carrito Completo
                        </a>
                    </div>
                    <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                        <p>
                            o
                            <button type="button" @click="cartOpen = false" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Continuar Comprando
                                <span aria-hidden="true"> &rarr;</span>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>