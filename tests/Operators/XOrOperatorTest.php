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
use tests\Spies\XOrOperatorSpy;
use tests\TestCase;

class XOrOperatorTest extends TestCase
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

    public function testOrOperatorExitsOnFirstDifferingValue()
    {
        $operator = $this->createInstance();

        $mock1 = new MockOperator();
        $mock2 = new MockOperator();
        $mock3 = new MockOperator();
        $operator->getParser()->setType('mock1', function() use($mock1) {
            return $mock1;
        });
        $operator->getParser()->setType('mock2', function() use($mock2) {
            return $mock2;
        });
        $operator->getParser()->setType('mock3', function() use($mock3) {
            return $mock3;
        });

        $mock1->result = true;
        $mock2->result = false;

        $operator->setConfig(['group', ['mock1'], ['mock2'], ['mock3']]);
        $this->assertTrue($operator->evaluate(SingleValueParser::from("")));

        $this->assertSame($mock1, $operator->getOperators()[1]);
        $this->assertSame($mock2, $operator->getOperators()[2]);

        $this->assertArrayNotHasKey(3, $operator->getOperators());
    }


    public function testReturnFalseIfAllTrue()
    {
        $operator = $this->createInstance();

        $mock1 = new MockOperator();
        $mock2 = new MockOperator();
        $operator->getParser()->setType('mock1', function() use($mock1) {
            return $mock1;
        });
        $operator->getParser()->setType('mock2', function() use($mock2) {
            return $mock2;
        });

        $mock1->result = true;
        $mock2->result = true;

        $operator->setConfig(['group', ['mock1'], ['mock2']]);
        $this->assertFalse($operator->evaluate(SingleValueParser::from("")));

        $this->assertSame($mock1, $operator->getOperators()[1]);
        $this->assertSame($mock2, $operator->getOperators()[2]);
    }

    public function testReturnTrueIfAllFalse()
    {
        $operator = $this->createInstance();

        $mock1 = new MockOperator();
        $mock2 = new MockOperator();
        $operator->getParser()->setType('mock1', function() use($mock1) {
            return $mock1;
        });
        $operator->getParser()->setType('mock2', function() use($mock2) {
            return $mock2;
        });

        $mock1->result = false;
        $mock2->result = false;

        $operator->setConfig(['group', ['mock1'], ['mock2']]);
        $this->assertTrue($operator->evaluate(SingleValueParser::from("")));

        $this->assertSame($mock1, $operator->getOperators()[1]);
        $this->assertSame($mock2, $operator->getOperators()[2]);
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

    protected function createInstance(): XOrOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $operator = new XOrOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}