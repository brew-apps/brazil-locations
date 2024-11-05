<?php

namespace Brew\BrazilLocations;

use Illuminate\Support\ServiceProvider;

class BrazilLocationsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Carrega as migrações
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Registra o comando
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'brazil-locations-migrations');


            $this->publishes([
                __DIR__.'/../database/seeders/StateSeeder.stub' => database_path('seeders/StateSeeder.php'),
            ], 'brazil-locations-seeders');

            // Publica seeders
            $this->publishes([
                __DIR__.'/../database/seeders/CitySeeder.stub' => database_path('seeders/CitySeeder.php'),
            ], 'brazil-locations-seeders');

            $this->publishes([
                __DIR__.'/Models/State.stub' => app_path('Models/State.php'),
            ], 'brazil-locations-models');

            $this->publishes([
                __DIR__.'/Models/City.stub' => app_path('Models/City.php'),
            ], 'brazil-locations-models');

            $this->commands([
                Commands\InstallCommand::class,
            ]);
        }
    }

    public function register()
    {
        //
    }
}
