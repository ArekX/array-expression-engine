<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Interfaces;


/**
 * Interface Operator
 * Instance of one operator which can have subexpressions.
 *
 * @package ArekX\ArrayExpression\Interfaces
 */
interface Operator
{
    /**
     * Passes data from operator configuration.
     *
     * Depending on the operator this data can contain other sub-expressions which need to be parsed using
     * ExpressionParser
     *
     * @param array $config Expressions to be processed
     * @see ExpressionParser
     */
    public function configure(array $config);

    /**
     * Sets operator parser which will be used to parse arrays and return more operator instances.
     *
     * @param ExpressionParser $parser Parser which will be set.
     */
    public function setParser(ExpressionParser $parser);

    /**
     * Evaluates one value.
     *
     * @param ValueParser $value Value to be evaluated
     * @return mixed Evaluation result
     */
    public function evaluate(ValueParser $value);
}
