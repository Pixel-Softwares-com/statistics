<?php

namespace Statistics\QueryCustomizationStrategies\QueryCustomizationGlobalStrategies;


use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;

class AverageQueryCustomizer extends QueryCustomizationStrategy
{

    protected function getOperationSqlString(string $column , string $alias) : string
    {
        return "avg(" . $column . ") as " . $alias;
    }

}
