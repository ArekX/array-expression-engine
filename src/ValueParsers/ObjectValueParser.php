<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\ValueParsers;

use ArekX\ArrayExpression\Exceptions\InvalidValueTypeException;

/**
 * Class ObjectValueParser
 * Object value parser which parses objects via keys.
 *
 * @package ArekX\ArrayExpression\ValueParsers
 *
 */
class ObjectValueParser extends BaseValueParser
{
    protected $valueCache = [];

    /**
     * Sets raw array value to be parsed.
     *
     * @param mixed $rawValue Array value to be parsed
     * @throws InvalidValueTypeException Error which is thrown if raw value is not an array.
     */
    public function setRaw($rawValue)
    {
        if (!is_object($rawValue)) {
            throw new InvalidValueTypeException($rawValue);
        }

        $this->valueCache = [];
        parent::setRaw($rawValue);
    }

    /**
     * Returns parsed value by specified by $requested name.
     *
     * If a $requestedName is an empty string whole raw value is returned.
     * If a $requestedName is a string in dot notation then object will be traversed to find value from those keys.
     *
     * @param string $requestedName Requested key to be returned
     * @param mixed $default Default value to be returned if nothing is found.
     * @return mixed
     */
    public function getValue($requestedName = '', $default = null)
    {
        if ($requestedName === '') {
            return $this->raw;
        }

        if (array_key_exists($requestedName, $this->valueCache)) {
            return $this->valueCache[$requestedName];
        }

        if (is_object($this->raw) && property_exists($this->raw, $requestedName)) {
            return $this->raw->{$requestedName};
        }

        $parts = explode('.', $requestedName);
        $walker = $this->raw;

        $lastPart = array_pop($parts);

        foreach ($parts as $part) {
            if (is_object($walker) && property_exists($walker, $part)) {
                $walker = $walker->{$part};
                continue;
            }

            return $this->valueCache[$requestedName] = $default;
        }

        if (is_object($walker) && property_exists($walker, $lastPart)) {
            return $this->valueCache[$requestedName] = $walker->{$lastPart};
        }

        return $this->valueCache[$requestedName] = $default;
    }
}