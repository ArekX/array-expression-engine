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
use tests\Spies\NotOperatorSpy;
use tests\TestCase;

class NotOperatorTest extends TestCase
{
    public function testSetConfig()
    {
        $operator = $this->createInstance();
        $operator->setConfig(['group', ['mock']]);

        $this->assertEquals(['group', ['mock']], $operator->getConfig());
    }

    public function testConfigMustHaveAtLeastOneSubExpression()
    {
        $operator = $this->createInstance();

        $this->expectException(\InvalidArgumentException::class);
        $operator->setConfig(['group']);
    }

    public function testTrueIsInverted()
    {
        $operator = $this->createInstance();

        $mock1 = new MockOperator();
        $operator->getParser()->setType('mock1', function() use($mock1) {
            return $mock1;
        });
        $mock1->result = true;

        $operator->setConfig(['group', ['mock1']]);
        $this->assertFalse($operator->evaluate(SingleValueParser::from("")));
        $this->assertEquals($mock1, $operator->getOperators()[1]);
    }

    public function testFalseIsInverted()
    {
        $operator = $this->createInstance();

        $mock1 = new MockOperator();
        $operator->getParser()->setType('mock1', function() use($mock1) {
            return $mock1;
        });
        $mock1->result = false;

        $operator->setConfig(['group', ['mock1']]);
        $this->assertTrue($operator->evaluate(SingleValueParser::from("")));
        $this->assertEquals($mock1, $operator->getOperators()[1]);
    }

    public function testParserIsSet()
    {
        $operator = $this->createInstance();
        $parser = new ExpressionParser();
        $operator->setParser($parser);
        $this->assertSame($parser, $operator->getParser());
    }

    public function testCallingEvaluateWillCreateExpressionOperatorsInternally()
    {
        $operator = $this->createInstance();
        $mock = new MockOperator();
        $operator->getParser()->setType('mock', function() use($mock) {
            return $mock;
        });
        $value = SingleValueParser::from("");
        $operator->setConfig(['group', ['mock']]);
        $operator->evaluate($value);

        $this->assertSame($mock, $operator->getOperators()[1]);
    }

    public function testCallingEvaluateTwiceWillNotRecreateOperator()
    {
        $operator = $this->createInstance();
        $mock = new MockOperator();
        $operator->getParser()->setType('mock', function() use($mock) {
            return $mock;
        });
        $value = SingleValueParser::from("");
        $operator->setConfig(['group', ['mock']]);
        $operator->evaluate($value);

        $mock2 = new MockOperator();
        $operator->getParser()->setType('mock', function() use($mock2) {
            return $mock2;
        });
        $operator->evaluate($value);

        $this->assertSame($mock, $operator->getOperators()[1]);
    }

    protected function createInstance(): NotOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $operator = new NotOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}