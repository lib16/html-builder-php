<?php
namespace Lib16\HTML\Traits;

use Lib16\HTML\Tr;

trait TrSupport
{
    public function tr(): Tr
    {
        return Tr::appendTo($this);
    }
}