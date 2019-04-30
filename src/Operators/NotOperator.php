<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class NotOperator
 * Operator for handling NOT function
 *
 * @package ArekX\ArrayExpression\Operators
 */
class NotOperator extends BaseGroupOperator
{
    /**
     * Evaluates one value.
     *
     * @param ValueParser $value Value to be evaluated
     * @return mixed Evaluation result
     */
    public function evaluate(ValueParser $value)
    {
        if (empty($this->operators[1])) {
            $this->assertIsExpression($this->config[1]);
            $this->operators[1] = $this->parser->parse($this->config[1]);
        }

        return !$this->operators[1]->evaluate($value);
    }
}