<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\Exceptions\InvalidEvaluationResultType;
use ArekX\ArrayExpression\ExpressionParser;
use ArekX\ArrayExpression\Operators\GetOperator;
use ArekX\ArrayExpression\Operators\ValueOperator;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\ConcatOperatorSpy;
use tests\TestCase;

/**
 * Class ConcatOperatorTest
 * @package tests\Operators
 *
 */
class ConcatOperatorTest extends TestCase
{
    public function testParserIsSet()
    {
        $i = $this->createInstance();
        $parser = new ExpressionParser();
        $i->setParser($parser);
        $this->assertSame($parser, $i->getParser());
    }

    public function testConfigureCreatesConcatOperators()
    {
        $i = $this->createInstance();
        $i->configure(['concat', ['get', 'first'], ['value', false], ['mock']]);
        $this->assertInstanceOf(GetOperator::class, $i->concatOperators[0]);
        $this->assertInstanceOf(ValueOperator::class, $i->concatOperators[1]);
        $this->assertInstanceOf(MockOperator::class, $i->concatOperators[2]);
    }

    public function testNameIsSet()
    {
        $i = $this->createInstance();
        $i->configure(['concat', ['mock']]);
        $this->assertSame('concat', $i->getName());
        $i->configure([1 => ['mock'], 2 => ['mock']]);
        $this->assertSame('unknown', $i->getName());
    }

    public function testConcatenation()
    {
        $i = $this->createInstance();
        $i->configure(['concat', ['get', 'first'], ['value', ' '], ['get', 'last']]);
        $this->assertSame('John Snow', $i->evaluate(ArrayValueParser::from(['first' => 'John', 'last' => 'Snow'])));
    }

    public function testInvalidResult()
    {
        $i = $this->createInstance();
        $i->configure(['concat', ['get', 'first'], ['value', false], ['get', 'last']]);
        $this->expectException(InvalidEvaluationResultType::class);
        $this->assertSame('John Snow', $i->evaluate(ArrayValueParser::from(['first' => 'John', 'last' => 'Snow'])));
    }

    public function testThrowsErrorIfNotValidSyntax()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure([]);
    }

    public function testThrowsErrorWhenJustOneName()
    {
        $i = $this->createInstance();
        $this->expectException(\InvalidArgumentException::class);
        $i->configure(['concat']);
    }

    protected function createInstance(): ConcatOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $parser->setType('get', GetOperator::class);
        $parser->setType('value', ValueOperator::class);
        $operator = new ConcatOperatorSpy();
        $operator->setParser($parser);

        return $operator;
    }
}