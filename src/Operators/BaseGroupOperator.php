<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;


use ArekX\ArrayExpression\Interfaces\ExpressionParser;
use ArekX\ArrayExpression\Interfaces\Operator;

abstract class BaseGroupOperator implements Operator
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
     * List of instanced operators
     *
     * @var Operator[]
     */
    protected $operators = [];

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
        if (count($config) <= 1) {
            throw new \InvalidArgumentException('Config must have at least one sub operator.');
        }
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
}