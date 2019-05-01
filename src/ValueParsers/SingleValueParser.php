<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\ValueParsers;

/**
 * Class SingleValueParser
 * Single value parser which gets and only returns one raw value.
 *
 * @package ArekX\ArrayExpression\ValueParsers
 *
 */
class SingleValueParser extends BaseValueParser
{
    /**
     * Returns RAW value passed to this value parser.
     *
     * This parser ignores $requestedName and $default and always returns RAW value.
     *
     * @param string $requestedName (Ignored) Requested name to return value
     * @param mixed $default (Ignored) Default value to be returned if value is not found by requested name.
     * @return mixed
     */
    public function getValue($requestedName = '', $default = null)
    {
        return $this->raw;
    }
}