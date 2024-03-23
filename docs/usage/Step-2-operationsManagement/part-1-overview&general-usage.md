# Statistics Structure - Usage
## OperationsManagement - overview 

### Why we need them :
- Some of Common StatisticsProviders has their own Statistical operations to do and returns the result wrapped in a key .
  - They are :
    - BarAvgChartStatisticsProvider
    - BarCountChartStatisticsProvider
    - BarSumChartStatisticsProvider
- The other Common StatisticsProviders doesn't have any Statistical operations to do and expects to receive them from you while extending the class by a new StatisticsProvider child class.
  - They are : 
    - SmallBoxesStatisticsProvider
    - BigBoxStatisticsProvider
    - PieChartStatisticsProvider
- Any Custom StatisticsProviders will you create don't have any Statistical operations to do and expect to receive them from you while extending the class by a new StatisticsProvider child class.

### How to use :
- Using the Common Operation Factories (look at the next docs page) to use some ready and encapsulated operation .
- Composing them from scratch as you need by using DataResourceInstructors package .