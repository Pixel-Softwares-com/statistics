<?php

namespace DataResourceInstructors\OperationComponents\Columns;

class GroupingByColumn extends Column
{
    protected array $processingRequiredValues = [];

    /**
     * @param ...$params
     * @return GroupingByColumn
     * * required $params :
     * string $columnName
     * string $ResultProcessingColumnAlias
     */
    static public function create(...$params) : GroupingByColumn
    {
        return new static(...$params);
    }

    public function __construct(string $columnName , string $ResultProcessingColumnAlias )
    {
        parent::__construct($columnName);
        $this->ResultProcessingColumnAlias = $ResultProcessingColumnAlias;
    }

    /**
     * @param array $values
     * @return $this
     *
     * You Shouldn't Use This Method For Values Those Are Presenting Foreign Keys Refer to Entities In Another Table , Otherwise The Performance Will Be Bad
     * You Should Use It For Static Values Of An Attribute Which Has Small Range Of Values  , Otherwise The Performance Will Be Bad
     * Ex :
     * For Column Named as Status :
     * The $values array will be :
     * [ "active" , "inactive" ]
     */
    public function setProcessingRequiredForStaticValues(array $values): GroupingByColumn
    {
        $this->processingRequiredValues = $values;
        return $this;
    }

    /**
     * @return array
     */
    public function getProcessingRequiredValues(): array
    {
        return $this->processingRequiredValues;
    }
}
