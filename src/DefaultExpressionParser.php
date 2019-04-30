<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression;

use ArekX\ArrayExpression\Exceptions\TypeNotMappedException;
use \ArekX\ArrayExpression\Interfaces\ExpressionParser as ExpressionParserInterface;
use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Operators\AndOperator;
use ArekX\ArrayExpression\Operators\BetweenOperator;
use ArekX\ArrayExpression\Operators\CompareOperator;
use ArekX\ArrayExpression\Operators\OrOperator;
use ArekX\ArrayExpression\Operators\RegexOperator;
use ArekX\ArrayExpression\Operators\GetOperator;
use ArekX\ArrayExpression\Operators\ValueOperator;
use ArekX\ArrayExpression\Operators\XOrOperator;

/**
 * Class DefaultExpressionParser
 * Default Expression parser which converts array expressions into Operator instances.
 *
 * @package ArekX\ArrayExpression
 */
class DefaultExpressionParser extends ExpressionParser
{
    public function __construct()
    {
        $this->setTypeMap([
            'compare' => CompareOperator::class,
            'regex' => RegexOperator::class,
            'and' => AndOperator::class,
            'or' => OrOperator::class,
            'xor' => XOrOperator::class,
            'value' => ValueOperator::class,
            'get' => GetOperator::class,
            'between' => BetweenOperator::class
        ]);
    }
}