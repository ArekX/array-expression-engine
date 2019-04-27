<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

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
     * @var string
     */
    public $fromValue;

    /**
     * Default value to be returned if nothing is found.
     *
     * @var mixed
     */
    public $default;

    /**
     * @var mixed Result which will be used to compare result against.
     */
    public $vsResult;

    /**
     * @inheritDoc
     */
    public function configure(array $config)
    {
        $this->default = $config['default'] ?? null;

        if (count($config) < 2) {
            throw new \InvalidArgumentException('Name and value must be passed.');
        }

        $applyParams = array_filter([
            $config[1] ?? null,
            $config[2] ?? null,
            $config[3] ?? null,
        ]);

        if (count($applyParams) === 1) {
            $this->vsResult = $applyParams[0];
        } elseif (count($applyParams) === 2) {
            $this->fromValue = $applyParams[0];
            $this->vsResult = $applyParams[1];
        } elseif(count($applyParams) === 3) {
            $this->fromValue = $applyParams[0];
            $this->setOperator($applyParams[1]);
            $this->vsResult = $applyParams[2];
        }
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
        $vsValue = $value->getValue($this->fromValue, $this->default);

        switch ($this->operator) {
            case self::NE:
                return $this->vsResult !== $vsValue;
            case self::EQ:
                return $this->vsResult === $vsValue;
            case self::LT:
                return $vsValue < $this->vsResult;
            case self::LTE:
                return $vsValue <= $this->vsResult;
            case self::GT:
                return $vsValue > $this->vsResult;
            case self::GTE:
                return $vsValue >= $this->vsResult;
            case self::IN:
                return in_array($vsValue, $this->vsResult, true);
        }

        return $this->vsResult === $vsValue;
    }
}