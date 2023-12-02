<?php

namespace Statistics\DataProcessors\ValueTrees;

use Statistics\DataProcessors\TreeRuleDeterminers\TreeRuleDeterminer;

abstract class ValueTree
{
    protected array $values = [];
    protected array $treeNodes = [];
    protected TreeRuleDeterminer $treeRuleDeterminer;

    abstract protected function setTreeNodes() : void;
    abstract protected function getTreeRuleDeterminer(array $values) : TreeRuleDeterminer;
    abstract public function toArray() : array;


    protected function setValues() : ValueTree
    {
        /**
         * To Change Values Array Depending on treeDepth and elementsCount to avoid getting a complex tree which
         * will make the performance slower
         */
        $this->values = $this->treeRuleDeterminer->getValidValuesArray();
        return $this;
    }

    public function setTreeRuleDeterminer(array $values): void
    {
        $this->treeRuleDeterminer = $this->getTreeRuleDeterminer($values);
    }

    public function __construct(array $values)
    {
        $this->setTreeRuleDeterminer($values);
        $this->setValues();

        /** Start to make The required value tree */
        $this->setTreeNodes();
    }
    public function getTreeDepth() : int
    {
        return $this->treeRuleDeterminer->getNewTreeDepth();
    }
    public  function getElementsCount() : int
    {
        return $this->treeRuleDeterminer->getNewTreeElementCount();
    }

    public  function getTreeNodes() : array
    {
        return $this->treeNodes;
    }
}
