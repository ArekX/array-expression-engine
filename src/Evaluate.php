<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression;

use ArekX\ArrayExpression\Interfaces\ValueParser;
use ArekX\ArrayExpression\ValueParsers\ArrayValueParser;
use ArekX\ArrayExpression\ValueParsers\SingleValueParser;
use ArekX\ArrayExpression\ValueParsers\ObjectValueParser;

/**
 * Class Evaluate
 * @package ArekX\ArrayExpression
 *
 * Main evaluator class for evaluating values from array expressions.
 */
class Evaluate
{
    const DEFAULT_PARSER_MAP = [
        'array' => ArrayValueParser::class,
        'object' => ObjectValueParser::class,
        '_' => SingleValueParser::class
    ];

    /**
     * Value parser used to retrieve the value.
     * @var null|ValueParser
     */
    protected $valueParser = null;

    /**
     * Value parser map.
     *
     * @var array|mixed|null
     */
    protected $parserMap = null;

    /**
     * Expression used to convert to operators to parse the value.
     *
     * @var array
     */
    protected $expression = [];

    /**
     * Evaluate constructor.
     *
     * @param array $expression Expression which will be used to evaluate values.
     * @param array $config Configuration for the evaluator itself.
     */
    protected function __construct(array $expression, array $config)
    {
        $this->expression = $expression;
        $this->valueParser = $config['valueParser'] ?? null;
        $this->parserMap = $config['parserMap'] ?? self::DEFAULT_PARSER_MAP;
    }

    /**
     * Returns new instance of the Evaluator based on passed config and expression.
     *
     * @param array $expression Expression which will be used to evaluate values.
     * @param array $config Configuration for the evaluator itself.
     * @return $this New instance of the evaluator
     */
    public static function from(array $expression = [], array $config = []): self
    {
        return new static($expression, $config);
    }

    /**
     * Sets value parser to parse values when executing the evaluator.
     *
     * If value parser is set explicitly it will not be determined when run is called.
     *
     * @param $parser
     */
    public function setValueParser($parser)
    {
        $this->valueParser = $parser;
    }

    /**
     * Determines value parser class based on the value.
     *
     * @param mixed $value Value to be parsed.
     * @return string Value parser class
     */
    protected function determineValueParserClass($value)
    {
        if (is_array($value)) {
            return $this->parserMap['array'] ?? $this->parserMap['_'];
        }

        if (is_object($value)) {
            return $this->parserMap['object'] ?? $this->parserMap['_'];
        }

        return $this->parserMap['_'];
    }

    /**
     * Runs the current expression against a value and returns a result.
     *
     * If a value parser is not set using $configuration from a constructor or
     * by calling Evaluate::setValueParser(), one will be determined based on the value type.
     *
     * Determining value parser is done only once.
     *
     * @param mixed $value Value to be parsed
     * @return mixed
     */
    public function run($value)
    {
        if ($this->valueParser === null) {
            $parserClass = $this->determineValueParserClass($value);
            $this->valueParser = new $parserClass();
        }

        $this->valueParser->setRaw($value);
    }
}