<?php

namespace DataResourceInstructors\OperationContainers\RelationshipLoaders;

use DataResourceInstructors\OperationComponents\OperationConditions\JoinConditions\OnCondition;

/**
 * Used When We Want To Join With Another Table To Get Model Parent's Row (Info)
 */
class BeLongsToRelationshipLoader extends RelationshipLoader
{
    /**
     * $childModelForeignKeyName Is The Foreign Key Used To Refer To The Parent , And Will Be Located  In  Model's DB Table ( As Foreign Key For Referring The Parent That Is Found In Relationship's Table)
     * $parentModelLocalKeyName : Is The Parent Local Key ,Parent Local Key Will Be Located In The Relationship's Table ( As Primary Key)
     */
    public function __construct(string $tableName   ,string $childModelForeignKeyName , string $parentModelLocalKeyName = "id" )
    {
        parent::__construct($tableName  ,$childModelForeignKeyName , $parentModelLocalKeyName );
    }

    protected function getJoinConditionInstance() : OnCondition
    {
        return OnCondition::create(
            $this->tableName , $this->RelatedModelTableName  , $this->childModelForeignKeyName , $this->parentModelLocalKeyName
        );
    }
}
