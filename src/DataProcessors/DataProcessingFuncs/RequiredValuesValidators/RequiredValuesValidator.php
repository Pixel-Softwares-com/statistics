<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\RequiredValuesValidators;

use Statistics\DataProcessors\DataProcessingFuncs\ValueTrees\ValueTree;

abstract class RequiredValuesValidator
{
    protected array $dataToCheck = [];
    protected array $missedDataRows = [];
    protected ?ValueTree $valueTree = null;

    abstract protected function getValueTreeInstance($requiredValues) : ValueTree;

    protected function isMissedRow(array $treeBranch) : bool
    {
        $missing = true;
        foreach ($this->dataToCheck as $row)
        {
            $intersectArray = array_intersect_assoc($treeBranch , $row );
            if(count($intersectArray) == count($treeBranch))
            {
                /** It is found in data and not missing , and no need to continue in looping data rows*/
                $missing = false;
                break;
            }
        }
        return $missing;
    }
    /**
     * @return $this
     */
    protected function setMissedRequiredDataRows(): RequiredValuesValidator
    {
        foreach ($this->valueTree->toArray() as $treeBranch)
        {
            if($this->isMissedRow($treeBranch))
            {
                $this->missedDataRows[] = $treeBranch;
            }
        }
        return $this;
    }

    
    public function getMissedDataRows() : array
    {
        return $this->missedDataRows;
    }

    /**
     * @param array $requiredValues
     * @return $this
     */
    protected function setValueTree(array $requiredValues): RequiredValuesValidator
    {
        $this->valueTree = $this->getValueTreeInstance($requiredValues);
        
        return $this;
    }
    /**
     * @param array $requiredValues
     * @return $this
     */
    protected function setRequiredValuesToCheck(array $requiredValues): RequiredValuesValidator
    {
        return $this->setValueTree($requiredValues)->setMissedRequiredDataRows();
    }

    /**
     * @param array $dataToCheck
     * @return $this
     */
    protected function setDataToCheck(array $dataToCheck): RequiredValuesValidator
    {
        $this->dataToCheck = $dataToCheck;
        return $this;
    }

    public function __construct(array $dataToCheck = [] , array $requiredValues = [])
    {
        $this->setDataToCheck($dataToCheck)->setRequiredValuesToCheck($requiredValues);
    }


}
