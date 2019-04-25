<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\ValueParsers;


use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class BaseValueParser
 * @package ArekX\ArrayExpression\ValueParsers
 *
 * Base value parser which is used to handle common functionality.
 */
abstract class BaseValueParser implements ValueParser
{
    protected $raw;

    /**
     * @inheritDoc
     */
    public function setRaw($rawValue)
    {
        $this->raw = $rawValue;
    }

    /**
     * @inheritDoc
     */
    public function getRaw()
    {
        return $this->raw;
    }
}