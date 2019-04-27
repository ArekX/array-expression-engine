<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ExpressionParser;
use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\Mocks\MockOperator;

trait OperatorTestTrait
{
    public function testSetConfig()
    {
        $operator = $this->createInstance();
        $operator->configure(['group', ['mock']]);

        $this->assertEquals(['group', ['mock']], $operator->getConfig());
    }

    public function testConfigMustHaveAtLeastOneSubExpression()
    {
        $operator = $this->createInstance();

        $this->expectException(\InvalidArgumentException::class);
        $operator->configure(['group']);
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
        $operator->configure(['group', ['mock']]);
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
        $operator->configure(['group', ['mock']]);
        $operator->evaluate($value);

        $mock2 = new MockOperator();
        $operator->getParser()->setType('mock', function() use($mock2) {
            return $mock2;
        });
        $operator->evaluate($value);

        $this->assertSame($mock, $operator->getOperators()[1]);
    }

    protected function createInstance(): Operator
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $operator = new $this->operator();
        $operator->setParser($parser);

        return $operator;
    }
}