<?php

declare(strict_types=1);

namespace Infinityloop\Tests\Graphpinator\Unit\Value;

final class ScalarValueTest extends \PHPUnit\Framework\TestCase
{
    public function simpleDataProvider() : array
    {
        return [
            [123],
            [123.123],
            ['123'],
            [true],
            [[]],
            [[123, true]],
            [new \Infinityloop\Graphpinator\Value\ScalarValue('inner', \Infinityloop\Graphpinator\Type\Scalar\ScalarType::String())],
            [[new \Infinityloop\Graphpinator\Value\ScalarValue('inner', \Infinityloop\Graphpinator\Type\Scalar\ScalarType::String())]],
        ];
    }

    /**
     * @dataProvider simpleDataProvider
     */
    public function testSimple($rawValue): void
    {
        $type = $this->createMock(\Infinityloop\Graphpinator\Type\Scalar\ScalarType::class);
        $type->expects($this->once())->method('validateValue')->with($rawValue);

        $value = new \Infinityloop\Graphpinator\Value\ScalarValue($rawValue, $type);

        self::assertSame($rawValue, $value->getRawValue());
        self::assertSame($rawValue, $value->jsonSerialize());
    }
}
