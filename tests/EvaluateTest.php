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
        $this->assertEquals(null, $i->getCurrentExpressionParser());
    }

    public function testParserGetsPassedInConstructor()
    {
        $parser = new ExpressionParser();
        $i = $this->createInstance($parser);
        $this->assertEquals($parser, $i->getCurrentExpressionParser());
    }

    public function testEvaluatorRun()
    {
        $i = $this->createInstance();
        $result = $i->run(
            ['compare', 'test'],
            "test"
        );
        $this->assertTrue($result);
    }

    public function testCombinedEvaluatorRun()
    {
        $i = $this->createInstance();
        $value = [
            'name' => 'value',
            'name2' => 'valueB'
        ];
        $result = $i->run(
            [
                'and',
                ['compare', 'name', 'value'],
                [
                    'or',
                    ['compare', 'name2', 'valueA'],
                    ['compare', 'name2', 'valueB'],
                ],

            ],
            $value
        );
        $this->assertTrue($result);
    }

    public function testCombinedEvaluatorFailureRun()
    {
        $i = $this->createInstance();
        $value = (object)[
            'name' => 'value',
            'name2' => 'valueC'
        ];
        $result = $i->run(
            [
                'and',
                ['compare', 'name', 'value'],
                [
                    'or',
                    ['compare', 'name2', 'valueA'],
                    ['compare', 'name2', 'valueB'],
                ],

            ],
            $value
        );
        $this->assertFalse($result);
    }

    protected function createInstance($expressionParser = null): EvaluatorSpy
    {
        return EvaluatorSpy::create($expressionParser);
    }
}