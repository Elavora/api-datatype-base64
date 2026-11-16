<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes;

use Elavora\Api\Framework\Contracts\DescribesType;

final readonly class Base64 extends AbstractDataType implements DescribesType
{
    /**
     * Descreve o tipo para a documentacao publica (OPTIONS).
     *
     * @return array<string, mixed>
     */
    public static function documentedType(): array
    {
        return [
            'type' => 'string',
            'format' => 'base64',
            'example' => 'YXBp',
            'description' => 'Texto codificado em Base64.',
        ];
    }

    /**
     * Verifica se o valor e uma string Base64 valida.
     */
    public static function isValid(mixed $value): bool
    {
        return is_string($value) && base64_decode($value, true) !== false;
    }
}
