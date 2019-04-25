<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\ValueParsers;


use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\TestCase;

class SingleValueParserTest extends TestCase
{
    public function testCanSetRawValue()
    {
        $value = "string";
        $i = $this->createInstance();
        $i->setRaw($value);
        $this->assertEquals($i->getRaw(), $value);
    }

    public function testGetValueReturnsSame()
    {
        $i = $this->createInstance();
        $i->setRaw(rand(1, 500));
        $this->assertEquals($i->getRaw(), $i->getValue());
    }

    public function createInstance()
    {
        return new SingleValueParser();
    }
}