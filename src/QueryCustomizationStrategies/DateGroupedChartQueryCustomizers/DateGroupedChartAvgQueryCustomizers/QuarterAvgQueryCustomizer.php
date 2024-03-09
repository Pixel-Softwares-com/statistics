<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers;

class QuarterAvgQueryCustomizer extends DateGroupedChartAvgQueryCustomizer
{
    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "avg(" . $column .")  as " . $alias ." , concat( Year(" . $dateColumnName .") , '-Q' , QUARTER(" . $dateColumnName .") ) as " . $dateColumnAlias;
    }
}
