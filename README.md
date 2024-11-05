# Brazil Locations Package

Package Laravel para adicionar tabelas de estados e cidades do Brasil ao banco de dados.

**Atenção: apesar da package estar funcionando, há melhorias a se fazer, como por exemplo, verificar se o usuário já tem essas tabelas no banco antes de rodar a migration. Use com cautela**

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

## Licença
MIT

