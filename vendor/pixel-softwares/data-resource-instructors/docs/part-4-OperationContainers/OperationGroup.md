# DataResourceInstructors Structure
## OperationContainers - OperationGroup

- It is the main OperationContainer in any query designing ..... even if there is a relationship to join 
it will be loaded on the OperationGroup .
- it - as an OperationContainer - holds its payload (operations , columns , conditions .... etc.) <br>
- And also , It can interact with RelationshipLoader typed OperationContainers objects
to combine their payloads (operations , columns , conditions .... etc.)
<b> To allow us to get one container for all query components in the final query design </b> .

- methods : It serves as a OperationContainer , So it has its methods , In addition to :
  - OperationGroup::create(string $tableName) : static method to create a new instance .
  - setResultArrayKey(string $resultArrayKey): Sets the query result array key .
  - getResultArrayKey(): Gets the query result array key .
  - loadRelationships(array $relationships): Loads a set of RelationshipLoader objects array ( to join them or handling them by DataResource) .
  - loadRelationship(RelationshipLoader $relationship) :  Loads a RelationshipLoader object ( to join it or handling it by DataResource) .
  - getLoadedRelationships(): Gets the loaded RelationshipLoader objects array .
  - enableDateSensitivity(Column $dateColumn , bool $relationshipColumn = false , ?RelationshipLoader $relationshipLoader = null) 
    Enable the date sensitivity to set a date condition by default on the provided date column . 
  - getDateSensitivityStatus() : Checks Date sensitivity status .
  - disableDateSensitivity() : Disable the query's date sensitivity ( no date condition will be set ) .
  - getDateColumn(): Gets the date column (or null if the date sensitivity is disabled ).
  - limitResultRows(int $resultRowCount = 5) : Sets the needed row's count .
  - getResultRowCount(): : Grts the result row count that se by 'limitResultRows' method .
