<?php

namespace DataResourceInstructors\OperationContainers\RelationshipLoaders;


use DataResourceInstructors\OperationComponents\OperationConditions\JoinConditions\OnCondition;


/**
 * Used When We Want To Join With Another Table To Get Model Children 's Rows
 */
class OwnedRelationshipLoader extends RelationshipLoader
{
    /**
     * $childModelForeignKeyName Is The Foreign Key Used To Refer To The Parent , And Will Be Located In The Child Table (For Referring The Parent That Is Found In Model's DB Table) ,
     * $parentModelLocalKeyName : Is The Parent Local Key ,  Will Be Located In  Model's DB Table ( As Primary Key)
     */
    public function __construct( string $tableName  ,  string $childModelForeignKeyName , string $parentModelLocalKeyName = "id" )
    {
        parent::__construct( $tableName  ,   $childModelForeignKeyName ,  $parentModelLocalKeyName );
    }

    protected function getJoinConditionInstance() : OnCondition
    {
        return OnCondition::create(
            $this->RelatedModelTableName , $this->tableName  , $this->childModelForeignKeyName , $this->parentModelLocalKeyName
        );
    }

}
