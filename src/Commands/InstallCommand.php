<?php

namespace Brew\BrazilLocations\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'brazil-locations:install';
    protected $description = 'Instala as tabelas e dados de estados e cidades do Brasil';

    public function handle(): void
    {
        $this->info('Publicando as tabelas...');
        Artisan::call('vendor:publish', ['--tag' => 'brazil-locations-migrations']);

        $this->info('Executando as migrações...');
        Artisan::call('migrate', ['--path' => 'database/migrations/0001_02_01_000000_create_states_table.php']);
        Artisan::call('migrate', ['--path' => 'database/migrations/0001_02_01_000001_create_cities_table.php']);

        $this->info('Publicando modelos...');
        Artisan::call('vendor:publish', ['--tag' => 'brazil-locations-models']);

        $this->info('Publicando seeders...');
        Artisan::call('vendor:publish', ['--tag' => 'brazil-locations-seeders']);

        $this->info('Executando seeders...');
        Artisan::call('db:seed', ['--class' => 'StateSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'CitySeeder', '--force' => true]);

        $this->info('Instalação concluída com sucesso!');
    }
}
