<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\Base64\Tests;

use Elavora\Api\DataTypes\Base64;
use Elavora\Api\Framework\Contracts\DescribesType;
use PHPUnit\Framework\TestCase;

/**
 * @see docs/USO.md#documentação-do-tipo-options
 */
final class DocumentedTypeTest extends TestCase
{
    private const ALLOWED_KEYS = ['type', 'format', 'mask', 'pattern', 'enum', 'example', 'description'];

    public function testImplementsDescribesType(): void
    {
        self::assertInstanceOf(DescribesType::class, new Base64('YXBp'));
    }

    public function testDocumentedTypeUsesOnlyAllowedKeys(): void
    {
        $documented = Base64::documentedType();

        self::assertArrayHasKey('type', $documented);
        self::assertSame([], array_diff(array_keys($documented), self::ALLOWED_KEYS));
        self::assertSame('string', $documented['type']);
        self::assertSame('base64', $documented['format']);
    }

    public function testExampleIsValid(): void
    {
        $documented = Base64::documentedType();

        self::assertArrayHasKey('example', $documented);
        self::assertTrue(Base64::isValid($documented['example']));
    }

    public function testPatternMatchesExampleWhenDeclared(): void
    {
        $documented = Base64::documentedType();
        if (!isset($documented['pattern'])) {
            self::assertArrayNotHasKey('pattern', $documented);

            return;
        }

        self::assertSame(1, preg_match('~' . $documented['pattern'] . '~', (string) ($documented['example'] ?? '')));
    }
}
