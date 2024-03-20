# Statistics Structure - Usage
## DataResources

## overview :
It will do the statistics of the required operations using the convenient way it defines .

### DataResource Types :

#### DBFetcherDataResource class
- It will do the statistics of the required operations using the Database.
- in this structure there is no DataResources deals with another data source other than database , but maybe in the future and this structure can deal with it .

##### DBFetcherDataResource Child Classes :
- Statistics\DataResources\DBFetcherDataResources\GlobalDataResource\GlobalDataResource
  It has the normal functionality of DBFetcherDataResource and will do the statistical operation using Laravel Query Builder functionality .
- Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResource :
  It defines specific QueryCustomizationStrategy , DateProcessor , DataProcessor to group the result by another way in database and returning the result compatible with frontend charts needs ,
  It has many types :
    - Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes\DateGroupedAvgChartDataResource
      Getting avg value for the column and groups the result on the date value coming from th filters .
    - Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes\DateGroupedSumChartDataResource
      Getting sum value for the column and groups the result on the date value coming from th filters .
    - Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes\DateGroupedCountChartDataResource
      Getting counted value for the column and groups the result on the date value coming from th filters .

Each of these child classes has a specific way to get statistical data but the style of result is the same.    
