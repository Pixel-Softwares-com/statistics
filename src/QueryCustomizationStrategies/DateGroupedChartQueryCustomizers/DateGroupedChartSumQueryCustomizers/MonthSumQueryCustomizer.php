<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers;

class MonthSumQueryCustomizer extends DateGroupedChartSumQueryCustomizer
{


    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "sum(" . $column .")  as " . $alias ."  , concat( Year(" . $dateColumnName .") , '-' , month(" . $dateColumnName .") ) as " . $dateColumnAlias;
    }
}
