<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\ValueTreeNodes;

class ColumnValueTreeNode extends ValueTreeNode
{

    protected function getCurrentNodeProps() : array
    {
        return  [$this->getKey() => $this->getValue()]  ;
    }

    protected function getChildNodePropArray(ColumnValueTreeNode $node) : array
    {
        $nodeProps = $node->toArray();
        foreach ($nodeProps as $index => $row)
        {
            $nodeProps[$index] = array_merge($this->getCurrentNodeProps() , $row);
        }
        return $nodeProps;
    }

    protected function getChildNodesPropArray() : array
    {
        $propArray = [];
        /**
         * @var ValueTreeNode $node
         */
        foreach ($this->childNodes as $node)
        {
            $propArray =  array_merge($propArray , $this->getChildNodePropArray($node));
        }
        return $propArray;
    }


    public function toArray() : array
    {
        /**
         *This Code For The Last child nodes in tree
         */
        if(empty($this->childNodes)
//            && !$this->isParentNode
        )
        {
            return  [$this->getCurrentNodeProps() ];
        }
//        if(empty($this->childNodes && $this->isParentNode))
//        {
//            return $this->getCurrentNodeProps();
//        }
        return $this->getChildNodesPropArray();

    }
}
