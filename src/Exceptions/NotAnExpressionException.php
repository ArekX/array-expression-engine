<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Exceptions;

class NotAnExpressionException extends \Exception
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
        parent::__construct("Value must be a valid expression got: " . print_r($value, true), 0, null);
    }
}