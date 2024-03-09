<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers;
class MonthAvgQueryCustomizer extends DateGroupedChartAvgQueryCustomizer
{

    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "avg(" . $column .")  as " . $alias ."  , concat( Year(" . $dateColumnName .") , '-' , month(" . $dateColumnName .") ) as " . $dateColumnAlias;
    }
}
