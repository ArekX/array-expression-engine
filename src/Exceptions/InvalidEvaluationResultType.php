<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Exceptions;

class InvalidEvaluationResultType extends \Exception
{
    public $result;

    public function __construct($result, $expectedType)
    {
        $this->result = $result;
        parent::__construct("Expected result type '{$expectedType}'. Got type: " . print_r($result, true), 0, null);
    }
}