<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Operators;


use ArekX\ArrayExpression\ExpressionParser;
use tests\Mocks\MockOperator;
use tests\Spies\GroupOperatorSpy;
use tests\TestCase;

class GroupOperatorTest extends TestCase
{
    public function testSetConfig()
    {
        $groupOperator = $this->createInstance();
        $groupOperator->setConfig(['mock']);

        $this->assertEquals(['mock'], $groupOperator->getConfig());
    }

    public function testParserIsSet()
    {
        $groupOperator = $this->createInstance();
        $parser = new ExpressionParser();
        $groupOperator->setParser($parser);
        $this->assertEquals($parser, $groupOperator->getParser());
    }

    protected function createInstance(): GroupOperatorSpy
    {
        $parser = new ExpressionParser();
        $parser->setType('mock', MockOperator::class);
        $groupOperator = new GroupOperatorSpy();
        $groupOperator->setParser($parser);

        return $groupOperator;
    }
}