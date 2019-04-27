<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Interfaces;

/**
 * Interface ValueHandler
 * Value handler for resolving values into parsers.
 *
 * @package ArekX\ArrayExpression\Interfaces
 */
interface ValueHandler
{
    /**
     * @param mixed $value Value to be loaded.
     */
    public function loadValue($value);

    /**
     * Returns one Value parser value or a whole generator to iterate against.
     * @return \Generator
     */
    public function getParsers();
}