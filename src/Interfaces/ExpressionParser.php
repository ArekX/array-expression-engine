<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Interfaces;


/**
 * Interface ExpressionParser
 *
 * Interface for definition of expression parser.
 *
 * @package ArekX\ArrayExpression\Interfaces
 */
interface ExpressionParser
{
    /**
     * Set type resolvers for multiple types.
     *
     * @param array $typeMap
     */
    public function setTypeMap(array $typeMap);

    /**
     * Sets a type resolver.
     *
     * @param string $type Type name
     * @param callable|string $resolver Callable resolver or a class which gets created.
     */
    public function setType(string $type, $resolver);

    /**
     * Parses array expresion and returns an instance of an Operator
     *
     * @param array $expression Expression to be parsed
     * @return Operator Operator handler.
     * @see Operator
     */
    public function parse(array $expression);
}