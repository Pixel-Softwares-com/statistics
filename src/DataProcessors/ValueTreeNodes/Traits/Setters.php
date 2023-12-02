<?php

namespace Statistics\DataProcessors\ValueTreeNodes\Traits;

use Statistics\DataProcessors\ValueTreeNodes\ValueTreeNode;

trait Setters
{
    public function behaviorAsParent() : ValueTreeNode
    {
        $this->isParentNode = true;
        return $this;
    }
    public function behaviorAsChild() : ValueTreeNode
    {
        $this->isParentNode = false;
        return $this;
    }

    public function addChildNode(ValueTreeNode $node) : ValueTreeNode
    {
        $this->childNodes[] = $node->behaviorAsChild();
        return $this;
    }

    public function setChildNodes(array $nodes = []) : ValueTreeNode
    {
        foreach ($nodes as $node)
        {
            $this->addChildNode($node);
        }
        return $this;
    }

    /**
     * @param string $key
     * @return ValueTreeNode
     */
    public function setKey(string $key): ValueTreeNode
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param mixed $value
     * @return ValueTreeNode
     */
    public function setValue(mixed $value): ValueTreeNode
    {
        $this->value = $value;
        return $this;
    }
}
