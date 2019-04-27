<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Spies;

use ArekX\ArrayExpression\Evaluator;

class EvaluatorSpy extends Evaluator
{
    public function getCurrentExpressionParser()
    {
        return $this->expressionParser;
    }
}