# Lib16 HTML Builder for PHP 8
A library for creating HTML5 written in PHP 8.

[![Build Status](https://travis-ci.com/lib16/html-builder-php.svg?branch=main)](https://travis-ci.com/lib16/html-builder-php)
[![Coverage](https://codecov.io/gh/lib16/html-builder-php/branch/main/graph/badge.svg)](https://codecov.io/gh/lib16/html-builder-php)

## Installation with Composer
This package is available on [packagist](https://packagist.org/packages/lib16/html),
therefore you can use [Composer](https://getcomposer.org) to install it.
Run the following command in your shell:

```
composer require lib16/html dev-main
```

## Basic Usage

Build your tables with this library:

``` php
<?php
require_once 'vendor/autoload.php';

use Lib16\HTML\Table;

$data = [
    ['model' => 'Panther', 'city' => 'Berlin', 'quantity/store' => 20],
    ['model' => 'Panther', 'city' => 'Berlin', 'quantity/store' => 12],
    ['model' => 'Panther', 'city' => 'Cologne', 'quantity/store' => 12],
    ['model' => 'Lion', 'city' => 'Cologne', 'quantity/store' => 12],
    ['model' => 'Lion', 'city' => 'Hamburg', 'quantity/store' => 15],
    ['model' => 'Lion', 'city' => 'Hamburg', 'quantity/store' => 15],
    ['model' => 'Lion', 'city' => 'Munich', 'quantity/store' => 15],
];
$table = Table::create('Availability')->setClass('t1');
$table->thead()->tr()->thn('model', 'city', 'quantity/store');
$table->bodies($data);
print $table;

// change order
$keys = ['city', 'model', 'quantity/store'];
$table = Table::create('Availability')->setClass('t1');
$table->thead()->tr()->headerCells($keys);
$table->bodies($data, ...$keys);
print $table;

// row by row
$table = Table::create('Availability')->setClass('t2');
$table->thead()->tr()->thn('model', 'city', 'quantity/store');
foreach ($data as $row) {
    $table->tr()->dataCells($row);
}
print $table;

?>
<style>
body, * {
    font-family: source serif pro, serif;
}
caption, th {
    font-family: source sans pro, sans-serif;
}
caption {
    margin: 0.5em;
}
td, th {
    text-align: left;
    vertical-align: text-top;
    padding: 0.5em;
    border: 1px solid rgb(0, 51, 102);
}
td:last-child {
    text-align: right;
}
th {
    color: white;
    background-color: rgba(0, 51, 102, 1);
    font-weight: normal;
}
.t1 tbody,
.t2 tr {
    background-color: rgba(51, 102, 0, 0.2);
}
.t1 tbody:nth-child(2n),
.t2 tr:nth-child(2n) {
    background-color: rgba(52, 102, 0, 0.3);
}
table {
    border-collapse: collapse;
    margin: 2em;
    float: left;
}
</style>
```