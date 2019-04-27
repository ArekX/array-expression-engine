<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Exceptions;

class TypeNotMappedException extends \Exception
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
        parent::__construct("Type is not mapped: " . $type, 0, null);
    }
}