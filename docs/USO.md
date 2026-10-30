# Guia de uso

DataType Base64 para aplicacoes Elavora API.

## Instalacao

```bash
composer require elavora/api-datatype-base64
```

## Quando usar

- Validar e normalizar valores antes de chegar na regra de negocio.
- Evitar passar strings soltas entre services, DTOs e persistencia.
- Reutilizar a mesma validacao em controllers, comandos e testes.

## Exemplo rapido

```php
use Elavora\Api\DataTypes\Base64;

$valor = new Base64('exemplo');
$normalizado = $valor->value();
```

## Principais pontos de entrada

- `Elavora\Api\DataTypes\Base64`

## Dependencias de runtime

- `elavora/api-datatype-core` `^0.1`

## Validacao local

Como rodar os testes, o lint e o PHPStan, e como reproduzir o CI, esta em
[Desenvolvimento e testes](DESENVOLVIMENTO.md). O `require-dev`, os `scripts` e o `config` de qualidade
(`elavora/code-standards`, PHPStan, `lint`, `analyse`, `check`) estao descritos em
[`composer.json` em Automacao](AUTOMACAO.md#composerjson). As restricoes de runtime (PHP `>=8.1` e
`elavora/api-datatype-core` `^0.1`) nao mudam com a adocao do pipeline.

## Observacoes

- Mantenha regras de produto fora deste pacote.
- Prefira configurar extensoes no bootstrap da aplicacao.
- Instale apenas os modulos que a aplicacao realmente usa.