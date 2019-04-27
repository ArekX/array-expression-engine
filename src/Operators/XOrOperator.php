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
 * Class XOrOperator
 * Operator for handling XOR function
 *
 * @package ArekX\ArrayExpression\Operators
 */
class XOrOperator extends BaseGroupOperator
{
    /**
     * Evaluates one value.
     *
     * @param ValueParser $value Value to be evaluated
     * @return mixed Evaluation result
     */
    public function evaluate(ValueParser $value)
    {
        $previousValue = null;
        for ($i = 1; array_key_exists($i, $this->config); $i++) {
            if (empty($this->operators[$i])) {
                $this->operators[$i] = $this->parser->parse($this->config[$i]);
            }

            $result = $this->operators[$i]->evaluate($value);

            if ($previousValue !== null && $result !== $previousValue) {
                return true;
            }

            $previousValue = $result;
        }

        return !$previousValue;
    }
}