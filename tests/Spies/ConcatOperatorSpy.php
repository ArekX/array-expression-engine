<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests\Spies;

use ArekX\ArrayExpression\Operators\ConcatOperator;

class ConcatOperatorSpy extends ConcatOperator
{
    public function getParser()
    {
        return $this->parser;
    }

    public function getConcatOperators()
    {
        return $this->concatOperators;
    }
}