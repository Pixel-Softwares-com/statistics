# DataResourceInstructors Structure

## Concepts :
- Query design : it is a container that holds some query components to instruct the DataResource how must it compose the query wanted to be executed .
- OperationContainer payload : it is the query components those hold to represent the desired query design , such as :
    - the aggregation operations will be executed on their columns.
    - the columns the result will be grouped by .
    - the columns the result will be ordered by .
    - the columns will be selected (selected for data processing only ... not in the final result array ).
    - the applied conditions (where conditions + having conditions) .

## OperationContainers
- The main purpose of this DataResourceInstructors structure is to design the query wanted to be implemented by DataResources , and here is the container will represent the query ,
and will hold the query components to instruct the DataResource what must it do .
- Each OperationContainer mainly represents a table and contains payload of query components to represent <b>the query design part that related to this table  </b>. 
- Don't forget .... This structure is only for instructing the DataResource to do someting .... It doesn't execeute any query or logic .. it is a quey design .

### OperationContainers types :
- There are mainly two types of OperationContainers :
  - OperationGroup : is the main OperationContainer in any query designing ..... even if there is a relationship to join it will be loaded on the OperationGroup .
    it - as an OperationContainer - holds its payload (operations , columns , conditions .... etc.) <br>
    And also , <br>
    It can interact with RelationshipLoader typed OperationContainers objects to combine their payloads (operations , columns , conditions .... etc.)
    <b> To allow us to get one container for all query components in the final query design </b> .
  - RelationshipLoader : is a container for holding relationship joining query components ... it serves as an OperationContainer and has payload to represent its query .  

  
- methods :
  - __construct(string $tableName) : creates a new instance ( not fo abstract parent ... it is for the child OperationContainer Class) . 
  - getTableName(): Gets the table name that the OperationGroup represent in DataResource environment (database or anything els).
  - getOperations(): Gets the aggregation operation those set by 'addOperation' , 'setOperations' methods / 
  - setOperations(array $operations): Adds new aggregation operations .
  - addOperation(AggregationOperation $operation) : Adds new aggregation operation.
  - orderBy(Column $column , string $orderingStyleConstant = "") : Orders the query result on column>. 
  - getOrderingColumns(): Gets ordering columns those set by 'orderBy' method .
  - groupedByColumn( GroupingByColumn $column): Grouping the query result on column
  - getColumnsForProcessingRequiredValues(): returns an array of GroupingBy column's processing required values ( needed for dataProcessing) .
  - where(WhereCondition $condition) : Sets a condition on the query .
  - whereConditionGroup(WhereConditionGroup $conditionGroup) : Sets a set of condition on the query .
  - getWhereConditionGroups()  : Gets the condition sets handled by 'where', 'whereConditionGroup' methods .
  - getSelectingNeededColumnFullNames(): Gets an array composes from $key = ColumnFullName and its value is the same column alias .
  - getSelectedColumns(): Gets an array of the columns will be selected in the query .
