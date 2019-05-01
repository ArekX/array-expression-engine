<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class BetweenOperator
 * Operator for between operation.
 *
 * @package ArekX\ArrayExpression\Operators
 */
class BetweenOperator extends BaseOperator
{
    /**
     * Operator result which will be checked.
     *
     * @var Operator
     */
    public $operandA;

    /**
     * Operator result which will be used for minimum.
     *
     * @var Operator
     */
    public $operandB;

    /**
     * Operator result which will be used for maximum.
     *
     * @var Operator
     */
    public $operandC;

    /**
     * @inheritDoc
     */
    public function configure(array $config)
    {
        $this->setName($config[0] ?? 'unknown');

        if (count($config) < 4) {
            throw new \InvalidArgumentException("No matching minimum format: ['{$this->getName()}', <valueExpression>, <minExpression>, <maxExpression>");
        }

        $this->assertIsExpression($config[1]);
        $this->assertIsExpression($config[2]);
        $this->assertIsExpression($config[3]);

        $this->operandA = $this->parser->parse($config[1]);
        $this->operandB = $this->parser->parse($config[2]);
        $this->operandC = $this->parser->parse($config[3]);
    }

    /**
     * @inheritDoc
     */
    public function evaluate(ValueParser $value)
    {
        $resultA = $this->operandA->evaluate($value);
        $resultB = $this->operandB->evaluate($value);
        $resultC = $this->operandC->evaluate($value);

        return $resultA >= $resultB && $resultA <= $resultC;
    }
}