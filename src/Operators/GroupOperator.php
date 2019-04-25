<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\OperatorParser;

class GroupOperator implements Operator
{

    /**
     * Passes data from operator configuration..
     *
     * Depending on the operator this data can contain other sub-expressions which need to be parsed using
     * OperatorParser
     *
     * @param array $data Expressions to be processed
     * @see OperatorParser
     */
    public function setData(array $data)
    {
        // TODO: Implement setData() method.
    }

    /**
     * Sets operator parser which will be used to parse arrays and return more operator instances.
     *
     * @param OperatorParser $parser Parser which will be set.
     */
    public function setParser(OperatorParser $parser)
    {
        // TODO: Implement setParser() method.
    }

    /**
     * Evaluates one value.
     *
     * @param mixed $value Value to be evaluated
     * @return mixed Evaluation result
     */
    public function evaluate($value)
    {
        // TODO: Implement evaluate() method.
    }
}