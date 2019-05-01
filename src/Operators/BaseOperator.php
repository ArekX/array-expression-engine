<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;


use ArekX\ArrayExpression\Exceptions\NotAnExpressionException;
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
     * Name of the operator.
     *
     * @var string
     */
    protected $name;

    /**
     * Parser used for expression parsing.
     *
     * @var ExpressionParser
     */
    protected $parser;

    /**
     * @inheritDoc
     */
    public function setParser(ExpressionParser $parser)
    {
        $this->parser = $parser;
    }

    protected function setName($name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function isExpression($value)
    {
        return is_array($value) && count($value) >= 1 && is_string($value[0]);
    }

    protected function assertIsExpression($value)
    {
        if (!$this->isExpression($value)) {
            throw new NotAnExpressionException($value);
        }
    }
}