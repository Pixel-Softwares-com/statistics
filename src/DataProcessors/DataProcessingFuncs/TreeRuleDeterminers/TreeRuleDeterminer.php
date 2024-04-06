<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\TreeRuleDeterminers;

abstract class TreeRuleDeterminer
{
    protected array $treeValues = [];
    protected int $oldTreeDepth ;
    protected int $newTreeDepth = -1;
    protected int $oldTreeElementCount = -1;
    protected int $newTreeElementCount = -1;
    protected int $eachLevelAllowedElementLength = -1;

    abstract public function getMaxElementLength() : int ;
    abstract protected function setOldTreeDepth() : void;
    abstract protected function setNewTreeDepth() : void;
    abstract protected function setOldTreeElementCount() : void;
    abstract protected function setNewTreeElementCount() : void;
    abstract protected function setValidValuesArray(): void;

    /**
     * @return void
     * If its Value is null .... each column's all elements will be selected by array_slice (called in setValidTree array )
     */
    protected function setEachLevelAllowedElementLength() : void
    {
        $this->setOldTreeElementCount();
        $this->setOldTreeDepth();

        if($this->oldTreeElementCount > $this->getMaxElementLength())
        {
            $this->eachLevelAllowedElementLength = $this->getMaxElementLength() / $this->oldTreeDepth;
            return;
        }
        $this->eachLevelAllowedElementLength = -1;
    }

    public function getEachLevelAllowedElementLength() : int
    {
        return $this->eachLevelAllowedElementLength;
    }

    public function getValidValuesArray(): array
    {
        return $this->treeValues;
    }

    /**
     * @return int
     */
    public function getOldTreeDepth(): int
    {
        return $this->oldTreeDepth;
    }

    /**
     * @return int
     */
    public function getOldTreeElementCount(): int
    {
        return $this->oldTreeElementCount;
    }
    /**
     * @return int
     */
    public function getNewTreeDepth(): int
    {
        if($this->newTreeDepth < 0)
        {
            $this->setNewTreeDepth();
        }
        return $this->newTreeDepth;
    }
    /**
     * @return int
     */
    public function getNewTreeElementCount(): int
    {
        if($this->newTreeElementCount < 0)
        {
            $this->setNewTreeElementCount();
        }
        return $this->newTreeElementCount;
    }

    public function __construct(array $values)
    {
        $this->treeValues = $values;
        $this->setValidValuesArray();
    }


}
