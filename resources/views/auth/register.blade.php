<x-guest-layout>
    <div class="min-h-screen bg-gray-900 flex flex-col justify-center items-center pt-6 sm:pt-0 px-4 py-12">
        
        <div class="mb-8">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logofinal.png') }}" alt="Logo" class="h-28 w-auto drop-shadow-2xl hover:scale-105 transition-transform duration-300">
            </a>
        </div>

        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-700/50">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Crear Cuenta</h2>
                <p class="text-center text-gray-500 mb-8 text-sm">Únete a la comunidad de BASE</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50"
                            placeholder="Ej: Marcos Camp">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50"
                            placeholder="tu@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">¿Qué quieres hacer?</label>
                        <select id="role" name="role" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50 cursor-pointer">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Comprar entradas (Usuario)</option>
                            <option value="artist" {{ old('role') == 'artist' ? 'selected' : '' }}>Crear eventos (Artista)</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Tu Ciudad</label>
                        <select id="location" name="location" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50 cursor-pointer" required>
                            <option value="" disabled selected>Selecciona tu ciudad...</option>
                            @if(isset($cities))
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ old('location') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            @else
                                <option value="Madrid">Madrid</option>
                                <option value="Barcelona">Barcelona</option>
                                <option value="Valencia">Valencia</option>
                                <option value="Zaragoza">Zaragoza</option>
                                <option value="Sevilla">Sevilla</option>
                            @endif
                        </select>
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50"
                            placeholder="Mínimo 8 caracteres">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50"
                            placeholder="Repite la contraseña">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all transform hover:-translate-y-0.5">
                            {{ __('Registrarse') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    ¿Ya tienes cuenta? 
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>