<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\Base64\Tests;

use Elavora\Api\DataTypes\Base64;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * @see docs/USO.md#criação-e-entrada-inválida
 */
final class Base64Test extends TestCase
{
    public function testValidatesBase64(): void
    {
        self::assertTrue(Base64::isValid(base64_encode('api')));
        self::assertFalse(Base64::isValid('###'));
    }

    /**
     * @return array<string, array{mixed}>
     */
    public static function validProvider(): array
    {
        return [
            'sem padding necessario' => ['YXBp'],
            'com padding' => ['YQ=='],
        ];
    }

    /**
     * @return array<string, array{mixed}>
     */
    public static function invalidProvider(): array
    {
        return [
            'fora do alfabeto' => ['###'],
            'inteiro' => [123],
            'null' => [null],
        ];
    }

    #[DataProvider('validProvider')]
    public function testIsValidAcceptsValidBase64(mixed $value): void
    {
        self::assertTrue(Base64::isValid($value));
    }

    #[DataProvider('invalidProvider')]
    public function testIsValidRejectsInvalidValues(mixed $value): void
    {
        self::assertFalse(Base64::isValid($value));
    }

    #[DataProvider('validProvider')]
    public function testFromCreatesInstanceWithoutNormalization(string $value): void
    {
        $base64 = Base64::from($value);

        self::assertInstanceOf(Base64::class, $base64);
        self::assertSame($value, $base64->value());
        self::assertSame($value, (string) $base64);
        self::assertSame(json_encode($value), json_encode($base64));
    }

    #[DataProvider('invalidProvider')]
    public function testFromRejectsInvalidValuesWithMessage(mixed $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Valor invalido para Elavora\Api\DataTypes\Base64.');

        Base64::from($value);
    }

    public function testConstructorIsNotPublic(): void
    {
        $constructor = new ReflectionMethod(Base64::class, '__construct');

        self::assertFalse($constructor->isPublic());
        self::assertTrue($constructor->isProtected());
    }
}
