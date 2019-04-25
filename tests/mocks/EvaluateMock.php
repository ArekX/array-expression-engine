<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\mocks;

use ArekX\ArrayExpression\Evaluate;

class EvaluateMock extends Evaluate
{
    public $config = null;

    protected function __construct($expression, $config)
    {
        parent::__construct($expression, $config);
        $this->config = $config;
    }

    public function getExpression()
    {
        return $this->expression;
    }

    public function getParserMap()
    {
        return $this->parserMap;
    }

    public function getValueParser()
    {
        return $this->valueParser;
    }

    public function determineValueParserTestMethod($value)
    {
        return $this->determineValueParserClass($value);
    }
}