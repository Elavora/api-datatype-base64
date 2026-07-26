# Guia de uso

`Base64` valida strings aceitas pelo decodificador estrito de Base64 do PHP.

```php
use Elavora\Api\DataTypes\Base64;

$base64 = Base64::from(base64_encode('api'));

echo $base64->value(); // YXBp
```

O valor armazenado nao e recodificado nem alterado. Para transformar dados brutos em Base64, use `base64_encode()` antes de criar o DataType.

Para verificar uma entrada sem criar uma instancia:

```php
if (Base64::isValid($entrada)) {
    $base64 = Base64::from($entrada);
}
```

## Validacao do pacote

Execute os comandos a partir da raiz do clone:

```bash
docker run --rm -v "${PWD}:/workspace" -w /workspace composer:2 composer update --no-interaction --no-progress --prefer-dist
docker run --rm -v "${PWD}:/workspace" -w /workspace composer:2 composer check
```
