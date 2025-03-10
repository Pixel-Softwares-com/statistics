<?php

namespace DataResourceInstructors\OperationContainers\RelationshipLoaders;

use Exception;
use DataResourceInstructors\Helpers\Helpers;
use DataResourceInstructors\OperationComponents\OperationConditions\JoinConditions\JoinCondition;
use DataResourceInstructors\OperationComponents\OperationConditions\JoinConditions\OnCondition;
use DataResourceInstructors\OperationContainers\OperationContainer;

abstract class RelationshipLoader extends OperationContainer
{
    protected string $RelatedModelTableName  = "";
    protected string $childModelForeignKeyName;
    protected string $parentModelLocalKeyName;

    abstract  protected function getJoinConditionInstance() : OnCondition ;

    public function __construct( string $tableName ,  string $childModelForeignKeyName , string $parentModelLocalKeyName = "id" )
    {
        parent::__construct($tableName);
        $this->childModelForeignKeyName = $childModelForeignKeyName;
        $this->parentModelLocalKeyName = $parentModelLocalKeyName;
    }
    static public function create( string $tableName , string $childModelForeignKeyName , string $parentModelLocalKeyName = "id" ) : RelationshipLoader
    {
        return new static( $tableName  ,$childModelForeignKeyName , $parentModelLocalKeyName );
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function areJoinConditionParametersValid() : void
    {
        if(!$this->RelatedModelTableName)
        {
            $exceptionClass = Helpers::getExceptionClass();
            throw new $exceptionClass("The Related Model's Table Name Has Not Been Passed");
        }
    }
    /**
     * @return JoinCondition
     * @throws Exception
     */
    public function getJoinCondition() : JoinCondition
    {
        $this->areJoinConditionParametersValid();
        return $this->getJoinConditionInstance();
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setRelatedModelTableName(string $tableName) : RelationshipLoader
    {
        $this->RelatedModelTableName = $tableName;
        return $this;
    }

    /**
     * @return string
     */
    public function getRelatedModelTableName(): string
    {
        return $this->RelatedModelTableName;
    }


}
