<?php

declare(strict_types = 1);

namespace Graphpinator\Tests\Unit\Type;

final class InputTypeTest extends \PHPUnit\Framework\TestCase
{
    public static function createTestInput() : \Graphpinator\Type\InputType
    {
        return new class extends \Graphpinator\Type\InputType {
            protected const NAME = 'Abc';

            protected function getFieldDefinition() : \Graphpinator\Argument\ArgumentSet
            {
                return new \Graphpinator\Argument\ArgumentSet([
                    new \Graphpinator\Argument\Argument('field1', InputTypeTest::createTestSubInput(), ['subfield' => 'random']),
                    new \Graphpinator\Argument\Argument('field2', InputTypeTest::createTestSubInput(), ['subfield' => 'random']),
                ]);
            }
        };
    }

    public static function createTestSubInput() : \Graphpinator\Type\InputType
    {
        return new class extends \Graphpinator\Type\InputType {
            protected const NAME = 'Abc';

            protected function getFieldDefinition() : \Graphpinator\Argument\ArgumentSet
            {
                return new \Graphpinator\Argument\ArgumentSet([
                    new \Graphpinator\Argument\Argument(
                        'subfield',
                        \Graphpinator\Type\Container\Container::String(),
                        'random',
                    ),
                ]);
            }
        };
    }

    public function testApplyDefaults() : void
    {
        $input = self::createTestInput();
        $value = $input->createValue(['field1' => ['subfield' => 'concrete']]);

        self::assertSame(
            ['field1' => ['subfield' => 'concrete'], 'field2' => ['subfield' => 'random']],
            \json_decode(\json_encode($value->getRawValue()), true),
        );
    }

    public function testInvalidValue() : void
    {
        //phpcs:ignore SlevomatCodingStandard.Exceptions.ReferenceThrowableOnly.ReferencedGeneralException
        $this->expectException(\Exception::class);

        $input = self::createTestInput();
        $input->createValue(123);
    }

    public function testSimple() : void
    {
        $input = self::createTestInput();

        self::assertFalse($input->isResolvable());
        self::assertFalse($input->isOutputable());
        self::assertTrue($input->isInputable());
    }
}
