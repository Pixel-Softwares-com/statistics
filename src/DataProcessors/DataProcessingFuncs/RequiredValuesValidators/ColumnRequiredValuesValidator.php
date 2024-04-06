<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\RequiredValuesValidators;

use Statistics\DataProcessors\DataProcessingFuncs\ValueTrees\ColumnValueTree;
use Statistics\DataProcessors\DataProcessingFuncs\ValueTrees\ValueTree;

class ColumnRequiredValuesValidator extends RequiredValuesValidator
{

    protected function getValueTreeInstance($requiredValues) : ValueTree
    {
        return new ColumnValueTree($requiredValues);
    }
}
