# Array Expression Engine

This is an array expression parser which can be used to parse values using
configuration specified in PHP arrays. These arrays can be loaded from anywhere,
like from JSON string, PHP files, etc.

These expressions are used to configure the expression parser engine which
runs a value through the rules defined in the array expression to return a result.

## Usage

```php
$isAStark = [
    'or',
    [
        'and',
        ['compare', 'first', 'in', ['Arya', 'Sansa']],
        ['compare', 'last', '=', 'Stark'],
    ]
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

// Output: bool(true), bool(true), bool(true), bool(false)
```

### Operators

Operator | Name | Definition | Example
-------- | ---- | ---------- | -------
AND | AND operator  | `['and', <expression1>, ..., <expressionN>]` | `['and', ['compare', 'name', 'test'], ['compare', 'age', '>', 2]]`  
OR | OR operator  | `['or', <expression1>, ..., <expressionN>]` | `['or', ['compare', 'name', 'test'], ['compare', 'age', '>', 2]]`
XOR | XOR operator (exclusive OR)  | `['xor', <expression1>, ..., <expressionN>]` | `['xor', ['compare', 'name', 'test'], ['compare', 'age', '>', 2]]`
COMPARE | Comparison operator | `['compare', 'value']`,<br> `['compare', 'name', 'value']`,<br> `['compare, 'name', '=', 'value']`,<br>`['compare, 'name', '>=', 0, 'default' => 0]` | `['compare', 'age', '>', 2]`
REGEX | Regex operator | `['regex', '/pattern/']`, `['regex', 'name', '/pattern/']` | `['regex', 'name', '/snow/']`


## Tests

Run `composer test` to run tests.

## Test Coverage

Ideally, goal test coverage is 100%, to check the test coverage run `composer coverage`

Current coverage: 100%