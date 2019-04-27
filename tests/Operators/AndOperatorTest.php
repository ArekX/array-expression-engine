<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\AndOperatorSpy;
use tests\TestCase;

/**
 * Class AndOperatorTest
 * @package tests\Operators
 *
 * @method AndOperatorSpy createInstance()
 */
class AndOperatorTest extends TestCase
{
    use OperatorTestTrait;

    protected $operator = AndOperatorSpy::class;

    public function testAndOperatorExitsOnFirstFalseValue()
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

        $operator->configure(['group', ['mock1'], ['mock2']]);
        $this->assertFalse($operator->evaluate(SingleValueParser::from("")));

        $this->assertEquals($mock1, $operator->getOperators()[1]);

        $this->assertArrayNotHasKey(2, $operator->getOperators());
    }

    public function testTrueReturnIfAllIsTrue()
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

        $operator->configure(['group', ['mock1'], ['mock2']]);
        $this->assertTrue($operator->evaluate(SingleValueParser::from("")));

        $this->assertEquals($mock1, $operator->getOperators()[1]);
        $this->assertEquals($mock2, $operator->getOperators()[2]);
    }
}