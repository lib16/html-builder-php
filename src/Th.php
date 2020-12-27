<?php
namespace Lib16\HTML;

use Lib16\HTML\Enums\Scope;

class Th extends TCell
{
    const NAME = 'th';

    public function setScope(?Scope $scope): self
    {
        return $this->attrib('scope', $scope ? $scope->__toString() : null);
    }
}