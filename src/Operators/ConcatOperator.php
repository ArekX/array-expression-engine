<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;


use ArekX\ArrayExpression\Exceptions\InvalidEvaluationResultType;
use ArekX\ArrayExpression\Interfaces\ExpressionParser;
use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class ConcatOperator
 * Operator for returning concatenated strings
 *
 * @package ArekX\ArrayExpression\Operators
 */
class ConcatOperator extends BaseOperator
{
    /**
     * Expressions of which will be in concat operation.
     *
     * @var Operator[]
     */
    public $concatOperators = [];

    /**
     * Passes data from operator configuration.
     *
     * Depending on the operator this data can contain other sub-expressions which need to be parsed using
     * ExpressionParser
     *
     * @param array $config Expressions to be processed
     * @see ExpressionParser
     */
    public function configure(array $config)
    {
        $this->setName($config[0] ?? 'unknown');

        if (count($config) < 2) {
            throw new \InvalidArgumentException("Minimum format must be satisfied: ['{$this->getName()}', <expression>]");
        }

        $this->concatOperators = [];

        $maxCount = count($config);
        for ($i = 1; $i < $maxCount; $i++) {
            $this->assertIsExpression($config[$i]);
            $this->concatOperators[] = $this->parser->parse($config[$i]);
        }
    }

    /**
     * Evaluates one value.
     *
     * @param ValueParser $value Value to be evaluated
     * @return string Evaluation result
     * @throws InvalidEvaluationResultType
     */
    public function evaluate(ValueParser $value)
    {
        $result = "";
        foreach ($this->concatOperators as $operator) {
            $concatResult = $operator->evaluate($value);

            if (!is_string($concatResult)) {
                throw new InvalidEvaluationResultType($concatResult, 'string');
            }

            $result .= $concatResult;
        }

        return $result;
    }

}