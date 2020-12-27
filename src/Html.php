<?php
namespace Lib16\HTML;

class Html extends HtmlElement
{
    const NAME = 'html';

	public static function create(
	    string $lang = null,
	    string $manifest = null
    ): self {
	    return (new static(HtmlMarkup::createRoot(static::NAME)))
	       ->setLang($lang)
	       ->setManifest($manifest);
	}

	public function setManifest(string $manifest = null): self
	{
	    return $this->attrib('manifest', $manifest);
	}
}