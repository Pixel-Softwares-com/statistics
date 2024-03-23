# Statistics Structure - Usage
## DateProcessors 

### DateProcessor Abstract Class :
- It is an abstract class to force all child classes to define some methods called by DataResource Classes .
- It processes the ending date , start date for the current request to use them in the query where condition .
- The used request filter for starting date is : from_date 
- The used request filter for ending date is : to_date

- abstract methods - implemented by child DateProcessor class by the convenient way : 
    - getStartingDateInstance() : Returns a Carbon\Carbon instance.
    - getEndingDateInstance() : Returns a Carbon\Carbon instance . 

### DateProcessor Types :

#### GlobalDateProcessor 
It is an abstract class and has the normal functionality of DateProcessor 
to process the start date and end date coming from request filters.

  ##### GlobalDateProcessor Types - Time period types
  - DayPeriodDateProcessor :
    - methods : 
      - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>day</b> .
      - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>day</b> .

  - MonthPeriodDateProcessor
    - methods : 
      - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>month</b> .
      - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>month</b> .
  - QuarterPeriodDateProcessor
    - methods :
      - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>year's quarter</b> .
      - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>year's quarter</b> .
  - YearPeriodDateProcessor
    - methods :
      - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>year</b> .
      - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>year</b> .
  - RangePeriodDateProcessor
    - methods :
      - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>day</b> .
      - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the ending date</b> to return date <b>ends</b> on the end of <b>day</b> .

#### DateGroupedChartDateProcessor
It is an abstract class , used to process the start date and end date coming from request filters (( for statistical charts period time processing )).
Provides extra functionality to generate date period between the start date and end date .


<b>This part is wrong information .... will be edited</b>
##### DateGroupedChartDateProcessor Types - Time period types
- DayPeriodDateProcessor :
  - methods :
    - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>day</b> .
    - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>day</b> .

- MonthPeriodDateProcessor
  - methods :
    - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>month</b> .
    - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>month</b> .
- QuarterPeriodDateProcessor
  - methods :
    - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>year's quarter</b> .
    - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>year's quarter</b> .
- YearPeriodDateProcessor
  - methods :
    - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>year</b> .
    - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>ends</b> on the end of <b>year</b> .
- RangePeriodDateProcessor
  - methods :
    - getStartingDateInstance(): Gets Carbon\Carbon after parsing <b>the starting date</b> to return date <b>starts</b> from the beginning of <b>day</b> .
    - getEndingDateInstance() : Gets Carbon\Carbon after parsing <b>the ending date</b> to return date <b>ends</b> on the end of <b>day</b> .
