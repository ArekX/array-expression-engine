<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\Exceptions\NotAnExpressionException;
use ArekX\ArrayExpression\ExpressionParser;
use ArekX\ArrayExpression\Operators\GetOperator;
use ArekX\ArrayExpression\Operators\ValueOperator;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\CompareOperatorSpy;
use tests\TestCase;

/**
 * Class OrOperatorTest
 * @package tests\Operators
 *
 */
class CompareOperatorTest extends TestCase
{
    public function testParserIsSet()
    {
        $i = $this->createInstance();
        $parser = new ExpressionParser();
        $i->setParser($parser);
        $this->assertSame($parser, $i->getParser());
    }

    public function testValidGetName()
    {
        $i = $this->createInstance();
        $i->configure(['compare', ['get', 'name'], ['value', 'value']]);
        $this->assertEquals('compare', $i->getName());
    }

    public function testEquationCompare()
    {
        $i = $this->createInstance();
        $i->configure(['compare', ['get', 'name'], ['value', 'value']]);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testSettingInvalidOperatorsDefersToEqOperator()
    {
        $i = $this->createInstance();
        $i->configure(['compare', ['get', 'name'], '!!!', ['value', 'value']]);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testInvalidArgumentExceptionOnInvalidConfig()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['compare']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testNotValidExpressionInFirstParam()
    {
        $i = $this->createInstance();
        $this->expectException(NotAnExpressionException::class);
        $i->configure(['compare', 'test', ['get']]);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testNotValidExpressionInFirstParamFullStyle()
    {
        $i = $this->createInstance();
        $this->expectException(NotAnExpressionException::class);
        $i->configure(['compare', 'test', '=', ['get']]);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }


    public function testNotValidExpressionInSecondParam()
    {
        $i = $this->createInstance();
        $this->expectException(NotAnExpressionException::class);
        $i->configure(['compare', ['get'], 'test']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testNotValidExpressionInSecondParamFullStyle()
    {
        $i = $this->createInstance();
        $this->expectException(NotAnExpressionException::class);
        $i->configure(['compare', ['get'], '=', 'test']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testOperators()
    {
        $i = $this->createInstance();
        $value = ArrayValueParser::from(['name' => 'value', 'number' => 5]);

        $maps = [
            [['compare', ['get', 'name'], '<>', ['value', 'value']], false],
            [['compare', ['get', 'name'], '<>', ['value', 'value1']], true],
            [['compare', ['get', 'name'], '=', ['value', 'value']], true],
            [['compare', ['get', 'name'], '=', ['value', 'value1']], false],
            [['compare', ['get', 'number'], '>', ['value', 5]], false],
            [['compare', ['get', 'number'], '>', ['value', 4]], true],
            [['compare', ['get', 'number'], '>=', ['value', 5]], true],
            [['compare', ['get', 'number'], '>=', ['value', 6]], false],
            [['compare', ['get', 'number'], '<', ['value', 6]], true],
            [['compare', ['get', 'number'], '<', ['value', 4]], false],
            [['compare', ['get', 'number'], '<=', ['value', 5]], true],
            [['compare', ['get', 'number'], '<=', ['value', 4]], false],
            [['compare', ['get', 'number'], 'in', ['value', [4,5,6]]], true],
            [['compare', ['get', 'number'], 'in', ['value', [1,2]]], false],
        ];

        foreach ($maps as $map) {
            $i->configure($map[0]);
            $this->assertEquals($map[1], $i->evaluate($value));
        }
    }

    protected function createInstance(): CompareOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $parser->setType('get', GetOperator::class);
        $parser->setType('value', ValueOperator::class);
        $operator = new CompareOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}