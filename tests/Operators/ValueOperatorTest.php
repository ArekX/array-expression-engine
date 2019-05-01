<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ExpressionParser;
use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\ValueOperatorSpy;
use tests\TestCase;

/**
 * Class ValueOperatorTest
 * @package tests\Operators
 *
 */
class ValueOperatorTest extends TestCase
{
    public function testParserIsSet()
    {
        $i = $this->createInstance();
        $parser = new ExpressionParser();
        $i->setParser($parser);
        $this->assertSame($parser, $i->getParser());
    }

    public function testNameIsSet()
    {
        $i = $this->createInstance();
        $value = rand(1, 50000);
        $i->configure(['value', $value]);
        $this->assertSame('value', $i->getName());
        $i->configure([1 => 'value', 2 => $value]);
        $this->assertSame('unknown', $i->getName());
    }

    public function testAlwaysReturnAValue()
    {
        $i = $this->createInstance();
        $value = rand(1, 50000);
        $i->configure(['value', $value]);
        $this->assertSame($value, $i->evaluate(SingleValueParser::from('')));
    }

    public function testThrowsErrorIfNotValidSyntax()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['value']);
    }

    protected function createInstance(): ValueOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $operator = new ValueOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}