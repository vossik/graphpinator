<?php

declare(strict_types=1);

namespace Tests\Value;

final class InputTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testApplyDefaults() : void
    {
        $input = self::createTestInput();
        $value = $input->createValue(['field1' => ['subfield' => 'concrete']]);

        self::assertSame(['field1' => ['subfield' => 'concrete'], 'field2' => ['subfield' => 'random']], $value->getRawValue());
    }

    public function testInvalidValue() : void
    {
        $this->expectException(\Exception::class);

        $input = self::createTestInput();
        $input->createValue(123);
    }

    public static function createTestInput() : \PGQL\Type\InputType
    {
        return new class extends \PGQL\Type\InputType {
            protected const NAME = 'Abc';

            public function __construct()
            {
                parent::__construct(
                    new \PGQL\Argument\ArgumentSet([
                        new \PGQL\Argument\Argument('field1', InputTypeTest::createTestSubInput(), ['subfield' => 'random']),
                        new \PGQL\Argument\Argument('field2', InputTypeTest::createTestSubInput(), ['subfield' => 'random']),
                    ]),
                );
            }
        };
    }

    public static function createTestSubInput() : \PGQL\Type\InputType
    {
        return new class extends \PGQL\Type\InputType {
            protected const NAME = 'Abc';

            public function __construct()
            {
                parent::__construct(
                    new \PGQL\Argument\ArgumentSet([new \PGQL\Argument\Argument(
                        'subfield', \PGQL\Type\Scalar\ScalarType::String(), 'random',
                    )]),
                );
            }
        };
    }
}
