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
 * Class ValueOperator
 * Operator for returning static values
 *
 * @package ArekX\ArrayExpression\Operators
 */
class ValueOperator extends BaseOperator
{
    /**
     * Value which will be returned.
     *
     * @var mixed
     */
    public $value;

    /**
     * Evaluates one value.
     *
     * @param ValueParser $value Value to be evaluated
     * @return mixed Evaluation result
     */
    public function evaluate(ValueParser $value)
    {
        return $this->value;
    }

    /**
     * Passes data from operator configuration.
     *
     * Depending on the operator this data can contain other sub-expressions which need to be parsed using
     * ExpressionParser
     *
     * @param array $config Expressions to be processed
     * @see ExpressionParser
     */
    public function configure(array $config)
    {
        $this->setName($config[0] ?? 'unknown');

        if (count($config) <= 1) {
            throw new \InvalidArgumentException("Minimum format must be satisfied: ['{$this->getName()}', <value>]");
        }

        $this->value = $config[1];
    }
}