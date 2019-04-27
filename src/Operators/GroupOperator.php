<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;


use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\ExpressionParser;
use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class GroupOperator
 * Operator for grouping actions.
 *
 * @package ArekX\ArrayExpression\Operators
 */
class GroupOperator implements Operator
{
    /**
     * Expression configuration
     *
     * @var array
     */
    protected $config = [];

    /**
     * Parser used for expression parsing.
     *
     * @var null|ExpressionParser
     */
    protected $parser = null;

    /**
     * Passes data from operator configuration.
     *
     * Depending on the operator this data can contain other sub-expressions which need to be parsed using
     * ExpressionParser
     *
     * @param array $config Expressions to be processed
     * @see ExpressionParser
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Sets operator parser which will be used to parse arrays and return more operator instances.
     *
     * @param ExpressionParser $parser Parser which will be set.
     */
    public function setParser(ExpressionParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Evaluates one value.
     *
     * @param ValueParser $value Value to be evaluated
     * @return mixed Evaluation result
     */
    public function evaluate(ValueParser $value)
    {
        // TODO: Implement evaluate() method.
    }
}