<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Mocks;


use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\ExpressionParser;
use ArekX\ArrayExpression\Interfaces\ValueParser;

class MockOperator implements Operator
{
    public $config;
    public $preConfig;
    public $parser;
    public $valueParser;
    public $result = true;


    /**
     * Passes data from operator configuration..
     *
     * Depending on the operator this data can contain other sub-expressions which need to be parsed using
     * ExpressionParser
     *
     * @param array $config Expressions to be processed
     * @see ExpressionParser
     */
    public function configure(array $config)
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
        $this->valueParser = $value;
        return $this->result;
    }

    /**
     * Passes data from expression parser configuration.
     *
     * Depending on the operator this data can contain other sub-expressions which need to be parsed using
     * ExpressionParser
     *
     * @param array $config Expressions to be processed
     * @see ExpressionParser
     */
    public function preconfigure(array $config)
    {
        $this->preConfig = $config;
    }
}