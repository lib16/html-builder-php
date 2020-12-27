<?php
namespace Lib16\HTML;

class TCell extends HtmlElement
{
    //use FlowContentExpected;

    public function setColspan(?int $colspan): self
    {
        return $this->attrib('colspan', (int) $colspan > 1 ? $colspan : null);
    }

    public function setRowspan(?int $rowspan): self
    {
        return $this->attrib('rowspan', (int) $rowspan > 1 ? $rowspan : null);
    }

    public function setHeaders(string ...$headers): self
    {
        $headers = $headers ? implode(' ', $headers) : null;
        return $this->attrib('headers', $headers);
    }
}