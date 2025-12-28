<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema; // Importante para bases de datos
use App\Models\Location; // Importamos el modelo

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Esto evita errores de longitud de clave en algunas bases de datos
        Schema::defaultStringLength(191);

        // COMPARTIR CIUDADES GLOBALMENTE
        // Usamos un try/catch para que no falle si aún no has migrado la tabla
        try {
            if (Schema::hasTable('locations')) {
                $navCities = Location::orderBy('name')->pluck('name');
                View::share('navCities', $navCities);
            } else {
                View::share('navCities', []);
            }
        } catch (\Exception $e) {
            View::share('navCities', []);
        }
    }
}