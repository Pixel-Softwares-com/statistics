<?php

namespace Statistics\DataResources\DBFetcherDataResources;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DBFetcherDataResources\Traits\Setters;
use Statistics\DataResources\DBFetcherDataResources\Traits\StatisticsProcessingMethods;
use Statistics\DateProcessors\DateProcessor;
use Statistics\OperationsManagement\OperationTempHolders\DataResourceOperationsTempHolder;
use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class DBFetcherDataResource extends DataResource
{
    use StatisticsProcessingMethods , Setters  ;

    protected Request $request;
    protected ?Builder $query = null;

    /**
     * @var array
     * Array Of QueryOperationGroup objects
     */
    protected array $OperationGroupsArray = [];


    abstract protected function getAggregationOpStrategy() : QueryCustomizationStrategy | null;

    /**
     * @return DBFetcherDataResource
     */
    protected function setOperationGroupsArray(): DBFetcherDataResource
    {
        $this->OperationGroupsArray = $this->operationsTempHolder?->getOperationGroups() ?? [];
        return $this;
    }

    public function setOperationsTempHolder(DataResourceOperationsTempHolder $operationsTempHolder): DataResource
    {
        parent::setOperationsTempHolder($operationsTempHolder);
        return $this->setOperationGroupsArray();
    }

    public function __construct()
    {
        $this->setRequest();
    }

}
