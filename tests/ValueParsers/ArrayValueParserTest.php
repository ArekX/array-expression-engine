<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\ValueParsers;


use ArekX\ArrayExpression\Exceptions\InvalidValueTypeException;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use tests\mocks\ArrayValueParserSpy;
use tests\TestCase;

class ArrayValueParserTest extends TestCase
{
    public function testCanSetRawValue()
    {
        $i = $this->createInstance();
        $i->setRaw([]);
        $this->assertEquals($i->getRaw(), []);
    }

    public function testSettingNonArrayCausesAnException()
    {
        $i = $this->createInstance();

        $this->expectException(InvalidValueTypeException::class);
        $i->setRaw("");
    }

    public function testGetWholeArray()
    {
        $i = $this->createInstance();
        $value = ['key' => 'value'];
        $i->setRaw($value);
        $this->assertEquals($value, $i->getValue());
    }


    public function testGetSingleName()
    {
        $i = $this->createInstance();
        $value = ['key' => 'value'];
        $i->setRaw($value);
        $this->assertEquals($value['key'], $i->getValue('key'));
    }

    public function testTraversalSearch()
    {
        $i = $this->createInstance();
        $value = ['key' => ['key' => ['key' => ['key' => 'value']]]];
        $i->setRaw($value);
        $this->assertEquals($value['key']['key']['key']['key'], $i->getValue('key.key.key.key'));
    }

    public function testTraversalSearchCachesValue()
    {
        $i = $this->createInstance();
        $value = ['key' => ['key' => ['key' => ['key' => 'value']]]];
        $i->setRaw($value);
        $this->assertEquals($value['key']['key']['key']['key'], $i->getValue('key.key.key.key'));
        $this->assertEquals($i->getValue('key.key.key.key'), $i->getValueCache()['key.key.key.key']);
    }

    public function testInvalidTraversalSearchReturnsDefault()
    {
        $i = $this->createInstance();
        $value = ['key' => ''];
        $i->setRaw($value);
        $this->assertEquals('default value', $i->getValue('key.key.key.key', 'default value'));
    }

    public function testLastPartIsNotAnArray()
    {
        $i = $this->createInstance();
        $value = ['key' => ['key' => '']];
        $i->setRaw($value);
        $this->assertEquals(null, $i->getValue('key.key.key'));
    }

    public function testDefaultValueIsCached()
    {
        $i = $this->createInstance();
        $value = ['key' => ''];
        $i->setRaw($value);
        $this->assertEquals('default value', $i->getValue('key.key.key.key', 'default value'));
        $this->assertEquals('default value', $i->getValueCache()['key.key.key.key']);
    }

    public function createInstance()
    {
        return new ArrayValueParserSpy();
    }
}