<?php
namespace Lib16\HTML;

use Lib16\HTML\Enums\Scope;

class Tr extends HtmlElement
{
    const NAME = 'tr';

    public function td(
        string $content = null,
        int $colspan = null,
        int $rowspan = null,
        string ...$headers
    ): Td {
        return Td::appendTo($this, $content)
            ->setColspan($colspan)
            ->setRowspan($rowspan)
            ->setHeaders(...$headers);
    }

    public function th(
        string $content = null,
        int $colspan = null,
        int $rowspan = null,
        Scope $scope = null,
        string ...$headers
    ): Th {
        return Th::appendTo($this, $content)
            ->setColspan($colspan)
            ->setRowspan($rowspan)
            ->setScope($scope)
            ->setHeaders(...$headers);
    }

    public function tdn(?string ...$content): self
    {
        return $this->dataCells($content);
    }

    public function thn(?string ...$content): self
    {
        return $this->headerCells($content);
    }

    public function dataCells(iterable $data): self
    {
        foreach ($data as $value) {
            $this->td($value);
        }
        return $this;
    }

    public function headerCells(iterable $data): self
    {
        foreach ($data as $value) {
            $this->th($value);
        }
        return $this;
    }
}