<?php

namespace Statistics\DataProcessors\ValueTreeNodes\Traits;

trait Getters
{

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function getChildNodes(): array
    {
        return $this->childNodes;
    }

}
