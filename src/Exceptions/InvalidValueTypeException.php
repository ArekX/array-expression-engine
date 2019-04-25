<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Exceptions;

class InvalidValueTypeException extends \Exception
{
    public function __construct($value)
    {
        $value = print_r($value, true);
        parent::__construct("Invalid value type: " . $value, 0, null);
    }
}