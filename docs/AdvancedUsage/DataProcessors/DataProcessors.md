# Statistics Structure - Usage
## DataProcessors


### - DataProcessor Class :
- It is an abstract class to force all child classes to define some methods called by DataResource Classes .

### - DataProcessor Types :
#### DBFetchedDataProcessors : They process the data results from query execution in Database , to get a final one level array .

* DBFetchedDataProcessors Child Classes :
    - DBFetchedGlobalDataProcessor : It loops on data and all operation including in the given OperationGroup object
      to replace all aggregation column aliases with the required value found in the data row array .
    - DateGroupedDBFetchedDataProcessor : It uses the DateProcessor to generate a time period and using it in the final data array to get a statistics data array grouped by date .
