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

/**
 * Class ExpressionParser
 * Expression parser which converts array expressions into Operator instances.
 *
 * @package ArekX\ArrayExpression
 */
class ExpressionParser implements ExpressionParserInterface
{
    /**
     * Type map used to resolve types in arrays.
     * @var array
     */
    protected $typeMap = [];

    /**
     * @inheritDoc
     */
    public function setTypeMap(array $typeMap)
    {
        $this->typeMap = $typeMap;
    }

    /**
     * Sets a type resolver.
     *
     * @param string $type Type name
     * @param callable|string $resolver Callable resolver or a class which gets created.
     */
    public function setType(string $type, $resolver)
    {
        $this->typeMap[$type] = $resolver;
    }

    /**
     * @inheritDoc
     * @throws TypeNotMappedException
     */
    public function parse(array $expression)
    {
        if (empty($this->typeMap[$expression[0]])) {
            throw new TypeNotMappedException($expression[0]);
        }

        $resolver = $this->typeMap[$expression[0]];

        if (is_callable($resolver)) {
            return $resolver(...$expression);
        }

        /** @var Operator $resolver */
        $resolver = new $resolver();
        $resolver->setParser($this);
        $resolver->configure($expression);
        return $resolver;
    }
}