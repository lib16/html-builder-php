<?php
namespace Lib16\HTML\Tests;

use Lib16\HTML\Table;
use Lib16\HTML\Enums\Scope;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    /**
     * @dataProvider createProvider
     */
    public function testCreate(string $expected, string $caption = null): void
    {
        $this->assertEquals($expected, Table::create($caption)->getMarkup());
    }

    public function createProvider(): array
    {
        return [
            ["<table></table>"],
            ["<table>\n\t<caption>Caption</caption>\n</table>", 'Caption']
        ];
    }

    public function testTHead(): void
    {
        $this->assertEquals(
            "<thead>\n\t<tr></tr>\n</thead>",
            Table::create()->thead()->tr()->getXml()->getParent()->getMarkup()
        );
    }

    public function testTBody(): void
    {
        $this->assertEquals(
            "<tbody>\n\t<tr></tr>\n</tbody>",
            Table::create()->tbody()->tr()->getXml()->getParent()->getMarkup()
        );
    }

    public function testTFoot(): void
    {
        $this->assertEquals(
            "<tfoot>\n\t<tr></tr>\n</tfoot>",
            Table::create()->tfoot()->tr()->getXml()->getParent()->getMarkup()
        );
    }

    /**
     * @dataProvider tdProvider
     */
    public function testTd(
        string $expected,
        int $colspan = null,
        int $rowspan = null,
        string ...$headers
    ): void {
        $this->assertEquals(
            $expected,
            Table::create()
                ->tr()
                ->td('', $colspan, $rowspan, ...$headers)
                ->getMarkup()
        );
    }

    public function tdProvider(): array
    {
        return [
            ['<td></td>'],
            ['<td rowspan="2"></td>', 1, 2],
            ['<td colspan="2"></td>', 2, 1],
            ['<td headers="foo bar"></td>', null, null, 'foo', 'bar'],
        ];
    }

    /**
     * @dataProvider thProvider
     */
    public function testTh(
        string $expected,
        int $colspan = null,
        int $rowspan = null,
        Scope $scope = null,
        string ...$headers
    ): void {
        $this->assertEquals(
            $expected,
            Table::create()
                ->tr()
                ->th('', $colspan, $rowspan, $scope, ...$headers)
                ->getMarkup()
        );
    }

    public function thProvider(): array
    {
        return [
            ['<th></th>'],
            ['<th rowspan="2"></th>', 1, 2],
            ['<th colspan="2"></th>', 2, 1],
            ['<th headers="foo bar"></th>', null, null, null, 'foo', 'bar'],
            ['<th scope="auto"></th>', null, null, Scope::AUTO()],
            ['<th scope="col"></th>', null, null, Scope::COL()],
            ['<th scope="row"></th>', null, null, Scope::ROW()],
            ['<th scope="colgroup"></th>', null, null, Scope::COLGROUP()],
            ['<th scope="rowgroup"></th>', null, null, Scope::ROWGROUP()]
        ];
    }

    public function testScope(): void
    {
        foreach ([
            "auto" => Scope::AUTO(),
            "col" => Scope::COL(),
            "row" => Scope::ROW(),
            "colgroup" => Scope::COLGROUP(),
            "rowgroup" => Scope::ROWGROUP()
        ] as $value => $enum) {
            $this->assertEquals($value, $enum->__toString());
        }
    }

    /**
     * @dataProvider tdnProvider
     */
    public function testTdn(string $expected, ...$content): void
    {
        $this->assertEquals(
            $expected,
            Table::create()->tr()->tdn(...$content)->getMarkup()
        );
    }

    public function tdnProvider(): array
    {
        return [
            ["<tr>\n\t<td>Foo</td>\n\t<td>Bar</td>\n</tr>", 'Foo', 'Bar'],
            ["<tr>\n\t<td></td>\n\t<td>Baz</td>\n</tr>", null, 'Baz'],
            ["<tr>\n\t<td>1</td>\n\t<td>1.5</td>\n</tr>", 1, 1.5],
            ["<tr></tr>"],
        ];
    }

    /**
     * @dataProvider tdnProvider
     */
    public function testThn(string $expected, ...$content): void
    {
        $this->assertEquals(
            str_replace('td>', 'th>', $expected),
            Table::create()->tr()->thn(...$content)->getMarkup()
        );
    }

    /**
     * @dataProvider cellsProvider
     */
    public function testCells(string $expected, iterable $data): void
    {
        $this->assertEquals(
            $expected,
            Table::create()->tr()->dataCells($data)->getMarkup()
        );
        $this->assertEquals(
            str_replace('td>', 'th>', $expected),
            Table::create()->tr()->headerCells($data)->getMarkup()
        );
    }

    public function cellsProvider(): array
    {
        return [
            [
                "<tr>\n\t<td>Foo</td>\n\t<td>Bar</td>\n</tr>",
                ['foo' => 'Foo', 'bar' => 'Bar']
            ],
            [
                "<tr>\n\t<td></td>\n\t<td>Baz</td>\n</tr>",
                ['foo' => null, 'bar' => 'Baz']

            ],
            [
                "<tr>\n\t<td>1</td>\n\t<td>1.5</td>\n</tr>",
                ['foo' => 1, 'bar' => 1.5]
            ],
            [
                "<tr>\n\t<td>Foo</td>\n\t<td>Bar</td>\n</tr>",
                ['Foo', 'Bar']
            ],
            ["<tr></tr>", []],
        ];
    }

    /**
     * @dataProvider bodiesProvider
     */
    public function testBodies(
        string $expected,
        bool $single,
        string ...$keys
    ): void {
        $data = [
            ['name' => 'Foo', 'town' => 'Berlin', 'amount' => 20],
            ['name' => 'Foo', 'town' => 'Berlin', 'amount' => 12],
            ['name' => 'Foo', 'town' => 'Cologne', 'amount' => 12],
            ['name' => 'Bar', 'town' => 'Cologne', 'amount' => 12],
            ['name' => 'Bar', 'town' => 'Hamburg', 'amount' => 15],
            ['name' => 'Bar', 'town' => 'Hamburg', 'amount' => 15],
            ['name' => 'Baz', 'town' => 'Munich', 'amount' => 17]
        ];
        $expected = str_replace('    ', "\t", $expected);
        $actual = $single
            ? Table::create()->body($data, ...$keys)->getMarkup()
            : Table::create()->bodies($data, ...$keys)->getMarkup();;
        $this->assertEquals($expected, $actual);

        foreach ($data as $i => $row) {
            $obj = new \stdClass();
            $obj->name = $row['name'];
            $obj->town = $row['town'];
            $obj->amount = $row['amount'];
            $data[$i] = $obj;
        }
        $actual = $single
            ? Table::create()->body($data, ...$keys)->getMarkup()
            : Table::create()->bodies($data, ...$keys)->getMarkup();;
        $this->assertEquals($expected, $actual);
    }

    public function bodiesProvider(): array
    {
        return [
            ['<table>
    <tbody>
        <tr>
            <td rowspan="3">Foo</td>
            <td rowspan="2">Berlin</td>
            <td>20</td>
        </tr>
        <tr>
            <td>12</td>
        </tr>
        <tr>
            <td>Cologne</td>
            <td>12</td>
        </tr>
        <tr>
            <td rowspan="3">Bar</td>
            <td>Cologne</td>
            <td>12</td>
        </tr>
        <tr>
            <td rowspan="2">Hamburg</td>
            <td>15</td>
        </tr>
        <tr>
            <td>15</td>
        </tr>
        <tr>
            <td>Baz</td>
            <td>Munich</td>
            <td>17</td>
        </tr>
    </tbody>
</table>', true],
            ['<table>
    <tbody>
        <tr>
            <td rowspan="3">Foo</td>
            <td rowspan="2">Berlin</td>
            <td>20</td>
        </tr>
        <tr>
            <td>12</td>
        </tr>
        <tr>
            <td>Cologne</td>
            <td>12</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="3">Bar</td>
            <td>Cologne</td>
            <td>12</td>
        </tr>
        <tr>
            <td rowspan="2">Hamburg</td>
            <td>15</td>
        </tr>
        <tr>
            <td>15</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Baz</td>
            <td>Munich</td>
            <td>17</td>
        </tr>
    </tbody>
</table>', false],
            ['<table>
    <tbody>
        <tr>
            <td rowspan="2">Berlin</td>
            <td rowspan="2">Foo</td>
            <td>20</td>
        </tr>
        <tr>
            <td>12</td>
        </tr>
        <tr>
            <td rowspan="2">Cologne</td>
            <td>Foo</td>
            <td>12</td>
        </tr>
        <tr>
            <td>Bar</td>
            <td>12</td>
        </tr>
        <tr>
            <td rowspan="2">Hamburg</td>
            <td rowspan="2">Bar</td>
            <td>15</td>
        </tr>
        <tr>
            <td>15</td>
        </tr>
        <tr>
            <td>Munich</td>
            <td>Baz</td>
            <td>17</td>
        </tr>
    </tbody>
</table>', true, 'town', 'name', 'amount'],
            ['<table>
    <tbody>
        <tr>
            <td rowspan="2">Berlin</td>
            <td>Foo</td>
        </tr>
        <tr>
            <td>Foo</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="2">Cologne</td>
            <td>Foo</td>
        </tr>
        <tr>
            <td>Bar</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="2">Hamburg</td>
            <td>Bar</td>
        </tr>
        <tr>
            <td>Bar</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Munich</td>
            <td>Baz</td>
        </tr>
    </tbody>
</table>', false, 'town', 'name']
        ];
    }
}