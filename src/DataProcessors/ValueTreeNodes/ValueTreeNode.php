<?php

namespace Statistics\DataProcessors\ValueTreeNodes;

use Statistics\DataProcessors\ValueTreeNodes\Traits\Setters;
use Statistics\DataProcessors\ValueTreeNodes\Traits\Getters;

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
