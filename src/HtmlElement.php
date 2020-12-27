<?php
namespace Lib16\HTML;

use Lib16\XML\XmlElementWrapper;

class HtmlElement extends XmlElementWrapper
{
    const NAME = null;

    const END_TAG_OMISSION = false;

    public function setClass(string ...$classes): self
    {
        $classes = array_filter($classes);
        $classes = $classes ? implode(' ', $classes) : null;
        return $this->attrib('class', $classes);
    }

    public function setContenteditable(bool $contenteditable = null): self
    {
        if (is_bool($contenteditable)) {
            $contenteditable = $contenteditable ? 'true' : 'false';
        }
        return $this->attrib('contenteditable', $contenteditable);
    }

    public function setData(string $name, string $value = null): self
    {
        return $this->attrib('data-' . $name, $value);
    }

    public function setId(string $id = null): self
    {
        return $this->attrib('id', $id);
    }

    public function setLang(string $lang = null): self
    {
        return $this->attrib('lang', $lang);
    }
}
