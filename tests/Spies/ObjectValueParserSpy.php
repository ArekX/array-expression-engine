<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Spies;

use ArekX\ArrayExpression\ValueParsers\ObjectValueParser;

class ObjectValueParserSpy extends ObjectValueParser
{
    public function getValueCache()
    {
        return $this->valueCache;
    }
}