# DataResourceInstructors Structure
### Operation Components ( Columns & Conditions & Ordering ) :
They are the easiest way to set OperationContainers and AggregationOperations properties without making any validation that will make the processing slower . <br>
Example : When you need to use Statistics package and instruct the StatisticsProvider to execute a query by passing it an OperationContainer object ,
while you create the OperationContainer object you may use Column typed object to instruct the OperationContainer which column must it use for grouping-by or ordering ,
like in this code which is used to getting count of all clients added in the date period coming from date filters based on their status (grouped by status value).

           <?php
    
              use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
              use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
              use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
    
              class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
              {
                  protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
                  {
                      $groupingColumn = GroupingByColumn::create("status" , "status");
                      return OperationGroup::create( /*.....etc of params*/)->groupedByColumn($groupingColumn) ;
                  }
                  public function getAdditionalAdvancedOperations(): array
                  {
                      return [
                          $this->getCountingClientGroupedByStatusOperationGroup()
                      ]; /*Array Of OperationGroup objects */
                  }
              }

<hr>

### Usage Steps :
- No rules , use Create static public method to create the component and set its properties as you need .
