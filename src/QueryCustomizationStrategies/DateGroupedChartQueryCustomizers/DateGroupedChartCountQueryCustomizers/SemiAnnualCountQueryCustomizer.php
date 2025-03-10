<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers;


class SemiAnnualCountQueryCustomizer extends DateGroupedChartCountQueryCustomizer
{
    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();

        return "count(" . $column . ") as " . $alias .
            " , concat( if( month(" . $dateColumnName . ") <= 6, 'H1', 'H2') , '-' , year(" . $dateColumnName . ") ) as " . $dateColumnAlias;

    }
}
