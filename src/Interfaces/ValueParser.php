<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Interfaces;

/**
 * Interface ValueParser
 * @package ArekX\ArrayExpression\Interfaces
 *
 * Interface which can be sent to evaluator to parse values.
 */
interface ValueParser
{
    /**
     * Sets raw value to be parsed.
     *
     * @param mixed $rawValue Raw Value to be parsed.
     * @return mixed
     */
    public function setRaw($rawValue);

    /**
     * Returns raw value.
     * @return mixed
     */
    public function getRaw();

    /**
     * Returns parsed value
     *
     * @param string $requestedName Requested name which will be resolved by value parser.
     * @param null $default Default value if requested name in value is not found.
     * @return mixed
     */
    public function getValue($requestedName = '', $default = null);
}