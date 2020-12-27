<?php
namespace Lib16\HTML\Tests;

use Lib16\HTML\Table;
use PHPUnit\Framework\TestCase;

class HtmlElementTest extends TestCase
{
    /**
     * @dataProvider setClassProvider
     */
    public function testSetClass(string $expected, ...$classes)
    {
        $this->assertEquals(
            $expected,
            Table::create()->setClass(...$classes)->getMarkup()
        );
    }

    public function setClassProvider(): array
    {
        return [
            ['<table></table>'],
            ['<table></table>', ''],
            ['<table class="foo"></table>', 'foo'],
            ['<table class="foo bar"></table>', 'foo', 'bar'],
        ];
    }

    /**
     * @dataProvider setDataProvider
     */
    public function testSetData(
        string $expected,
        string $name,
        string $value = null
    ) {
        $this->assertEquals(
            $expected,
            Table::create()->setData($name, $value)->getMarkup()
        );
    }

    public function setDataProvider(): array
    {
        return [
            ['<table></table>', 'foo', null],
            ['<table data-foo="foo bar"></table>', 'foo', 'foo bar'],
        ];
    }

    /**
     * @dataProvider setContenteditableProvider
     */
    public function testSetContenteditable(
        string $expected,
        bool $contenteditable = null
    ) {
        $this->assertEquals(
            $expected,
            Table::create()->setContenteditable($contenteditable)->getMarkup()
        );
    }

    public function setContenteditableProvider(): array
    {
        return [
            ['<table></table>', null],
            ['<table contenteditable="false"></table>', false],
            ['<table contenteditable="true"></table>', true]
        ];
    }

    /**
     * @dataProvider setIdProvider
     */
    public function testSetId(string $expected, string $id = null)
    {
        $this->assertEquals(
            $expected,
            Table::create()->setId($id)->getMarkup()
        );
    }

    public function setIdProvider(): array
    {
        return [
            ['<table></table>'],
            ['<table id=""></table>', ''],
            ['<table id="foo"></table>', 'foo']
        ];
    }

}
