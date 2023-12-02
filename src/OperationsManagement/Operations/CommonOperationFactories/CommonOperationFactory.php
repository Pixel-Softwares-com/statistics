<?php

namespace Statistics\Operations\CommonOperationFactories;

use Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class CommonOperationFactory
{
    protected ?Model $model = null;
    protected string $tableName = "";
    protected string $AggregationResultLabel = "";
    protected string $countedKeyName = "";
    protected ?Column $dateColumn = null;


    /**
     * @param Model $model
     * @return void
     *
     * Only ModelProvidesStatistics instance will be accepted but in the same time it must be a Model implementing the  desired interface
     */
    public function setModel( Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @param string $modelClass
     * @return $this
     * @throws Exception
     */
    protected function initModel(string $modelClass) : CommonOperationFactory
    {
        $model = new $modelClass;

        if(!$model instanceof Model)
        {
            throw new Exception("The Given Class " . $modelClass . " Is Not A Model Class");
        }
        $this->setModel($model);
        return $this;
    }

    /**
     * @param string|Model $modelClass
     * @return $this
     * @throws Exception
     * Only ModelProvidesStatistics instance will be accepted but in the same time it must be a Model implementing the  desired interface
     */
    public function forModel(string | Model $modelClass) : CommonOperationFactory
    {
        if($modelClass instanceof Model)
        {
            $this->setModel($modelClass);
            return $this;
        }
        return $this->initModel($modelClass);
    }

    public function setAggregationColumnResultLabel(string $labelString) : CommonOperationFactory
    {
        $this->AggregationResultLabel = $labelString;
        return $this;
    }

    /**
     * @return string
     */
    public function getAggregationResultLabel(): string
    {
        return $this->AggregationResultLabel;
    }

    /**
     * @param string $tableName
     * @return $this
     */
    public function setTableName(string $tableName): CommonOperationFactory
    {
        $this->tableName = $tableName;
        return $this;
    }


    public function getTableTitle(string $tableName): string
    {
        $tableName = Str::replace("_", " ", $tableName);
        return Str::title($tableName);
    }
    /**
     * @return string
     * @throws Exception
     */
    protected function getTableNameConveniently() : string
    {
        if($this->tableName){return $this->tableName;}
        if($this->model){return $this->model->getTable();}
        throw new Exception("No Table Name Or Model Is Set !");
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getTableTitleConveniently() : string
    {
        $tableName = $this->getTableNameConveniently();
        return $this->getTableTitle($tableName);
    }

    /**
     * @param string $countedKeyName
     * @return $this
     */
    public function setCountedKeyName(string $countedKeyName): CommonOperationFactory
    {
        $this->countedKeyName = $countedKeyName;
        return $this;
    }
    protected function getDefaultCountedKeyName() : string
    {
        return "id";
    }

    protected function getCountedKeyNameConveniently() : string
    {
        if($this->countedKeyName){return $this->countedKeyName;}
        if($this->model){return $this->model->getKeyName();}
        return $this->getDefaultCountedKeyName();
    }

    /**
     * @param Column|null $dateColumn
     * @return $this
     */
    public function setDateColumn(?Column $dateColumn): CommonOperationFactory
    {
        $this->dateColumn = $dateColumn;
        return $this;
    }

    protected function getDefaultDateColumnName() : string
    {
        return "created_at";
    }
    /**
     * @return Column
     */
    public function getDateColumnConveniently(): Column
    {
        if($this->dateColumn){return $this->dateColumn;}
        if($this->model instanceof StatisticsProviderModel)
        {
            Column::create( $this->model->getStatisticDateColumnName() );
        }
        return Column::create($this->getDefaultDateColumnName());
    }
    public function __construct()
    {

    }
    abstract public function make() : OperationGroup;
}
