# DataResourceInstructors Structure
## OperationContainers - RelationshipLoader

It is a container for holding relationship joining query components ... it serves as an OperationContainer and has payload to represent its query .

### RelationshipLoader type :
- BeLongsToRelationshipLoader : Used when it is wanted to join the table that OperationGroup represent
to the table that the relationshipLoader represent where the relationship means :
<b>OperationGroup's table =====BelongsTo===>  BeLongsToRelationshipLoader 's table .</b>
  - methods :
    - __construct(string $tableName   ,string $childModelForeignKeyName , string $parentModelLocalKeyName = "id" )
    where :
      - $childModelForeignKeyName Is The Foreign Key Used To Refer To The Parent ,
      And Will Be Located  In  Model's DB Table ( As Foreign Key For Referring The Parent That Is Found In Relationship's Table) .
      - $parentModelLocalKeyName : Is The Parent Local Key ,Parent Local Key Will Be Located In The Relationship's Table ( As Primary Key) .
- OwnedRelationshipLoader :  Used when it is wanted to join the table that OperationGroup represent
   to the table that the relationshipLoader represent where the relationship means :
   <b>OperationGroup's table =====HasOne Or HasMany===>  BeLongsToRelationshipLoader 's table .</b>
  - methods :
    - __construct( string $tableName  ,  string $childModelForeignKeyName , string $parentModelLocalKeyName = "id" )
    where : 
      - $childModelForeignKeyName Is The Foreign Key Used To Refer To The Parent ,
      And Will Be Located In The Child Table (For Referring The Parent That Is Found In Model's DB Table) .
      - $parentModelLocalKeyName : Is The Parent Local Key ,  Will Be Located In  Model's DB Table ( As Primary Key). 

- methods : It serves as a OperationContainer , So it has its methods , In addition to :
  - create( string $tableName , string $childModelForeignKeyName , string $parentModelLocalKeyName = "id" ) : RelationshipLoader
    creating an instance (not for abstract class , it is for the child RelationshipLoad ) .
  - getJoinCondition() : Gets the join condition will be set while joining the relationship table to the related table .
  - getTableName(): Gets the table name that the relationship represent . 
  - setRelatedModelTableName(string $tableName) : Sets the table name will be join with .
  - getRelatedModelTableName(): string