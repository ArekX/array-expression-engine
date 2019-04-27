<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;

use ArekX\ArrayExpression\ExpressionParser;
use tests\Spies\EvaluatorSpy;

class EvaluateTest extends TestCase
{
    public function testCreateInitialInstance()
    {
        $i = $this->createInstance();
        $this->assertEquals(null, $i->getExpressionParser());
        $this->assertEquals(null, $i->getValueHandler());
    }

    public function testParserGetsPassedInConstructor()
    {
        $parser = new ExpressionParser();
        $i = $this->createInstance($parser);
        $this->assertEquals($parser, $i->getExpressionParser());
    }

    protected function createInstance($expressionParser = null, $valueParser = null): EvaluatorSpy
    {
        return EvaluatorSpy::from($expressionParser, $valueParser);
    }
}