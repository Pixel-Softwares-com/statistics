<?php

namespace Statistics\DataResources;


use Statistics\DataProcessors\DataProcessor;
use Statistics\DateProcessors\DateProcessor;
use Statistics\OperationsManagement\OperationTempHolders\DataResourceOperationsTempHolder;


abstract class DataResource
{

    protected array $statistics = [];
    protected DataResourceOperationsTempHolder $operationsTempHolder;
    protected DataProcessor $dataProcessor;
    protected ?DateProcessor $dateProcessor = null;


    public function __construct(DataResourceOperationsTempHolder $operationsTempHolder , DataProcessor $dataProcessor , ?DateProcessor $dateProcessor = null)
    {
        $this->setOperationsTempHolder($operationsTempHolder)->setDataProcessor($dataProcessor)->setDateProcessor($dateProcessor);
    }
    /**
     * @param DataResourceOperationsTempHolder $operationsTempHolder
     * @return $this
     */
    public function setOperationsTempHolder(DataResourceOperationsTempHolder $operationsTempHolder): DataResource
    {
        $this->operationsTempHolder = $operationsTempHolder;
        return $this;
    }

    /**
     * @param DataProcessor $dataProcessor
     * @return $this
     */
    public function setDataProcessor(DataProcessor $dataProcessor): DataResource
    {
        $this->dataProcessor = $dataProcessor;
        return $this;
    }

    /**
     * @param DateProcessor|null $dateProcessor
     * @return $this
     */
    public function setDateProcessor(?DateProcessor $dateProcessor): DataResource
    {
        $this->dateProcessor = $dateProcessor;
        return $this;
    }

    abstract static public function getAcceptedOperationTempHolderClass() : string;
    abstract protected function setStatistics() : void;

    public function getStatistics() : array
    {
        $this->setStatistics();
        return $this->statistics;
    }
}
