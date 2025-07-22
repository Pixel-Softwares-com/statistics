<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\TreeRuleDeterminers;

class ColumnValueTreeRuleDeterminer extends TreeRuleDeterminer
{
    public function getMaxElementLength() : int
    {
        return 20;
    }

    protected function setValidValueRow(string $columnAlias , array $values) : void
    {
        $length = $this->getEachLevelAllowedElementLength();
        if($length < 0) { $length = null;}

        $this->treeValues[$columnAlias] = array_slice( $values, 0 , $length);
    }

    protected function setValidValueRows() : void
    {
        foreach ($this->treeValues as $columnAlias => $values)
        {
            $this->setValidValueRow($columnAlias , $values);
        }
    }

    protected function setValuesAssocArray() : void
    {
        $assocArray = [];
        foreach ($this->treeValues as $column)
        {
            $assocArray[$column->getResultProcessingColumnAlias()] 
            =
            $column->getProcessingRequiredValues();
        }

        $this->treeValues = $assocArray;
    }

    public function setValidValuesArray(): void
    {
        $this->setValuesAssocArray();
        $this->setEachLevelAllowedElementLength();
        $this->setValidValueRows();
    }

    protected function getCurrentTreeDepth() : int
    {
        return count($this->treeValues);
    }
    
    public function setOldTreeDepth() : void
    {
        $this->oldTreeDepth =  $this->getCurrentTreeDepth();
    }

    public function setNewTreeDepth() : void
    {
        $this->newTreeDepth =  $this->getCurrentTreeDepth();
    }

    protected function getValuesIndexedArray() : array
    {
        $keyValueArray = [];
        foreach ($this->treeValues as $columnAlias => $values)
        {
            $keyValueArray[] = $values;
        }
        return $keyValueArray;
    }

    public function getCurrentTreeElementCount() : int
    {
        $AllValues = $this->getValuesIndexedArray();
        $count = 0;
        $CalculationIncludedArrayIndex  = 0;
        $valuesCount = count($this->treeValues);

        foreach ($AllValues as $values)
        {
            $ValueArraysCountCrossing = 1;

            for($i=0;$i< $valuesCount - $CalculationIncludedArrayIndex ;$i++)
            {
                /**
                 * @todo to check later ... why  count($AllValues[$i]); not count($values);
                 */
                $ValueArraysCountCrossing *= count($AllValues[$i]);
            }
            $CalculationIncludedArrayIndex++;
            $count += $ValueArraysCountCrossing;
        }
        return $count;
    }
    protected function setOldTreeElementCount(): void
    {
        $this->oldTreeElementCount = $this->getCurrentTreeElementCount();
    }
    protected function setNewTreeElementCount(): void
    {
        $this->newTreeElementCount = $this->getCurrentTreeElementCount();
    }

}
