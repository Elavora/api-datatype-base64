# Guia de uso

DataType Base64 para aplicações Elavora API: valida uma string Base64 (decodificação estrita do PHP).

## Instalação

```bash
composer require elavora/api-datatype-base64
```

## Quando usar

- Validar e normalizar valores antes de chegar na regra de negócio.
- Evitar passar strings soltas entre services, DTOs e persistência.
- Reutilizar a mesma validação em controllers, comandos e testes.

## Exemplo rápido

```php
use Elavora\Api\DataTypes\Base64;

Base64::isValid('YXBp'); // true

$valor = Base64::from('YXBp');

$valor->value();            // 'YXBp'
(string) $valor;            // 'YXBp'
json_encode($valor);        // '"YXBp"'
```

O construtor não é público: crie sempre por `Base64::from()`.

## Versão e compatibilidade

| Item | Valor |
|---|---|
| Última versão antes do upgrade | `0.2.0` (tag legada `v0.2.0`) |
| Versão do upgrade | `1.0.0` |
| PHP | `>=8.3` |
| `elavora/api-datatype-core` | `^2.0` |

As versões seguintes saem do fluxo central de release: veja [Versões e release](AUTOMACAO.md#versões-e-release).
A versão `1.0.0` atualiza o pacote para o `elavora/api-datatype-core` `^2.0` (que traz o framework 2) e exige PHP 8.3
ou superior.

**Quebra de compatibilidade:** no `elavora/api-datatype-core` 2 o construtor de `AbstractDataType` é
`final protected`, então `new Base64('YXBp')` deixa de funcionar fora da própria classe. Troque por
`Base64::from('YXBp')`. `Base64::isValid()` e `value()` continuam iguais.

### `composer.json`

O `composer.json` do pacote deve ter:

- `require.php` = `">=8.3"` e `require.elavora/api-datatype-core` = `"^2.0"`
- `extra.branch-alias.dev-main` = `"1.0-dev"`
- `autoload.psr-4` = `"Elavora\Api\DataTypes\\": "src/"` (sem mudança)
- `require-dev.phpunit/phpunit` = `"^10.5 || ^11.0 || ^12.0"` (sem mudança)
- `scripts.test` = `"phpunit -c phpunit.xml"` (sem mudança)
- `require-dev`, `scripts` e `config` de qualidade (`elavora/code-standards`, PHPStan, `lint`, `analyse`, `check`):
  veja [`composer.json` em Automação](AUTOMACAO.md#composerjson)
- nenhum `repositories` (nem `path`, nem `vcs`)
- `composer validate --strict --no-check-publish` sem erros.

## Criação e entrada inválida

`Elavora\Api\DataTypes\Base64::from(mixed $value): static` valida o valor com `isValid()` e devolve um `Base64` com o
mesmo valor (não há normalização: `value()` devolve a string recebida). Se o valor for inválido, lança
`\InvalidArgumentException` com a mensagem `Valor invalido para Elavora\Api\DataTypes\Base64.`

`Base64::isValid(mixed $value): bool` devolve `true` só para string que `base64_decode($value, true)` aceita (modo
estrito); qualquer outro tipo devolve `false`.

| Entrada | `isValid()` |
|---|---|
| `'YXBp'` | `true` |
| `'YQ=='` | `true` |
| `'###'` | `false` |
| `123` (inteiro) | `false` |
| `null` | `false` |

```php
use Elavora\Api\DataTypes\Base64;

try {
    Base64::from('###'); // caracteres fora do alfabeto Base64
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage(); // Valor invalido para Elavora\Api\DataTypes\Base64.
}
```

Métodos da instância: `value(): string|int|bool|float|null` (aqui sempre `string`), `jsonSerialize()` (mesmo valor) e
`__toString()`.

## Dependências de runtime

- `elavora/api-datatype-core` `^2.0`

## Validação local

Como rodar os testes, o lint e o PHPStan, e como reproduzir o CI, está em
[Desenvolvimento e testes](DESENVOLVIMENTO.md). O `require-dev`, os `scripts` e o `config` de qualidade
(`elavora/code-standards`, PHPStan, `lint`, `analyse`, `check`) estão descritos em
[`composer.json` em Automação](AUTOMACAO.md#composerjson).

## Observações

- Mantenha regras de produto fora deste pacote.
- Prefira configurar extensões no bootstrap da aplicação.
- Instale apenas os módulos que a aplicação realmente usa.
