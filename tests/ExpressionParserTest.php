<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;

use ArekX\ArrayExpression\Exceptions\TypeNotMappedException;
use ArekX\ArrayExpression\ExpressionParser;
use tests\Mocks\MockOperator;

class ExpressionParserTest extends TestCase
{
    public function testTypesAreReturned()
    {
        $parser = new ExpressionParser();
        $parser->setType('myType', function () {
            return "returned value";
        });

        $operator = $parser->parse(['myType']);

        $this->assertEquals("returned value", $operator);
    }

    public function testCorrectTypeIsReturned()
    {
        $parser = new ExpressionParser();
        $parser->setType('myType1', function () {
            return "returned value";
        });

        $parser->setType('myType2', function () {
            return "returned value 2";
        });

        $operator = $parser->parse(['myType2']);

        $this->assertEquals("returned value 2", $operator);
    }

    public function testParamIsPassed()
    {
        $parser = new ExpressionParser();
        $parser->setType('myType1', function ($type, $param) {
            return "returned value: " . $param;
        });

        $operator = $parser->parse(['myType1', 'a param']);

        $this->assertEquals("returned value: a param", $operator);
    }


    public function testSetMyType1()
    {
        $parser = new ExpressionParser();
        $parser->setTypeMap([
            'myType' => function ($type, $param) {
                return "returned value: " . $param;
            }
        ]);

        $operator = $parser->parse(['myType', 'a param']);

        $this->assertEquals("returned value: a param", $operator);
    }

    public function testReturnInstanceOfOperator()
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);

        $operator = $parser->parse(['mock', 'a param']);
        $this->assertInstanceOf(MockOperator::class, $operator);
    }

    public function testArrayIsPreconfigured()
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);

        $operator = $parser->parse(['mock', 'a param']);
        $this->assertInstanceOf(MockOperator::class, $operator);
    }


    public function testUnknownTypeThrowsAnError()
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);

        $this->expectException(TypeNotMappedException::class);
        $parser->parse(['unknownType', 'a param']);
    }
}