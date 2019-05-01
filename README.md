# Array Expression Engine

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ArekX/array-expression-engine/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ArekX/array-expression-engine/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/ArekX/array-expression-engine/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ArekX/array-expression-engine/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/ArekX/array-expression-engine/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ArekX/array-expression-engine/?branch=master)

This is an array expression parser which can be used to parse values using
configuration specified in PHP arrays. These arrays can be loaded from anywhere,
like from JSON string, PHP files, etc.

These expressions are used to configure the expression parser engine which
runs a value through the rules defined in the array expression to return a result.

## Installation

Run `composer require arekx/array-expression-engine` in your project.


## Usage

```php
$isAStark = [
    'or',
    [
        'and',
        ['compare', ['get', 'first'], 'in', ['value', ['Arya', 'Sansa']]],
        ['compare', ['get', 'last'], '=', ['value', 'Stark']],
    ],
    ['regex', ['get', 'emblem'], '/stark/i']
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

#### Summary

Following operators are available:

Operator | Name | Definition
-------- | ---- | ----------
AND | AND operator  | `['and', <expression1>, ..., <expressionN>]`
OR | OR operator  | `['or', <expression1>, ..., <expressionN>]`
XOR | XOR operator (exclusive OR)  | `['xor', <expression1>, ..., <expressionN>]`
NOT | NOT operator (inverts check)  | `['not', <expression>]`
BETWEEN | BETWEEN operator, checks if the value is between minimum and maximum (inclusive) | `['between', <valueExpression>, <minExpression>, <maxExpression>]`
COMPARE | Comparison operator |`['compare', <expressionA>, <expressionB>]`, `['compare, <expressionA>, '=', <expressionB>]`
REGEX | Regex operator | `['regex', <expression>, '/pattern/']`, `['regex', <expression>, <patternExpression>]`
VALUE | Value operator, returns static values | `['value', 'this is a static value']`
GET | GET operator, returns values by name from passed value | `['get', 'keyFromValue']`

##### AND Operator

AND operator is defined in `ArekX\ArrayExpression\Operators\AndOperator` class and is used to represent 
AND operation between two or more expressions, those expressions can by any other operator including AND operator.

Example:
```php
$nameMustBeTestAndAgeAbove2 = ['and', ['compare', ['get', 'name'], ['value', 'test']], ['compare', ['get', 'age'], '>', ['value', 2]]];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$evaluator->run($nameMustBeTestAndAgeAbove2, ['name' => 'test', 'age' => 1]); // returns false
```

##### OR Operator

OR operator is defined in `ArekX\ArrayExpression\Operators\OrOperator` class and is used to represent 
OR operation between two or more expressions, those expressions can by any other operator including OR operator.

Example:
```php
$nameMustBeTestOrAgeAbove2 = ['or', ['compare', ['get', 'name'], ['value', 'test']], ['compare', ['get', 'age'], '>', ['value', 2]]];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$evaluator->run($nameMustBeTestOrAgeAbove2, ['name' => 'test', 'age' => 1]); // returns true
```

##### XOR Operator

XOR operator is defined in `ArekX\ArrayExpression\Operators\XOrOperator` class and is used to represent 
XOR operation between two or more expressions, those expressions can by any other operator including XOR operator.

Example:
```php
$nameMustBeTestXOrAgeAbove2 = ['xor', ['compare', ['get', 'name'], ['value', 'test']], ['compare', ['get', 'age'], '>', ['value', 2]]];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$evaluator->run($nameMustBeTestXOrAgeAbove2, ['name' => 'test', 'age' => 2]); // returns false
```


##### NOT Operator

Not operator is defined in `ArekX\ArrayExpression\Operators\NotOperator` class and is used to represent 
NOT operation or the inversion of the expression passed to it.

Example:
```php
$expression = ['not', ['or', ['compare', ['get', 'name'], ['value', 'test']], ['compare', ['get', 'age'], '>', ['value', 2]]]];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$evaluator->run($expression, ['name' => 'test', 'age' => 5]); // returns false
```

##### BETWEEN Operator

Between operator is defined in `ArekX\ArrayExpression\Operators\BetweenOperator` class and is used to check if a value is between minimum and maximum value.


Example:
```php
$expression = ['between', ['get', 'age'], ['value', 1], ['value', 20]]; // Check if age is >= 1 and <= 20

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$evaluator->run($expression, ['age' => 5]); // returns true
```

##### COMPARE Operator

Comparison operator for comparing two expressions. It is defined in `ArekX\ArrayExpression\Operators\CompareOperator`.

Comparison operator accepts multiple formats:

**Short format** 

`['compare', <expressionA>, <expressionB>]`

Checks if `<expressionA>` equals (strict) to `<expressionB>`


**Relation format** 

`['compare', <expressionA>, '>=', <expressionB>]`

Checks if `<expressionB>` is greater or equal to `<expressionB>` and returns `true`/`false`

Supported relation operators: 

* `>` - Greater than
* `>=` - Greater than or equal
* `<` - Less than
* `<=` - Less than or equal
* `<>` - Not equal
* `in` - Is one of the values. Example `['compare', <expressionA>, ['value', [1,2,10]]]` checks if `<expressionA>` is `1`, `2` or `10`.


Example:
```php
$expression = ['compare', ['get', 'name'], ['value', 'test']];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$evaluator->run($expression, ['name' => 'test', 'age' => 5]); // returns true
```

##### REGEX Operator

REGEX operator is defined in `ArekX\ArrayExpression\Operators\RegexOperator` class and is used to check if a value matches a specific regex pattern.

Regex operator accepts multiple formats:

**String format**

`['regex', <expression>, '/pattern/']`

Checks if `<expression>` matches specific pattern. Return value from `<expression>` must be a string.
 
 
**Expression format**

`['regex', <expression>, <expressionFormat>]`

Checks if `<expression>` matches specific pattern defined by `<expressionFormat>`. 

Return value from `<expression>` must be a string.

Return value from `<expressionFormat>` must be a string.
 
Example:
```php
$expression = ['regex', ['get', 'name'], '/o/i'];

$evaluator = \ArekX\ArrayExpression\Evaluator::create();

$evaluator->run($expression, ['name' => 'John']); // returns true
```

##### Value Operator

Value operator is defined in `ArekX\ArrayExpression\Operators\ValueOperator` class and is used to return a static value.
 
Example:
 ```php
$expression = ['value', 50];
 
$evaluator = \ArekX\ArrayExpression\Evaluator::create();
 
$evaluator->run($expression, ['name' => 'John']); // returns 50
 ```
 
##### Get Operator

Get operator is defined in `ArekX\ArrayExpression\Operators\GetOperator` class and is used to return a value from a key.
 
Example:
 ```php
$expression = ['get', 'name'];
 
$evaluator = \ArekX\ArrayExpression\Evaluator::create();
 
$evaluator->run($expression, ['name' => 'John']); // returns 'John'
```

#### Custom operators

You can create your own custom operator manually by implementing `Operator` interface and adding that operator
to `ExpressionParser` of your `Evaluator`.

We will implement a custom operator which transforms all instances of a word `cat` into `dog`.

Operator definition we want to implement is: `['dog', <expression>]`

First we implement an `Operator` class

```php
use ArekX\ArrayExpression\Interfaces\ExpressionParser;
use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\ValueParser;

class DogOperator implements Operator
{
    /** @var ExpressionParser */
    public $parser;

    /** @var string */
    public $name;

    /** @var Operator */
    public $subExpression;

    public function configure(array $config)
    {
        $this->name = $config[0];
        $this->assertIsExpression($config[1]); // Assert that the value is an expression.
        $this->subExpression = $this->parser->parse($config[1]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setParser(ExpressionParser $parser)
    {
        $this->parser = $parser;
    }

    public function evaluate(ValueParser $value)
    {
        return str_ireplace('cat', 'dog', $this->subExpression->evaluate($value));
    }
}
```

After creating this class we need to add it to the evaluator's expression parser and we are set:

```php
$evaluator = \ArekX\ArrayExpression\Evaluator::create();
$evaluator->getExpressionParser()->setType('dog', DogOperator::class);

$test = ['dog', ['get', 'sentence']];

$result = $evaluator->run($test, ['sentence' => 'Hello this is cat.']); // Returns: Hello this is dog.
```
 
## Tests

Run `composer test` to run tests.