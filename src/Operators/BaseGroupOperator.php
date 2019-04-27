<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\ArrayExpression\Operators;

use ArekX\ArrayExpression\Interfaces\Operator;

abstract class BaseGroupOperator extends BaseOperator
{
    /**
     * Expression configuration
     *
     * @var array
     */
    protected $config = [];

    /**
     * List of instanced operators
     *
     * @var Operator[]
     */
    protected $operators = [];
    /**
     * @inheritDoc
     */
    public function configure(array $config)
    {
        if (count($config) <= 1) {
            throw new \InvalidArgumentException('Config must have at least one sub operator.');
        }
        $this->config = $config;
    }
}