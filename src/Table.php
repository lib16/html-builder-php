<?php
namespace Lib16\HTML;

use Lib16\HTML\Traits\TrSupport;

class Table extends HtmlElement
{
    use TrSupport;

    const NAME = 'table';

    public static function create(string $caption = null): self
    {
        $table = new static(HtmlMarkup::create(static::NAME, ''));
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

    public function bodies(array $data, string ...$keys) {
        return $this->appendTbodyElements($data, false, ...$keys);
    }

    public function body(array $data, string ...$keys) {
        return $this->appendTbodyElements($data, true, ...$keys);
    }

    private function appendTbodyElements(
        array $data,
        bool $single = false,
        string ...$keys
    ): self {
        // cast objects to arrays
        if (!is_array($data[0])) {
            foreach ($data as $i => $row) {
                $data[$i] = (array) $row;
            }
        }

        // change order and filter by keys
        if ($keys) {
            $new = [];
            foreach ($data as $i => $row) {
                foreach ($keys as $key) {
                    if (isset($data[$i][$key])) {
                        $new[$i][$key] = $data[$i][$key];
                    }
                }
            }
            $data = $new;
        }

        // create arrays for comparisons
        $arrays = [];
        foreach ($data as $i => $row) {
            $row = array_reverse($row);
            $followingKey = null;
            foreach ($row as $key => $val) {
                if ($followingKey) {
                    $arrays[$i][$key] = $arrays[$i][$followingKey];
                    array_pop($arrays[$i][$key]);
                } else {
                    $arrays[$i][$key] = $data[$i];
                }
                $followingKey = $key;
            }
        }

        // set cells to null or add rowspan
        $keys = array_keys($data[0]);
        array_pop($keys);
        $count = count($data);
        foreach ($keys as $key) {
            for ($i = 0; $i < $count; $i++) {
                if ($i == 0 || $arrays[$i][$key] != $arrays[$i-1][$key]) {
                    $index = $i;
                    $data[$i][$key] = [
                        'content' => $data[$i][$key],
                        'rowspan' => 1
                    ];
                } else {
                    $data[$index][$key]['rowspan']++;
                    $data[$i][$key] = null;
                }
            }
        }

        // build the markup
        foreach ($data as $i => $row) {
            if ($single ? $i == 0 : is_array($row[$keys[0]])) {
                $tbody = $this->tbody();
            }
            $tr = $tbody->tr();
            foreach ($row as $key => $val) {
                if (is_array($val)) {
                    $tr->td($val['content'], rowspan: $val['rowspan']);
                } elseif ($val !== null) {
                    $tr->td($val);
                }
            }
        }
        return $this;
    }
}