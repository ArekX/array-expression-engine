<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;

use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\XOrOperatorSpy;
use tests\TestCase;

/**
 * Class XOrOperatorTest
 * @package tests\Operators
 *
 * @method XOrOperatorSpy createInstance()
 */
class XOrOperatorTest extends TestCase
{
    use OperatorTestTrait;

    protected $operator = XOrOperatorSpy::class;

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

        $operator->configure(['group', ['mock1'], ['mock2'], ['mock3']]);
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

        $operator->configure(['group', ['mock1'], ['mock2']]);
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

        $operator->configure(['group', ['mock1'], ['mock2']]);
        $this->assertTrue($operator->evaluate(SingleValueParser::from("")));

        $this->assertSame($mock1, $operator->getOperators()[1]);
        $this->assertSame($mock2, $operator->getOperators()[2]);
    }
}