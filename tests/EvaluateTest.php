<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;


use ArekX\ArrayExpression\Evaluate;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use ArekX\ArrayExpression\ValueParsers\ObjectValueParser;
use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use tests\mocks\EvaluateMock;

class EvaluateTest extends TestCase
{
    public function testInitialization()
    {
        $instance = $this->createInstance();
        $this->assertInstanceOf(Evaluate::class, $instance);
    }

    public function testCreatesDefaultParserMap()
    {
        $i = $this->createInstance();
        $this->assertEquals(Evaluate::DEFAULT_PARSER_MAP, $i->getParserMap());
    }

    public function testInitialConfig()
    {
        $i = $this->createInstance();
        $this->assertEquals([], $i->config);
    }

    public function testInitialValueParserIsNull()
    {
        $i = $this->createInstance();
        $this->assertEquals(null, $i->getValueParser());
    }

    public function testValueParserDeterminesCorrectly()
    {
        $parsers = Evaluate::DEFAULT_PARSER_MAP;
        $i = $this->createInstance();

        $this->assertEquals($parsers['_'], $i->determineValueParserTestMethod(null));
        $this->assertEquals($parsers['array'], $i->determineValueParserTestMethod([]));
        $this->assertEquals($parsers['object'], $i->determineValueParserTestMethod(new \stdClass()));
    }

    public function testSettingValueParser()
    {
        $i = $this->createInstance();
        $valueParser = new SingleValueParser();
        $i->setValueParser($valueParser);

        $this->assertSame($valueParser, $i->getValueParser());
    }

    public function testCallingRunSetsValueParser()
    {
        $valueClasses = [
            SingleValueParser::class => "",
            ArrayValueParser::class => [],
            ObjectValueParser::class => new \stdClass()
        ];

        foreach ($valueClasses as $valueClass => $value) {
            $i = $this->createInstance();
            $i->run($value);
            $this->assertInstanceOf($valueClass, $i->getValueParser());
        }
    }


    public function testCallingRunSetsValueParserRaw()
    {
        $value = "raw value";
        $i = $this->createInstance();
        $i->setValueParser(new SingleValueParser());
        $i->run($value);
        $this->assertEquals($value, $i->getValueParser()->getRaw());
    }

    protected function createInstance($expression = [], $config = []): EvaluateMock
    {
        /** @var EvaluateMock $i */
        $i = EvaluateMock::from($expression, $config);
        return $i;
    }
}