<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ExpressionParser;
use ArekX\ArrayExpression\Operators\ValueOperator;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\BetweenOperatorSpy;
use tests\Spies\GetOperatorSpy;
use tests\TestCase;

/**
 * Class BetweenOperatorTest
 * @package tests\Operators
 *
 */
class BetweenOperatorTest extends TestCase
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
        $i->configure(['between', ['value', 1], ['value', 1], ['value', 1]]);
        $this->assertSame('between', $i->getName());
        $i->configure([-1 => 'nope', 1 => ['value', 1], 2 => ['value', 1], 3 => ['value', 1]]);
        $this->assertSame('unknown', $i->getName());
    }

    public function testThrowsErrorIfNoParams()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['between']);
    }

    public function testThrowsErrorIfOnlyOneParam()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['between', ['value', 1]]);
    }

    public function testThrowsErrorIfOnlyTwoParams()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['between', ['value', 1], ['value', 1]]);
    }


    public function testBetweenTests()
    {
        $i = $this->createInstance();

        $tests = [
            [['between', ['value', 1], ['value', 0], ['value', 2]], true],
            [['between', ['value', 22], ['value', 0], ['value', 2]], false],
            [['between', ['value', -200], ['value', 0], ['value', 2]], false],
            [['between', ['value', 0], ['value', 0], ['value', 2]], true],
            [['between', ['value', 2], ['value', 0], ['value', 2]], true],
        ];

        $value = SingleValueParser::from("");
        foreach ($tests as $test) {
            $i->configure($test[0]);
            $this->assertSame($test[1], $i->evaluate($value));
        }
    }

    protected function createInstance(): BetweenOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $parser->setType('value', ValueOperator::class);
        $operator = new BetweenOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}