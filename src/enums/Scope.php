<?php
namespace Lib16\HTML\Enums;

use Lib16\Utils\Enums\Enum;

final class Scope extends Enum
{
    public static function ROW(): self
    {
        return new self('row');
    }

    public static function COL(): self
    {
        return new self('col');
    }

    public static function ROWGROUP(): self
    {
        return new self('rowgroup');
    }

    public static function COLGROUP(): self
    {
        return new self('colgroup');
    }

    public static function AUTO(): self
    {
        return new self('auto');
    }
}