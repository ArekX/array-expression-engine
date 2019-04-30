<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class OrOperator
 * Operator for handling OR function
 *
 * @package ArekX\ArrayExpression\Operators
 */
class OrOperator extends BaseGroupOperator
{
    /**
     * Evaluates one value.
     *
     * @param ValueParser $value Value to be evaluated
     * @return mixed Evaluation result
     * @throws \ArekX\ArrayExpression\Exceptions\NotAnExpressionException
     */
    public function evaluate(ValueParser $value)
    {
        for ($i = 1; array_key_exists($i, $this->config); $i++) {
            if (empty($this->operators[$i])) {
                $this->assertIsExpression($this->config[$i]);
                $this->operators[$i] = $this->parser->parse($this->config[$i]);
            }

            if ($this->operators[$i]->evaluate($value)) {
                return true;
            }
        }

        return false;
    }
}