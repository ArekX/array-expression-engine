<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression;

use ArekX\ArrayExpression\Interfaces\ValueParser;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use ArekX\ArrayExpression\ValueParsers\ObjectValueParser;
use ArekX\ArrayExpression\ValueParsers\SingleValueParser;

/**
 * Class Evaluator
 *
 * Class which performs evaluation of arrays against passed values.
 *
 * @package ArekX\ArrayExpression
 */
class Evaluator
{
    /**
     * Expression parser used.
     *
     * @var null|ExpressionParser
     */
    protected $expressionParser = null;

    /**
     * Value Parser used for value retrieval.
     *
     * @var ValueParser
     */
    protected $valueParser;

    /**
     * Evaluator constructor.
     * @param null|ExpressionParser $expressionParser Parser which will be used to parse array expression.
     */
    public function __construct($expressionParser = null)
    {
        $this->expressionParser = $expressionParser;
    }

    /**
     * Creates new instance of an evaluator.
     *
     * @param null|ExpressionParser $expressionParser Parser which will be used to parse array expression.
     * @return static
     */
    public static function create($expressionParser = null)
    {
        return new static($expressionParser);
    }

    /**
     * Run performs evaluation of expression against a value.
     *
     * @param array $expression Expression which will be used
     * @param mixed $value Value which will be used.
     * @return mixed
     * @throws Exceptions\TypeNotMappedException
     * @throws Exceptions\InvalidValueTypeException
     */
    public function run(array $expression, $value)
    {
        return $this->getExpressionParser()
            ->parse($expression)
            ->evaluate($this->determineValueParser($value));
    }

    /**
     * Determines Value Parser from a value.
     *
     * @param mixed $value
     * @return ValueParser|ArrayValueParser|ObjectValueParser|SingleValueParser
     * @throws Exceptions\InvalidValueTypeException
     */
    protected function determineValueParser($value)
    {
        $valueParser = $this->valueParser;

        if (is_array($value)) {
            if (!($this->valueParser instanceof ArrayValueParser)) {
                $valueParser = $this->valueParser = new ArrayValueParser();
            }

            $valueParser->setRaw($value);
            return $valueParser;
        }

        if (is_object($value)) {
            if (!($this->valueParser instanceof ObjectValueParser)) {
                $valueParser = $this->valueParser = new ObjectValueParser();
            }

            $valueParser->setRaw($value);
            return $valueParser;
        }

        if (!($valueParser instanceof SingleValueParser)) {
            $valueParser = $this->valueParser = new SingleValueParser();
            $valueParser->setRaw($value);
        }

        return $valueParser;
    }

    /**
     * Returns expression parser.
     *
     * @return ExpressionParser
     */
    public function getExpressionParser()
    {
        if ($this->expressionParser === null) {
            $this->expressionParser = new DefaultExpressionParser();
        }

        return $this->expressionParser;
    }
}