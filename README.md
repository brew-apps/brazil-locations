# Brazil Locations

[![Latest Version on Packagist](https://img.shields.io/packagist/v/brew/brazil-locations.svg)](https://packagist.org/packages/brew/brazil-locations)
[![Total Downloads](https://img.shields.io/packagist/dt/brew/brazil-locations.svg)](https://packagist.org/packages/brew/brazil-locations)
[![License](https://img.shields.io/packagist/l/brew/brazil-locations.svg)](LICENSE)

**English** | [Português](#português)

Laravel package that seeds all 27 Brazilian states and 5,570 municipalities into your database, with ready-to-use `State` and `City` Eloquent models and relationships. One `composer require`, one artisan command, done.

Every record carries its official **IBGE code**, so you can safely integrate with government APIs, NF-e/NFS-e issuers, shipping carriers and any other service that relies on IBGE identifiers.

## Requirements

- PHP 8.1+
- Laravel 10+

## Installation

Require the package via Composer:

```bash
composer require brew/brazil-locations
```

Run the install command:

```bash
php artisan brazil-locations:install
```

That's it. The command will:

1. Publish the migrations to `database/migrations`
2. Run the migrations (`states` and `cities` tables)
3. Publish the `State` and `City` models to `app/Models`
4. Publish the `StateSeeder` and `CitySeeder` to `database/seeders`
5. Run both seeders

Because the models and seeders are **published into your application**, you own them and are free to extend or customize them as you see fit.

## Database schema

**`states`**

| Column      | Type        | Notes                    |
|-------------|-------------|--------------------------|
| `id`        | bigint      | Primary key              |
| `name`      | string      | e.g. `São Paulo`         |
| `uf`        | string(2)   | Unique, e.g. `SP`        |
| `ibge_code` | string      | Unique, e.g. `35`        |
| timestamps  |             |                          |

**`cities`**

| Column      | Type        | Notes                          |
|-------------|-------------|--------------------------------|
| `id`        | bigint      | Primary key                    |
| `name`      | string      | e.g. `Campinas`                |
| `state_id`  | foreignId   | References `states.id`         |
| `ibge_code` | string      | Unique, e.g. `3509502`         |
| timestamps  |             |                                |

## Usage

### Listing states

```php
use App\Models\State;

$states = State::orderBy('name')->get();
```

### Cities of a state

```php
$state  = State::where('uf', 'SP')->first();
$cities = $state->cities;
```

### State of a city

```php
use App\Models\City;

$city  = City::where('ibge_code', '3509502')->first();
$state = $city->state; // São Paulo
```

### Eager loading

```php
$states = State::with('cities')->get();
```

### Typical use cases

- Dependent select fields (state → city) in forms, Livewire or Filament resources
- Validating addresses against IBGE codes
- Fiscal integrations (NF-e, NFS-e) that require the municipality IBGE code
- Reports and filters grouped by state or region

### Example: Filament dependent selects

```php
use App\Models\City;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

Select::make('state_id')
    ->label('State')
    ->options(State::orderBy('name')->pluck('name', 'id'))
    ->live()
    ->required(),

Select::make('city_id')
    ->label('City')
    ->options(fn (Get $get) => City::where('state_id', $get('state_id'))
        ->orderBy('name')
        ->pluck('name', 'id'))
    ->searchable()
    ->required(),
```

## Publishing assets individually

If you prefer to control each step instead of using the install command:

```bash
php artisan vendor:publish --tag=brazil-locations-migrations
php artisan vendor:publish --tag=brazil-locations-models
php artisan vendor:publish --tag=brazil-locations-seeders

php artisan migrate
php artisan db:seed --class=StateSeeder
php artisan db:seed --class=CitySeeder
```

## Re-seeding

The seeders use `updateOrCreate` keyed by `ibge_code`, so they are **idempotent**. Running them again will update existing records in place without creating duplicates.

## Data source

States and municipalities are based on the official [IBGE](https://www.ibge.gov.br/) registry (Instituto Brasileiro de Geografia e Estatística).

## Contributing

Contributions are welcome. Feel free to open an issue or submit a pull request at [github.com/brew-apps/brazil-locations](https://github.com/brew-apps/brazil-locations).

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

# Português

[English](#brazil-locations) | **Português**

Package Laravel que popula seu banco de dados com os 27 estados e os 5.570 municípios do Brasil, com models Eloquent `State` e `City` e seus relacionamentos prontos para uso. Um `composer require`, um comando artisan, pronto.

Todos os registros incluem o **código IBGE** oficial, permitindo integração segura com APIs governamentais, emissores de NF-e/NFS-e, transportadoras e qualquer outro serviço que dependa de identificadores do IBGE.

## Requisitos

- PHP 8.1+
- Laravel 10+

## Instalação

Instale o pacote via Composer:

```bash
composer require brew/brazil-locations
```

Execute o comando de instalação:

```bash
php artisan brazil-locations:install
```

Só isso. O comando irá:

1. Publicar as migrations em `database/migrations`
2. Executar as migrations (tabelas `states` e `cities`)
3. Publicar os models `State` e `City` em `app/Models`
4. Publicar os seeders `StateSeeder` e `CitySeeder` em `database/seeders`
5. Executar os dois seeders

Como os models e seeders são **publicados dentro da sua aplicação**, eles passam a ser seus: você pode estendê-los ou customizá-los livremente.

## Estrutura do banco

**`states`**

| Coluna      | Tipo        | Observações              |
|-------------|-------------|--------------------------|
| `id`        | bigint      | Chave primária           |
| `name`      | string      | ex.: `São Paulo`         |
| `uf`        | string(2)   | Único, ex.: `SP`         |
| `ibge_code` | string      | Único, ex.: `35`         |
| timestamps  |             |                          |

**`cities`**

| Coluna      | Tipo        | Observações                    |
|-------------|-------------|--------------------------------|
| `id`        | bigint      | Chave primária                 |
| `name`      | string      | ex.: `Campinas`                |
| `state_id`  | foreignId   | Referencia `states.id`         |
| `ibge_code` | string      | Único, ex.: `3509502`          |
| timestamps  |             |                                |

## Uso

### Listar estados

```php
use App\Models\State;

$states = State::orderBy('name')->get();
```

### Cidades de um estado

```php
$state  = State::where('uf', 'SP')->first();
$cities = $state->cities;
```

### Estado de uma cidade

```php
use App\Models\City;

$city  = City::where('ibge_code', '3509502')->first();
$state = $city->state; // São Paulo
```

### Eager loading

```php
$states = State::with('cities')->get();
```

### Casos de uso comuns

- Selects dependentes (estado → cidade) em formulários, Livewire ou resources do Filament
- Validação de endereços pelo código IBGE
- Integrações fiscais (NF-e, NFS-e) que exigem o código IBGE do município
- Relatórios e filtros agrupados por estado ou região

### Exemplo: selects dependentes no Filament

```php
use App\Models\City;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

Select::make('state_id')
    ->label('Estado')
    ->options(State::orderBy('name')->pluck('name', 'id'))
    ->live()
    ->required(),

Select::make('city_id')
    ->label('Cidade')
    ->options(fn (Get $get) => City::where('state_id', $get('state_id'))
        ->orderBy('name')
        ->pluck('name', 'id'))
    ->searchable()
    ->required(),
```

## Publicando os assets individualmente

Se preferir controlar cada etapa em vez de usar o comando de instalação:

```bash
php artisan vendor:publish --tag=brazil-locations-migrations
php artisan vendor:publish --tag=brazil-locations-models
php artisan vendor:publish --tag=brazil-locations-seeders

php artisan migrate
php artisan db:seed --class=StateSeeder
php artisan db:seed --class=CitySeeder
```

## Reexecutando os seeders

Os seeders utilizam `updateOrCreate` com base no `ibge_code`, portanto são **idempotentes**. Executá-los novamente atualiza os registros existentes sem criar duplicatas.

## Fonte dos dados

Estados e municípios são baseados no cadastro oficial do [IBGE](https://www.ibge.gov.br/) (Instituto Brasileiro de Geografia e Estatística).

## Contribuindo

Contribuições são bem-vindas. Abra uma issue ou envie um pull request em [github.com/brew-apps/brazil-locations](https://github.com/brew-apps/brazil-locations).

## Licença

Este pacote é um software open source licenciado sob a [licença MIT](LICENSE).
