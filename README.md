# Brazil Locations Package

Package Laravel para adicionar tabelas de estados e cidades do Brasil.

## Instalação

1. Adicione ao `composer.json`:

```bash
composer require brew/brazil-locations
```
2. Execute o comando de instalação:
```bash
php artisan brazil-locations:install
```

## Modelos

A package inclui os modelos Eloquent `State` e `City` para facilitar a interação com as tabelas.

### Uso

**Listar todos os estados:**

```php
use Brew\BrazilLocations\Models\State;

$states = State::all();
```

**Obter as cidades de um estado:**

```php
$state = State::find(1);
$cities = $state->cities;
```

**Obter o estado de uma cidade:**
```php
use Brew\BrazilLocations\Models\City;

$city = City::find(1);
$state = $city->state;
```

Publicar os Modelos (Opcional)
Se desejar modificar ou estender os modelos, você pode publicá-los:

```bash
php artisan vendor:publish --tag=brazil-locations-models
```
Os modelos serão copiados para app/Models/Brew/BrazilLocations.

## Testes

Esta package utiliza o Pest PHP para testes.

### Executar os Testes

No diretório da package, execute:

```bash
composer test
```

## Licença
MIT

