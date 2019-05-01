<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ExpressionParser;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\GetOperatorSpy;
use tests\TestCase;

/**
 * Class GetOperatorTest
 * @package tests\Operators
 *
 */
class GetOperatorTest extends TestCase
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
        $i->configure(['get', 'name']);
        $this->assertSame('get', $i->getName());
        $i->configure([1 => 'get', 2 => 'name']);
        $this->assertSame('unknown', $i->getName());
    }

    public function testAlwaysReturnAValue()
    {
        $i = $this->createInstance();
        $i->configure(['get', 'name']);
        $this->assertSame('this is a name', $i->evaluate(ArrayValueParser::from(['name' => 'this is a name'])));
    }

    public function testThrowsErrorIfNotValidSyntax()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure([]);
    }

    protected function createInstance(): GetOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $operator = new GetOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}