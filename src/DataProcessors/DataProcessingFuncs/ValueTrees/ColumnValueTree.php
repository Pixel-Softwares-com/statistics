<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\ValueTrees;

use Statistics\DataProcessors\DataProcessingFuncs\TreeRuleDeterminers\ColumnValueTreeRuleDeterminer;
use Statistics\DataProcessors\DataProcessingFuncs\TreeRuleDeterminers\TreeRuleDeterminer;
use Statistics\DataProcessors\DataProcessingFuncs\ValueTreeNodes\ColumnValueTreeNode;
use Statistics\DataProcessors\DataProcessingFuncs\ValueTreeNodes\ValueTreeNode;

class ColumnValueTree extends ValueTree
{
    protected function getTreeRuleDeterminer(array $values) : TreeRuleDeterminer
    {
        return new ColumnValueTreeRuleDeterminer($values);
    }

    protected function getClonedTreeNodes() : array
    {
        $clonedNodes = [];
        /**  @var ValueTreeNode $treeOldParents */
        foreach ($this->treeNodes as $childNode)
        {
            $clonedNodes[] = clone $childNode;
        }
        return $clonedNodes;
    }

    /**
     * @todo why this method is empty
     */
    protected function setParentChildNodes(ColumnValueTreeNode $parentNode  ) : void
    {

    }
    protected function initTreeNode(string $GroupedByColumnAlias , mixed $value  ) : ValueTreeNode
    {
        $parentNode = new ColumnValueTreeNode($GroupedByColumnAlias , $value);
        $parentNode->setChildNodes($this->treeNodes);
        return $parentNode;
    }

    protected function initTreeParentNodes(string $GroupedByColumnAlias , array $values  ):array
    {
        $nodes = [];
        foreach ($values as $value)
        {
            $nodes[] = $this->initTreeNode($GroupedByColumnAlias , $value );
        }
        return $nodes;
    }

    protected function setTreeNodes() : void
    {
        foreach ($this->values as  $GroupedByColumnAlias => $values)
        {
            $this->treeNodes = $this->initTreeParentNodes($GroupedByColumnAlias , $values );
        }
    }

    public function toArray() : array
    {
        $result = [];
        /**
         * @var ColumnValueTreeNode $node
         */
        foreach ($this->treeNodes as $node)
        {
            $result =  array_merge($result , $node->toArray());
        }
        return $result;
    }

}
