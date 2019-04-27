<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\OrOperatorSpy;
use tests\TestCase;

/**
 * Class OrOperatorTest
 * @package tests\Operators
 *
 * @method OrOperatorSpy createInstance()
 */
class OrOperatorTest extends TestCase
{
    use OperatorTestTrait;

    protected $operator = OrOperatorSpy::class;

    public function testOrOperatorExitsOnFirstTrueValue()
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

        $operator->configure(['group', ['mock1'], ['mock2']]);
        $this->assertTrue($operator->evaluate(SingleValueParser::from("")));

        $this->assertEquals($mock1, $operator->getOperators()[1]);

        $this->assertArrayNotHasKey(2, $operator->getOperators());
    }


    public function testFalseReturnIfAllIsFalse()
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
        $this->assertFalse($operator->evaluate(SingleValueParser::from("")));

        $this->assertEquals($mock1, $operator->getOperators()[1]);
        $this->assertEquals($mock2, $operator->getOperators()[2]);
    }
}