<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Interfaces;

/**
 * Interface OperatorParser
 * @package ArekX\ArrayExpression\Interfaces
 *
 * Interface which can be passed to evaluator for parsing operators.
 */
interface OperatorParser
{
    /**
     * Parses array expresion and returns an instance of an Operator
     *
     * @param array $expression Expression to be parsed
     * @return Operator Operator handler.
     * @see Operator
     */
    public function parse(array $expression);
}