<?php
namespace Lib16\HTML;

use Lib16\HTML\Traits\TrSupport;

class Table extends HtmlElement
{
    use TrSupport;

    const NAME = 'table';

    public static function create(string $caption = null): self
    {
        $table = new static(HtmlMarkup::createSub(static::NAME, ''));
        if ($caption) {
            $table->caption($caption);
        }
        return $table;
    }

    public function thead(): Thead
    {
        return Thead::appendTo($this);
    }

    public function tbody(): Tbody
    {
        return Tbody::appendTo($this);
    }

    public function tfoot(): Tfoot
    {
        return Tfoot::appendTo($this);
    }

    public function caption(string $caption): Caption
    {
        return Caption::appendTo($this, $caption);
    }

    public function bodies(array $data, bool $multiple = true): self
    {
        if (!is_array($data[0])) {
            foreach ($data as $i => $row) {
                $data[$i] = (array) $row;
            }
        }

        self::prepareArray($data);
        $firstKey = array_key_first($data[0]);

        foreach ($data as $i => $row) {
            if ($i == 0 || ($multiple && array_key_first($row) == $firstKey)) {
                $tbody = $this->tbody();
            }
            $tr = $tbody->tr();
            foreach ($row as $cell) {
                if (is_array($cell)) {
                    $tr->td($cell['content'])->setRowspan($cell['rowspan']);
                } else {
                    $tr->td($cell);
                }
            }
        }
        return $this;
    }

    private static function prepareArray(
        array &$array,
        array $keys = null,
        int $keyIndex = 0,
        int $start = 0,
        int $stop = null
    ): void {
        if ($keys === null) {
            $keys = array_keys($array[0]);
        }
        if (count($keys) - $keyIndex > 1) {
            if ($stop === null) {
                $stop = count($array);
            }
            $key = $keys[$keyIndex++];
            $content = $array[0][$key];
            $rowspan = 1;
            $index = $start;
            for ($i = $start+1; $i < $stop; $i++) {
                if ($array[$i][$key] !== $content) {
                    $array[$index][$key] = [
                        'content' => $array[$index][$key],
                        'rowspan' => $rowspan
                    ];
                    self::prepareArray($array, $keys, $keyIndex, $index, $i);
                    $content = $array[$i][$key];
                    $rowspan = 1;
                    $index = $i;
                } else {
                    unset($array[$i][$key]);
                    $rowspan++;
                }
            }
            $array[$index][$key] = [
                'content' => $array[$index][$key],
                'rowspan' => $rowspan
            ];
            self::prepareArray($array, $keys, $keyIndex, $index, $i);
        }
    }
}