<x-guest-layout>
    <div class="min-h-screen bg-gray-900 flex flex-col justify-center items-center pt-6 sm:pt-0 px-4">
        
        <div class="mb-8">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logofinal.png') }}" alt="Logo" class="h-28 w-auto drop-shadow-2xl hover:scale-105 transition-transform duration-300">
            </a>
        </div>

        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-700/50">
            <div class="p-8">
                
                <h2 class="text-xl font-bold text-center text-gray-900 mb-4">¿Olvidaste tu contraseña?</h2>
                
                <div class="mb-6 text-sm text-gray-600 text-center leading-relaxed">
                    {{ __('No te preocupes. Simplemente escribe tu correo electrónico y te enviaremos un enlace para que elijas una nueva.') }}
                </div>

                <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50 text-center"
                            placeholder="tu@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-center" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all transform hover:-translate-y-0.5">
                            {{ __('Enviar enlace de recuperación') }}
                        </button>
                    </div>

                    <div class="mt-6 text-center border-t border-gray-100 pt-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition flex items-center justify-center gap-1">
                            <span>&larr;</span> Volver al inicio de sesión
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>