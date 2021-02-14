<?php

declare(strict_types = 1);

namespace Graphpinator\Typesystem;

interface ComponentVisitor extends \Graphpinator\Typesystem\EntityVisitor
{
    public function visitField(\Graphpinator\Field\Field $field) : mixed;

    public function visitArgument(\Graphpinator\Argument\Argument $argument) : mixed;

    public function visitDirectiveUsage(\Graphpinator\Directive\DirectiveUsage $directiveUsage) : mixed;

    public function visitEnumItem(\Graphpinator\Type\Enum\EnumItem $enumItem) : mixed;
}