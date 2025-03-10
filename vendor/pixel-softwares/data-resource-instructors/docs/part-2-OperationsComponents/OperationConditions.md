# DataResourceInstructors Structure
### Operation Components - Conditions:

Any condition in this structure contains the required properties for DataResource work , like condition column , condition value , condition operator ,
And in this structure it is compatible with OperationContainers to set conditions on the query design will be executed by a DataResource Class (in Statistics package for example) .

#### Operation Condition Types 
There are some main condition types :

##### OperationCondition : is an abstract type contains the common functionality of the conditions that purpose for checking a column value .
- methods :
  - __construct(Column $column  , mixed $value , string $operator = "=") : create a new instance <b>from the child OperationCondition class</b>.
  - setTableName(string $tableName)  : Sets the table name into the condition column passed into the constructor .  
  - getTableName()  : Gets the condition column's table name .
  - getConditionColumn() : Gets the condition column  passed into the constructor .
  - getConditionColumnValue() : Gets the condition value passed into the constructor .
  - getOperator() : Gets the condition value operator passed into the constructor (by default = ).
  - getConditionType() : Returns 'and' or 'or' values (for and where , or where query clauses).

- Each of these method can be used as public methods form any OperationCondition child Class.
- OperationCondition has two types of conditions :
  - HavingCondition ( Aggregation Conditions ) : it the same "having" conditions found in sql  , It is an abstract type named HavingCondition .
    - methods :
      - __construct(AggregationColumn $column  , mixed $value , string $operator = "=") : create a new instance <b>from the child HavingCondition class</b> , it is an override on the parent constructor .
      - HavingCondition::create(AggregationColumn $column , mixed $value , string $operator = "=") : create a new instance <b>from the child HavingCondition class</b>.
    - HavingCondition has two types of HavingCondition :  AndHavingCondition , OrHavingCondition
  - WhereConditions : is the normal where clause used in sql , It is an abstract type .
    - methods :
      -  WhereCondition::create(Column $column , mixed $value , string $operator = "=")  : create a new instance <b>from the child WhereCondition class</b>.
  - And has two types of WhereConditions : AndWhereCondition , OrWhereCondition
  
#### JoinConditions :  It is an abstract type , contains the common functionality of the conditions purpose for joining many tables based on a join condition ,
And in this structure it is used in RelationshipLoader OperationContainer .
- methods :
  - __construct(string $parentTableName , string $childTableName , string $childForeignKeyName , string $parentLocalKeyName , string $operator = "=")
    create a new instance <b>from the child JoinConditions class</b> , where $parentTableName , $childTableName , $parentLocalKeyName are required 
    to use while join two tables (one table represent the parent that owns the child row in the other table).
  - getConditionType() : Returns 'and' or 'or' values (for on , orOn query clauses).
  - getChildTableName() : Gets the $childTableName passed into the constructor
  - getChildForeignKeyName() : Gets the $childForeignKeyName passed into the constructor
  - getParentLocalKeyName() : Gets the $parentLocalKeyName passed into the constructor
  - getParentTableName(): Gets the $parentTableName passed into the constructor
  - getOperator(): Gets the $operator passed into the constructor (by default =) .
  - getParentLocalKeyFullName() : Gets the $parentTableName + $parentLocalKeyName.
  - getChildForeignKeyFullName() : Gets the $childTableName + $childForeignKeyName.
- Each of these method can be used as public methods form any JoinConditions child Class.

- JoinConditions has two type of JoinConditions :
  - OnCondition
    - methods :
      - OnCondition::create(string $parentTableName , string $childTableName , string $childForeignKeyName , string $parentLocalKeyName , string $operator = "=")
       creates a new instance from OnCondition Class .
  - OrOnCondition
    - OrOnCondition::create(string $parentTableName , string $childTableName , string $parentForeignKeyName , string $parentLocalKeyName , string $operator = "=")
      creates a new instance from OrOnCondition Class .
    
### WhereConditionGroup 
It is a container of many WhereCondition typed objects and can be set on the OperationContainer 
to instruct the DataResource class to set all of them in on where clause .

- methods :
  - WhereConditionGroup::create() : create a new instance <b>from the child WhereConditionGroup class</b>
  - getConditionGroupType() : Returns 'and' or 'or' values (for and where , or where query clauses).