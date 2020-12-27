<?php
namespace Lib16\HTML;

use Lib16\XML\Xml;

class HtmlMarkup extends Xml
{

    const HTML_MODE_ENABLED = true;

    const DOCTYPE = '<!DOCTYPE html>';

    const MIME_TYPE = 'text/html';

    const FILENAME_EXTENSION = 'html';

    const XML_DECLARATION_ENABLED = false;
}