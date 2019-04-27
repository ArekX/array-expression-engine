<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Spies;


use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\OperatorParser;
use ArekX\ArrayExpression\Interfaces\ValueParser;

class MockOperator implements Operator
{
    /**
     * @inheritDoc
     */
    public function setData(array $data)
    {
        // TODO: Implement setData() method.
    }

    /**
     * @inheritDoc
     */
    public function setParser(OperatorParser $parser)
    {
        // TODO: Implement setParser() method.
    }

    /**
     * @inheritDoc
     */
    public function evaluate(ValueParser $value)
    {
        // TODO: Implement evaluate() method.
    }
}