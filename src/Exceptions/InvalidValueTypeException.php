<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Exceptions;

class InvalidValueTypeException extends \Exception
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
        parent::__construct("Invalid value type: " . print_r($value, true), 0, null);
    }
}