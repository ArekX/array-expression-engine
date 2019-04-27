<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression;

/**
 * Class Evaluator
 *
 * Class which performs evaluation of arrays against passed values.
 *
 * @package ArekX\ArrayExpression
 */
class Evaluator
{
    /**
     * @var null|ExpressionParser
     */
    protected $expressionParser = null;


    protected $valueHandler = null;

    protected function __construct($expressionParser = null)
    {
        $this->expressionParser = $expressionParser;
    }

    public static function from($expressionParser = null)
    {
        return new static($expressionParser);
    }

    public function run(array $expression, $value)
    {

    }
}