<?php

namespace Statistics\QueryCustomizationStrategies\QueryCustomizationGlobalStrategies;


use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;

class SumQueryCustomizer extends QueryCustomizationStrategy
{

    protected function getOperationSqlString(string $column , string $alias) : string
    {
        return "sum(" . $column . ") as " . $alias;
    }
}
