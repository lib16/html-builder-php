# Lib16 HTML Builder for PHP 8
A library for creating HTML5 written in PHP 8.

[![Build Status](https://travis-ci.com/lib16/rss-builder-php.svg?branch=master)](https://travis-ci.com/lib16/rss-builder-php)
[![Coverage](https://codecov.io/gh/lib16/rss-builder-php/branch/master/graph/badge.svg)](https://codecov.io/gh/lib16/rss-builder-php)

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
    ['model' => 'Panther', 'store' => 'Berlin', 'quantity' => 20],
    ['model' => 'Panther', 'store' => 'Berlin', 'quantity' => 12],
    ['model' => 'Panther', 'store' => 'Cologne', 'quantity' => 12],
    ['model' => 'Lion', 'store' => 'Cologne', 'quantity' => 12],
    ['model' => 'Lion', 'store' => 'Hamburg', 'quantity' => 15],
    ['model' => 'Lion', 'store' => 'Hamburg', 'quantity' => 15]
];
$table = Table::create('Availability')->setClass('t1');
$table->thead()->tr()->thn('model', 'store', 'quantity');
$table->bodies($data);
print $table;

$table = Table::create('Availability')->setClass('t2');
$table->thead()->tr()->thn('model', 'store', 'quantity');
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