<?php
require __DIR__ . '/vendor/autoload.php';

$isAStark = [
    'or',
    [
        'and',
        ['compare', 'first', 'in', ['Arya', 'Sansa']],
        ['compare', 'last', '=', 'Stark'],
    ],
    ['regex', 'emblem', '/stark/i']
];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$values = [
    ['first' => 'John', 'last' => 'Snow', 'emblem' => 'stark'],
    ['first' => 'Arya', 'last' => 'Stark', 'emblem' => 'stark'],
    ['first' => 'Sansa', 'last' => 'Stark', 'emblem' => 'stark'],
    ['first' => 'Joffrey', 'last' => 'Lannister', 'emblem' => 'lannister']
];

foreach ($values as $value) {
    var_dump($evaluator->run($isAStark, $value));
}