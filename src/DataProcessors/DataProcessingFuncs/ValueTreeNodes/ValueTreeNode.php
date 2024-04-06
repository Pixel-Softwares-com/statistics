<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\ValueTreeNodes;

use Statistics\DataProcessors\DataProcessingFuncs\ValueTreeNodes\Traits\Getters;
use Statistics\DataProcessors\DataProcessingFuncs\ValueTreeNodes\Traits\Setters;

abstract class ValueTreeNode
{
    use Setters , Getters;

    protected string $key;
    protected mixed $value;
    protected array $childNodes = [];
    protected bool $isParentNode = true;

    abstract public function toArray() : array;


    public function __construct(string $key , mixed $value)
    {
        $this->setKey($key)->setValue($value);
    }
}
