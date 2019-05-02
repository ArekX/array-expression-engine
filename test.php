<?php
require __DIR__ . '/vendor/autoload.php';

$expression = ['concat', ['get', 'first'], ['value', ' '], ['get', 'last']];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$result = $evaluator->run($expression, ['first' => 'John', 'last' => 'Snow']); // returns 'John Snow'

echo $result;