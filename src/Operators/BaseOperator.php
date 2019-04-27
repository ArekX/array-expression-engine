<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;


use ArekX\ArrayExpression\Interfaces\ExpressionParser;
use ArekX\ArrayExpression\Interfaces\Operator;

/**
 * Class BaseOperator
 * Base class for all operators
 *
 * @package ArekX\ArrayExpression\Operators
 */
abstract class BaseOperator implements Operator
{
    /**
     * Parser used for expression parsing.
     *
     * @var null|ExpressionParser
     */
    protected $parser = null;

    /**
     * @inheritDoc
     */
    public function setParser(ExpressionParser $parser)
    {
        $this->parser = $parser;
    }
}