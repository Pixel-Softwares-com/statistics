<?php

namespace Statistics\DataResources;


use Statistics\DataProcessors\DataProcessor;
use Statistics\DateProcessors\DateProcessor;
use Statistics\OperationsManagement\OperationTempHolders\DataResourceOperationsTempHolder;
use Statistics\OperationsManagement\OperationTempHolders\OperationsTempHolder;


abstract class DataResource
{

    protected array $statistics = [];
    protected ?DataResourceOperationsTempHolder $operationsTempHolder = null;
    protected ?DataProcessor $dataProcessor = null;
    protected ?DateProcessor $dateProcessor = null;

    /**
     *
     * @param DataResourceOperationsTempHolder $operationsTempHolder
     * @return $this
     */
    public function setOperationsTempHolder(DataResourceOperationsTempHolder $operationsTempHolder): DataResource
    {
        $this->operationsTempHolder = $operationsTempHolder;
        return $this;
    }

    static public function getAcceptedOperationTempHolderClass(): string
    {
        return OperationsTempHolder::class;
    }

    /**
     * @param DataProcessor|null $dataProcessor
     * @return $this
     */
    public function setDataProcessor(?DataProcessor $dataProcessor = null): DataResource
    {
        $this->dataProcessor = $dataProcessor;
        return $this;
    }

    /**
     * @param DateProcessor|null $dateProcessor
     * @return $this
     */
    public function setDateProcessor(?DateProcessor $dateProcessor = null): DataResource
    {
        $this->dateProcessor = $dateProcessor;
        return $this;
    }

    abstract protected function setStatistics() : void;

    public function getStatistics() : array
    {
        $this->setStatistics();
        return $this->statistics;
    }
}
