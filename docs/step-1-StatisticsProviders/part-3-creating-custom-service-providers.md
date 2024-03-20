# Statistics Structure - Usage
## Custom StatisticsProviders

- When the common StatisticsProvider types doesn't match what you want you can create a new type and choosing 
what is the custom StatisticsProvider  behavior must have .

- required steps :
  - create a new class and make it inherited from Statistics\StatisticsProviders\CustomizableStatisticsProvider class .
  - implement the required methods :
    - public function getStatisticsTypeName(): string ;
  - overriding the methods to change the default behavior :
    - protected function getDataResourceOrdersByPriorityClasses()  :array
      <br>This method returns an array contains a single DateResource used as default DataResource by the StatisticsProvider  ,
      It is GlobalDataResource DataResource class (look at DataResources docs in AdvancedFunctionality part) ,
    override this method to return an array of DataResource <b>classes</b> (order them by priority) 
     (from this package DataResources or  , a DataResource ).
    - protected function getDataProcessorInstance(): DataProcessor
      <br>This method returns the default DataProcessor used by the StatisticsProvider  ,
      It is GlobalDataProcessor DataProcessor object (look at DataProcessors docs  in AdvancedFunctionality part) , ,   
     override this method to return a custom DataProcessor <b>object </b> ,
    (from this package DataProcessor or  , a DataProcessor ).
    - protected function getNeededDateProcessorDeterminerInstance(): NeededDateProcessorDeterminer
      <br>This method returns the default DateProcessorDeterminer used by the StatisticsProvider  ,
      It is GlobalDateProcessorDeterminer DateProcessorDeterminer object (look at DateProcessorDeterminers docs  in AdvancedFunctionality part) , ,   
      override this method to return a custom DateProcessorDeterminer <b>object </b> ,
      (from this package DateProcessorDeterminer or  , a DateProcessorDeterminer ).
  - passing OperationGroups to process : 
    - By implementing Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations to return an array of OperationGroups;
    - Look at OperationManagement docs part . 