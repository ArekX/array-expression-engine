<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Spies;

use ArekX\ArrayExpression\Operators\NotOperator;

class NotOperatorSpy extends NotOperator
{
    public function getConfig()
    {
        return $this->config;
    }

    public function getParser()
    {
        return $this->parser;
    }

    public function getOperators()
    {
        return $this->operators;
    }
}