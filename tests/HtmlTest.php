<?php
namespace Lib16\HTML\Tests;

use Lib16\HTML\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    /**
     * @dataProvider htmlProvider
     */
    public function testHtml(
        string $expected,
        string $lang = null,
        string $manifest = null
    ) {
        $this->assertEquals(
            $expected,
            Html::create($lang, $manifest)->__toString()
        );
    }

    public function htmlProvider(): array
    {
        return [
            ["<!DOCTYPE html>\n<html>"],
            [
                "<!DOCTYPE html>\n<html lang=\"de\">",
                'de'
            ],
            [
                "<!DOCTYPE html>\n<html manifest=\"cache-manifest.appcache\">",
                null,
                'cache-manifest.appcache'
            ]
        ];
    }
}