<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ExpressionParser;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
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

    public function testNameIsTakenFromValue()
    {
        $i = $this->createInstance();
        $i->configure(['compare', 'name', 'value']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testErrorIfTheConfigIsNotComplete()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['compare']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testSingleValueCompare()
    {
        $i = $this->createInstance();
        $i->configure(['compare', 'value']);
        $this->assertTrue($i->evaluate(SingleValueParser::from("value")));
    }


    public function test4ValuesSetAnOperator()
    {
        $i = $this->createInstance();
        $i->configure(['compare', 'name', '<>', 'value']);
        $this->assertFalse($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }


    public function testSettingInvalidOperatorsDefersToEqOperator()
    {
        $i = $this->createInstance();
        $i->configure(['compare', 'name', '!!!', 'value']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }


    public function testUseDefaultValue()
    {
        $i = $this->createInstance();
        $i->configure(['compare', 'unknownKey', 'value', 'default' => 'value']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testOperators()
    {
        $i = $this->createInstance();
        $value = ArrayValueParser::from(['name' => 'value', 'number' => 5]);

        $maps = [
            [['compare', 'name', '<>', 'value'], false],
            [['compare', 'name', '<>', 'value1'], true],
            [['compare', 'name', '=', 'value'], true],
            [['compare', 'name', '=', 'value1'], false],
            [['compare', 'number', '>', 5], false],
            [['compare', 'number', '>', 4], true],
            [['compare', 'number', '>=', 5], true],
            [['compare', 'number', '>=', 6], false],
            [['compare', 'number', '<', 6], true],
            [['compare', 'number', '<', 4], false],
            [['compare', 'number', '<=', 5], true],
            [['compare', 'number', '<=', 4], false],
            [['compare', 'number', 'in', [4,5,6]], true],
            [['compare', 'number', 'in', [1,2]], false],
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
        $operator = new CompareOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}