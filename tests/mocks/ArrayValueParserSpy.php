<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\mocks;


use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;

class ArrayValueParserSpy extends ArrayValueParser
{
    public function getValueCache()
    {
        return $this->valueCache;
    }
}