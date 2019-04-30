<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

use ArekX\ArrayExpression\Exceptions\InvalidEvaluationResultType;
use ArekX\ArrayExpression\Interfaces\Operator;
use ArekX\ArrayExpression\Interfaces\ValueParser;

/**
 * Class RegexOperator
 * Operator for handling comparisons.
 *
 * @package ArekX\ArrayExpression\Operators
 */
class RegexOperator extends BaseOperator
{
    /**
     * Value which will be taken from value parser.
     *
     * @var Operator
     */
    public $from;

    /**
     * @var Operator|string Regex result against which it will be matched.
     */
    public $match;

    /**
     * @inheritDoc
     */
    public function configure(array $config)
    {
        $this->setName($config[0] ?? 'unknown');

        if (count($config) <= 1) {
            throw new \InvalidArgumentException("Minimum format must be satisfied: ['{$this->getName()}', <expression>, '/pattern/']");
        }

        $this->assertIsExpression($config[1]);

        $this->match = $config[2];
        $this->from = $this->parser->parse($config[1]);

        if (is_array($this->match)) {
            $this->assertIsExpression($this->match);
            $this->match = $this->parser->parse($this->match);
        }
    }

    /**
     * @inheritDoc
     */
    public function evaluate(ValueParser $value)
    {
        $result = $this->from->evaluate($value);

        if (!is_string($result)) {
            throw new InvalidEvaluationResultType($result, 'string');
        }

        if (is_string($this->match)) {
            return (bool)preg_match($this->match, $result);
        }

        $matchResult = $this->match->evaluate($value);

        if (!is_string($matchResult)) {
            throw new InvalidEvaluationResultType($result, 'string');
        }

        return (bool)preg_match($matchResult, $result);
    }
}