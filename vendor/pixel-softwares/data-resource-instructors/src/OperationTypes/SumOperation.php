<?php

namespace DataResourceInstructors\OperationTypes;

class SumOperation  extends AggregationOperation
{

    static public function getOperationName() : string
    {
        return "sum";
    }

}
