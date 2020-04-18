<?php

declare(strict_types = 1);

namespace Graphpinator\Exception\Parser;

final class ExpectedAfterOperationName extends ParserError
{
    public const MESSAGE = 'Expected variable definition or selection set.';
}
