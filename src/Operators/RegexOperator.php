<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class RegexOperator
 * Operator for handling comparisons.
 *
 * @package ArekX\ArrayExpression\Operators
 */
class RegexOperator extends BaseOperator
{
    /**
     * Value which will be taken from value parser.
     *
     * @var string
     */
    public $fromValue;

    /**
     * @var string Regex result against which it will be matched.
     */
    public $match;

    /**
     * Default value to be returned if nothing is found.
     *
     * @var mixed
     */
    public $default;

    /**
     * @inheritDoc
     */
    public function configure(array $config)
    {
        $this->default = $config['default'] ?? '';

        if (count($config) < 2) {
            throw new \InvalidArgumentException('Match must be passed.');
        }

        $applyParams = array_filter([
            $config[1] ?? null,
            $config[2] ?? null,
        ]);

        if (count($applyParams) === 1) {
            $this->match = $applyParams[0];
        } elseif (count($applyParams) === 2) {
            $this->fromValue = $applyParams[0];
            $this->match = $applyParams[1];
        }
    }

    /**
     * @inheritDoc
     */
    public function evaluate(ValueParser $value)
    {
        return (bool)preg_match($this->match, $value->getValue($this->fromValue, $this->default));
    }
}