<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;

use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\Mocks\MockOperator;
use tests\Spies\NotOperatorSpy;
use tests\TestCase;

/**
 * Class NotOperatorTest
 * @package tests\Operators
 *
 * @method NotOperatorSpy createInstance()
 */
class NotOperatorTest extends TestCase
{
    use OperatorTestTrait;

    protected $operator = NotOperatorSpy::class;

    public function testTrueIsInverted()
    {
        $operator = $this->createInstance();

        $mock1 = new MockOperator();
        $operator->getParser()->setType('mock1', function() use($mock1) {
            return $mock1;
        });
        $mock1->result = true;

        $operator->configure(['group', ['mock1']]);
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

        $operator->configure(['group', ['mock1']]);
        $this->assertTrue($operator->evaluate(SingleValueParser::from("")));
        $this->assertEquals($mock1, $operator->getOperators()[1]);
    }
}