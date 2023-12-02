<?php

namespace Statistics\DataProcessors\RequiredValuesValidators;

use Statistics\DataProcessors\ValueTrees\ColumnValueTree;
use Statistics\DataProcessors\ValueTrees\ValueTree;

class ColumnRequiredValuesValidator extends RequiredValuesValidator
{

    protected function getValueTreeInstance($requiredValues) : ValueTree
    {
        return new ColumnValueTree($requiredValues);
    }
}
