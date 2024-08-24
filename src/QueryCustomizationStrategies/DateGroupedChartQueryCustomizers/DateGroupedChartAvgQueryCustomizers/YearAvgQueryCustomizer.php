<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers;

class YearAvgQueryCustomizer extends DateGroupedChartAvgQueryCustomizer
{

    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "avg(" . $column .")  as " . $alias . " , year(" . $dateColumnName .") as " . $dateColumnAlias;
    }
}
