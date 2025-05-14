<?php

namespace DataResourceInstructors\OperationContainers;

use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereCallbackComponents\WhereCallbackComponent;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionGroups\AndWhereConditionGroup;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionGroups\WhereConditionGroup;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereCondition;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereMethod;
use DataResourceInstructors\OperationComponents\Ordering\OrderingTypes;
use DataResourceInstructors\OperationContainers\Traits\HasSelectingNeededColumns;
use DataResourceInstructors\OperationTypes\AggregationOperation;

abstract class OperationContainer
{
    use HasSelectingNeededColumns;

    protected array $whereCallbackComponents = [];
    protected array $whereMethods = [];
    /**
     * @var array
     * An Array Of WhereCondition Objects
     */
    protected array $whereConditionGroups = [];
    /**
     * @var WhereConditionGroup|null
     * Will Be An Container for all single where conditions
     */
    protected ?WhereConditionGroup $defaultWhereConditionGroup = null;

    protected array $groupedByColumnAliases = [];

    /**
     * @var array
     * It Is an array of GroupingByColumn Column Objects
     */
    protected array $columnsForProcessingRequiredValues = [];
    protected string $tableName = "";
    protected array $operations = [];
    /**
     * @var array
     * Must Be Like
     * [ "column" => "ordering type constant ]
     */
    protected array $orderingColumns = [];

    /**
     * @return array
     */
    public function getOrderingColumns(): array
    {
        return $this->orderingColumns;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }


    /**
     * @return void
     */
    protected function setDefaultWhereConditionGroup(): void
    {
        if(!$this->defaultWhereConditionGroup)
        {
            /** There Is No Need To Set Table Name .... Because it is set during adding the conditions */
            $this->defaultWhereConditionGroup = AndWhereConditionGroup::create();
            $this->whereConditionGroups[] = $this->defaultWhereConditionGroup;
        }
    }

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->setDefaultWhereConditionGroup();
    }

    /**
     * @return array
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * @param AggregationOperation $operation
     * @return $this
     * adding operation from class scope doesn't need to any processing
     */
    protected function mergeOperation(AggregationOperation $operation) : OperationContainer
    {
        $this->operations[] = $operation;
        return $this;
    }

    /**
     * @param array $operations
     * @return OperationContainer
     * adding operation from class scope doesn't need to any processing
     */
    protected function mergeOperations(array $operations) : OperationContainer
    {
        foreach ($operations as $operation)
        {
            if($operation instanceof AggregationOperation)
            {
                $this->mergeOperation($operation);
            }
        }
        return $this;
    }

    /**
     * @param AggregationOperation $operation
     * @return $this
     * adding operation from global scope needs to some processing (like adding table name)
     */
    public function addOperation(AggregationOperation $operation) : OperationContainer
    {
        $operation->setTableName($this->tableName);
        $this->mergeOperation($operation);
        return $this;
    }

    /**
     * @param array $operations
     * @return OperationContainer
     * adding operations from global scope needs to some processing (like adding table name)
     */
    public function setOperations(array $operations): OperationContainer
    {
        foreach ($operations as $operation)
        {
            if($operation instanceof AggregationOperation)
            {
                $this->addOperation($operation);
            }
        }
        return $this;
    }

    protected function ColumnRequiredValuesProcessingHandling(GroupingByColumn $column) : void
    {
        if(!empty($column->getProcessingRequiredValues()))
        {
            $this->columnsForProcessingRequiredValues[] = $column;
        }
    }
    
    protected function ColumnSelectingAndGroupingFunc(GroupingByColumn $column) : void
    {
        $column->setTableName($this->tableName);
        $this->groupedByColumnAliases[] = $column->getResultProcessingColumnAlias();
        $this->addSelectingNeededColumn($column);
    }
    /**
     * @param GroupingByColumn $column
     * @return $this
     */
    public function groupedByColumn( GroupingByColumn $column): OperationContainer
    {
        /**
         * All keys Are Found in $this->groupedByColumns array Will Be Aliases Of The Grouped Columns
         * Because Those Columns Will Be Selected Named By Alias While Selecting The Needed Columns
         */
        $this->ColumnSelectingAndGroupingFunc($column);
        $this->ColumnRequiredValuesProcessingHandling($column);
        return $this;
    }

    protected function mergeGroupedByColumnAliases(array $groupedByColumnAliases) : OperationContainer
    {
        /**
         * * For Merging Grouped By Columns Of Another Object
         *
         * There Is No Need To Get The Column (( If it Is Selected As Needed Column named by  $labelProcessingKey 's value )
         * So We Kept This Method Protected to make sure about that
         */
        $this->groupedByColumnAliases = $this->groupedByColumnAliases + $groupedByColumnAliases;
        return $this;
    }

    protected function mergeColumnsForProcessingRequiredValues(array $columnsForProcessingRequiredValues) : OperationContainer
    {

        $this->columnsForProcessingRequiredValues = $this->columnsForProcessingRequiredValues + $columnsForProcessingRequiredValues;
        return $this;
    }

    /**
     * @return array
     */
    public function getColumnsForProcessingRequiredValues(): array
    {
        return $this->columnsForProcessingRequiredValues;
    }

    /**
     * @return array
     */
    public function getGroupedByColumnAliases(): array
    {
        return $this->groupedByColumnAliases;
    }

    protected function processOrderingStyle(string $orderingStyleConstant = "") : string
    {
        if(
            !$orderingStyleConstant
            ||
            !in_array($orderingStyleConstant,OrderingTypes::ORDERING_STYLES )
        )
        {
            $orderingStyleConstant = OrderingTypes::ASC_ORDERING;
        }
        
        return $orderingStyleConstant;
    }

    protected function getOrderingColumnAlias(Column $column) : string
    {
        return $column->getResultProcessingColumnAlias() ?? $column->getColumnFullName();
    }

    public function orderBy(Column $column , string $orderingStyleConstant = "") : OperationContainer
    {
        $column->setTableName($this->tableName);
        $this->orderingColumns[$this->getOrderingColumnAlias($column)] = $this->processOrderingStyle($orderingStyleConstant);
        return $this;
    }

    /**
     * @param array $orderingColumns
     * @return $this
     *
     * For Merging Ordering By Columns Of Another Object
     */
    protected function mergeOrderByColumns(array $orderingColumns) : OperationContainer
    {
        $this->orderingColumns = $this->orderingColumns + $orderingColumns;
        return $this;
    }

    /**
     * @param WhereCondition $condition
     * @return $this
     *
     * For QueryOperationGroup : These Conditions Will Be Attached On The Query .
     * For RelationshipLoader :  These Conditions Will Be Attached On The Join Conditions As Additional Conditions.
     */
    public function where(WhereCondition $condition) : OperationContainer
    {
        $this->setDefaultWhereConditionGroup();

        $condition->setTableName($this->tableName);
        $this->defaultWhereConditionGroup->addWhereCondition($condition);
        return $this;
    }
    /**
     * @param WhereMethod $whereMethod
     * @return $this
     *
     * For QueryOperationGroup : These Conditions Will Be Attached On The Query .
     * For RelationshipLoader :  These Conditions Will Be Attached On The Join Conditions As Additional Conditions.
     */
    public function whereByMethod(WhereMethod $whereMethod) : OperationContainer
    {
        $whereMethod->setTableName($this->tableName);
        $this->whereMethods[] = $whereMethod;
        return $this;
    }

    /**
     * @return array
     */
    public function getWhereMethods(): array
    {
        return $this->whereMethods;
    }

    public function whereByCallback(WhereCallbackComponent $whereCallback) : OperationContainer
    {
        $this->whereCallbackComponents[] = $whereCallback;
        return $this;
    }

    public function getWhereCallbackComponents() : array
    {
        return $this->whereCallbackComponents;
    }

    public function whereConditionGroup(WhereConditionGroup $conditionGroup) : OperationContainer
    {
        $conditionGroup->setTableName($this->tableName);
        $this->whereConditionGroups[] =  $conditionGroup;
        return $this;
    }
    public function getWhereConditionGroups()  :array
    {
        return $this->whereConditionGroups;
    }
}
