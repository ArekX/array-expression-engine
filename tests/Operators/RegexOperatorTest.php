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
use tests\Spies\RegexOperatorSpy;
use tests\TestCase;

/**
 * Class OrOperatorTest
 * @package tests\Operators
 *
 */
class RegexOperatorTest extends TestCase
{
    public function testParserIsSet()
    {
        $i = $this->createInstance();
        $parser = new ExpressionParser();
        $i->setParser($parser);
        $this->assertSame($parser, $i->getParser());
    }


    public function testErrorIfTheConfigIsNotComplete()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['regex']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    public function testMatchesSingleValue()
    {
        $i = $this->createInstance();
        $i->configure(['regex', '/a+/']);
        $this->assertTrue($i->evaluate(SingleValueParser::from("aaaaaaa")));
    }


    public function testChecksByByName()
    {
        $i = $this->createInstance();
        $i->configure(['regex', 'name', '/^a+$/']);
        $this->assertFalse($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }


    public function testUseDefaultValue()
    {
        $i = $this->createInstance();
        $i->configure(['regex', 'unknownKey', '/value/', 'default' => 'value']);
        $this->assertTrue($i->evaluate(ArrayValueParser::from(['name' => 'value'])));
    }

    protected function createInstance(): RegexOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $operator = new RegexOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}