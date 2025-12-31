<x-guest-layout>
    <div class="min-h-screen bg-gray-900 flex flex-col justify-center items-center pt-6 sm:pt-0 px-4">
        
        <div class="mb-8">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logofinal.png') }}" alt="Logo" class="h-28 w-auto drop-shadow-2xl hover:scale-105 transition-transform duration-300">
            </a>
        </div>

        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-700/50">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">¡Hola de nuevo!</h2>
                <p class="text-center text-gray-500 mb-8 text-sm">Ingresa tus credenciales para continuar</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50" 
                            placeholder="tu@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50" 
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ml-2 text-gray-600">{{ __('Recuérdame') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-indigo-600 hover:text-indigo-800 font-semibold transition" href="{{ route('password.request') }}">
                                {{ __('Recuperar clave') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all transform hover:-translate-y-0.5">
                        {{ __('Iniciar Sesión') }}
                    </button>
                </form>
            </div>
            
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    ¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">Regístrate gratis</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>