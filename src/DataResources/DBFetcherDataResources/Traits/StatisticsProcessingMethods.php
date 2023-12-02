<?php

namespace Statistics\DataResources\DBFetcherDataResources\Traits;

use Statistics\DataResources\DBFetcherDataResources\DBFetcherDataResource;
use DataResourceInstructors\OperationComponents\OperationConditions\AggregationConditions\HavingCondition;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionGroups\WhereConditionGroup;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereCondition;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationContainers\RelationshipLoaders\RelationshipLoader;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

trait StatisticsProcessingMethods
{
    protected OperationGroup $currentOperationGroup;
    protected ?AggregationOperation $currentOperation = null;

    protected function mergeProcessedData(array $data) : void
    {
        $this->statistics = $data + $this->statistics;
    }

    protected function processData(array $data) : array
    {
        return $this->dataProcessor->setInstanceProps($data , $this->currentOperationGroup , $this->dateProcessor)
                                   ->getProcessedData();
    }

    protected function setOrderingColumns(array $OrderingColumns = []) : void
    {
        foreach ($OrderingColumns as $column => $orderingStyle)
        {
            $this->query->orderBy($column , $orderingStyle);
        }
    }
    protected function setSelectedColumns(): void
    {
        foreach ($this->currentOperationGroup->getSelectingNeededColumnFullNames() as $column => $alias)
        {
            $this->query->addSelect(DB::raw($column . " as " . $alias));
        }
    }

    protected function groupBy() : void
    {
        $columns = $this->currentOperationGroup->getGroupedByColumnAliases();
        if( !empty($columns) ) { $this->query->groupBy($columns ); }
    }
    protected function setResultRowCount() : void
    {
        $ResultRowCount = $this->currentOperationGroup->getResultRowCount();
        if($ResultRowCount > 0)
        {
            $this->query->limit($ResultRowCount);
        }
    }

    protected function setDateCondition() : void
    {
        if($this->dateProcessor && $this->currentOperationGroup->getDateSensitivityStatus())
        {
            $dateColumn = $this->currentOperationGroup->getDateColumn()->getColumnFullName();
            $this->query->whereBetween( $dateColumn,[$this->dateProcessor->getStartingDate() , $this->dateProcessor->getEndingDate()]);
        }
    }

    protected function setQueryConditions() : void
    {
        /**
         * @var WhereCondition $condition
         * @var WhereConditionGroup $conditionGroup
         */
        foreach ($this->currentOperationGroup->getWhereConditionGroups() as $conditionGroup)
        {
            $callback = function ($query) use ($conditionGroup)
                        {
                            foreach ($conditionGroup->getWhereConditions() as $condition)
                            {
                                $query->where(
                                    $condition->getConditionColumn()->getColumnFullName() ,
                                    $condition->getOperator(),
                                    $condition->getConditionColumnValue(),
                                    $condition->getConditionType()
                                );
                            }
                        };
            if($conditionGroup->getConditionGroupType() == "and")
            {
                $this->query->where($callback);
                continue;
            }
            $this->query->orWhere($callback);
        }
    }

    protected function setRelationshipWhereConditions(RelationshipLoader $relationship , JoinClause $joinQuery): void
    {
        foreach ($relationship->getWhereConditionGroups() as $conditionGroup)
        {
            $callback = function ($query) use ($conditionGroup)
            {
                foreach ($conditionGroup->getWhereConditions() as $condition)
                {
                    $query->where(
                        $condition->getConditionColumn()->getColumnFullName() ,
                        $condition->getOperator(),
                        $condition->getConditionColumnValue(),
                        $condition->getConditionType()
                    );
                }
            };
            if($conditionGroup->getConditionGroupType() == "and")
            {
                $joinQuery->where($callback);
                continue;
            }
            $joinQuery->orWhere($callback);
        }
    }

    /**
     * @param RelationshipLoader $relationship
     * @param JoinClause $joinQuery
     * @return void
     * @throws JsonException
     */
    protected function setRelationshipJoinConditions(RelationshipLoader $relationship , JoinClause $joinQuery): void
    {

        $condition = $relationship->getJoinCondition();
        $joinQuery->on(
                         $condition->getChildForeignKeyFullName() ,
                         $condition->getOperator() ,
                         $condition->getParentLocalKeyFullName(),
                         $condition->getConditionType()
                      );
    }

    /**
     * @param RelationshipLoader $relationship
     * @return void
     * @throws JsonException
     */
    protected function joinRelationship(RelationshipLoader $relationship): void
    {
        $this->query->join(
            $relationship->getTableName(),
            function (JoinClause $joinQuery) use ($relationship)
            {
                $this->setRelationshipJoinConditions($relationship , $joinQuery);
                $this->setRelationshipWhereConditions($relationship , $joinQuery);
            }
        );
    }

    /**
     * @return void
     * @throws JsonException
     */
    protected function joinRelationships(): void
    {
        /**
         * @var RelationshipLoader $relationship
         */
        foreach ($this->currentOperationGroup->getLoadedRelationships() as $relationship)
        {
            $this->joinRelationship($relationship);
        }
    }

    protected function setOperationAggregationConditions() : void
    {
        /**
         * @var HavingCondition $condition
         */
        foreach ($this->currentOperation->getAggregationConditions() as $condition)
        {
            $this->query->having( $condition->getConditionColumn()->getResultProcessingColumnAlias() , $condition->getOperator() , $condition->getConditionColumnValue()  , $condition->getConditionType());
        }

    }
    protected function customizeOperationQuery() : void
    {
        $this->getAggregationOpStrategy()->customize();
    }

    /**
     * @var ?AggregationOperation $operation
     * @return DBFetcherDataResource
     * It Is The Only Used Operation
     * It Is Used To Allow The Statistics Provider Child Builder To Pass it to strategy Child Classes
     */
    protected function setCurrentOperation(?AggregationOperation $operation = null) : DBFetcherDataResource
    {
        $this->currentOperation = $operation;
        return $this;
    }

    protected function processOperations() : void
    {
        /**
         * @var AggregationOperation $operation
         */
        foreach ($this->currentOperationGroup->getOperations() as $operation)
        {
            $this->setCurrentOperation($operation);
            if($this->currentOperation)
            {
                $this->customizeOperationQuery();
                $this->setOperationAggregationConditions();
                $this->setOrderingColumns($this->currentOperation->getOrderingColumns());
            }
        }
    }

    protected function initQuery() : void
    {
        if($this->query)
        {
            $this->query = $this->query->newQuery()->from($this->currentOperationGroup->getTableName());
            return;
        }
        $this->query = DB::table($this->currentOperationGroup->getTableName());
    }

    /**
     * @param OperationGroup $currentOperationGroup
     * @return DBFetcherDataResource
     */
    public function setCurrentOperationGroup(OperationGroup $currentOperationGroup): DBFetcherDataResource
    {
        $this->currentOperationGroup = $currentOperationGroup;
        return $this;
    }

    /**
     * @return void
     * @throws JsonException
     */
    protected function setStatistics() : void
    {
        /**
         * @var OperationGroup $operationGroup
         * @var AggregationOperation $operation
         */
        foreach ($this->OperationGroupsArray as $operationGroup)
        {
            $this->setCurrentOperationGroup($operationGroup);
            $this->initQuery();
            $this->processOperations();
            $this->joinRelationships();
            $this->setQueryConditions();
            $this->setDateCondition();
            $this->setResultRowCount();
            $this->groupBy();
            $this->setSelectedColumns();
            $this->setOrderingColumns($operationGroup->getOrderingColumns());
            /**
             * Result Data Processing Part
             */
            $data = $this->processData($this->query->get()->toArray());
            $this->mergeProcessedData($data);
        }
    }
}
