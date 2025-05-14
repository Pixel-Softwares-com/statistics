<?php

namespace DataResourceInstructors\OperationContainers\OperationGroups;

use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationContainer;
use DataResourceInstructors\OperationContainers\RelationshipLoaders\RelationshipLoader;

class OperationGroup extends OperationContainer
{
    protected bool $dateSensitivity = false;
    protected array $relationships = [];
    protected int $resultRowCount = -1;
    protected ?Column $dateColumn = null;

    /**
     * @var string
     *This Key Is Used In DataProcessors To Handle The OperationGroup Final Result In A specific key or nested keys
     * to use a nested keys use dot ( . ) character as a separator
     *to set key contains space use _  character instead of the space and ot will replace later automatically
     *ex : "total.By_Status" (output => key : total , subKey : By Status )
     */
    protected string $resultArrayKey = "";

    /**
     * @param string $resultArrayKey
     * @return $this
     */
    public function setResultArrayKey(string $resultArrayKey): OperationGroup
    {
        $this->resultArrayKey = $resultArrayKey;
        return $this;
    }
    /**
     * @return string
     */
    public function getResultArrayKey(): string
    {
        return $this->resultArrayKey;
    }

    /**
     * @return int
     */
    public function getResultRowCount(): int
    {
        return $this->resultRowCount;
    }

    public function limitResultRows(int $resultRowCount = 5) : OperationGroup
    {
        $this->resultRowCount = $resultRowCount;
        return $this;
    }

    static public function create(string $tableName) : OperationGroup
    {
        return new static($tableName);
    }
    /**
     * @return array
     */
    public function getLoadedRelationships(): array
    {
        return $this->relationships;
    }

    protected function mergeRelationshipComponents(RelationshipLoader $relationship) : void
    {
        $relationship->setRelatedModelTableName($this->tableName);
        $this->addSelectingNeededColumns($relationship->getSelectedColumns());

        $this->mergeGroupedByColumnAliases($relationship->getGroupedByColumnAliases());
        $this->mergeColumnsForProcessingRequiredValues($relationship->getColumnsForProcessingRequiredValues());

        $this->mergeOrderByColumns($relationship->getOrderingColumns());
        $this->mergeOperations($relationship->getOperations());
    }

    public function loadRelationship(RelationshipLoader $relationship) : OperationGroup
    {
        $this->mergeRelationshipComponents($relationship);
        $this->relationships[] = $relationship;
        return $this;
    }

    /**
     * @param array $relationships
     * @return OperationGroup
     */
    public function loadRelationships(array $relationships): OperationGroup
    {
        foreach ($relationships as $relationship)
        {
            if($relationship instanceof RelationshipLoader)
            {
                $this->loadRelationship($relationship);
            }
        }
        return $this;
    }

    /**
     * @return Column
     */
    public function getDateColumn(): Column
    {
        return $this->dateColumn;
    }
    public function getDateSensitivityStatus() : bool
    {
        return $this->dateSensitivity;
    }

    protected function setDateColumnTableNameConveniently(Column $column ,  ?RelationshipLoader $relationshipLoader = null ) : void
    {
        $tableName = !$relationshipLoader ? $this->tableName : $relationshipLoader->getTableName() ;
        
        $column->setTableName($tableName);
    }

    public function enableDateSensitivity(Column $dateColumn  , ?RelationshipLoader $relationshipLoader = null) : OperationGroup
    {
        $this->setDateColumnTableNameConveniently($dateColumn , $relationshipLoader);
        $this->dateColumn = $dateColumn->setResultProcessingColumnDefaultAlias();
        $this->dateSensitivity = true;
        return $this;
    }
    public function disableDateSensitivity() : OperationGroup
    {
        $this->dateColumn = null;
        $this->dateSensitivity = false;
        return $this;
    }
}
