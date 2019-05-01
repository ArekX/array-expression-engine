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
 * Class CompareOperator
 * Operator for handling comparisons.
 *
 * @package ArekX\ArrayExpression\Operators
 */
class CompareOperator extends BaseOperator
{
    const EQ = '=';
    const LT = '<';
    const GT = '>';
    const LTE = '<=';
    const GTE = '>=';
    const NE = '<>';
    const IN = 'in';

    /**
     * Operator which will be used for comparison.
     *
     * @var string
     */
    public $operator = self::EQ;

    /**
     * Value which will be taken from value parser.
     *
     * @var Operator
     */
    public $operandA;

    /**
     * @var Operator
     */
    public $operandB;

    /**
     * @inheritDoc
     */
    public function configure(array $config)
    {
        $this->setName($config[0] ?? 'unknown');

        if (count($config) < 3) {
            throw new \InvalidArgumentException("Minimum format must be satisfied: ['{$this->getName()}', <expressionA>, <expressionB>]");
        }

        $lastParam = $config[3] ?? null;

        $this->assertIsExpression($config[1]);

        if ($lastParam !== null) {
            $this->assertIsExpression($lastParam);
            $this->operandA = $this->parser->parse($config[1]);
            $this->setOperator($config[2]);
            $this->operandB = $this->parser->parse($lastParam);
            return;
        }

        $this->assertIsExpression($config[2]);

        $this->operandA = $this->parser->parse($config[1]);
        $this->operandB = $this->parser->parse($config[2]);
        $this->setOperator(self::EQ);
    }

    /**
     * Sets operator for result checking.
     *
     * @param string $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @inheritDoc
     */
    public function evaluate(ValueParser $value)
    {
        $resultA = $this->operandA->evaluate($value);
        $resultB = $this->operandB->evaluate($value);

        switch ($this->operator) {
            case self::NE:
                return $resultA !== $resultB;
            case self::EQ:
                return $resultA === $resultB;
            case self::LT:
                return $resultA < $resultB;
            case self::LTE:
                return $resultA <= $resultB;
            case self::GT:
                return $resultA > $resultB;
            case self::GTE:
                return $resultA >= $resultB;
            case self::IN:
                return in_array($resultA, $resultB, true);
        }

        return $resultA === $resultB;
    }
}