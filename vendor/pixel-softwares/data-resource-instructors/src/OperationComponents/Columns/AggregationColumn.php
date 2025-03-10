<?php


namespace DataResourceInstructors\OperationComponents\Columns;

class AggregationColumn extends Column
{
    protected string $resultLabel = "";
    protected int $resultLabelCharMaxLength = -1;
    protected string $alternativeShortResultLabel = "";

    /**
     * @param ...$params
     * @return AggregationColumn
     * required $params :
     * string $columnName
     *
     */
    static public function create(...$params) : AggregationColumn
    {
        return new static(...$params);
    }

    public function __construct(string $columnName)
    {
        parent::__construct($columnName);
        $this->setResultProcessingColumnDefaultAlias();
    }


    /**
     * @param string $resultLabel
     * @return $this
     *
     * Must Take a string as a parameter to se it as the key of aggregation operation's result key
     * You Can Use The Grouped Column's Aliases with : prefix character like this :
     *  "Count Of User in :countryName"
     * :countryName Will Be Replaced With Grouped By Column's alias ( CountryName )
     */
    public function setResultLabel(string $resultLabel): AggregationColumn
    {
        $this->resultLabel = $resultLabel;
        return $this;
    }

    /**
     * @return string
     */
    public function getResultLabel(): string
    {
        return $this->resultLabel;
    }

    /**
     * @param int $length
     * @param string $shortLabel
     * @return $this
     */
    public function setResultLabelMaxLength(int $length , string $shortLabel) : AggregationColumn
    {
        $this->setResultLabelCharMaxLength($length);
        $this->setAlternativeShortResultLabel($shortLabel);
        return $this;
    }
    public function disableLimitingResultLabelCharLength() : self
    {
        $this->setResultLabelCharMaxLength( -1 );
        return $this;
    }

    /**
     * @param int $length
     */
    protected function setResultLabelCharMaxLength(int $length): void
    {
        $this->resultLabelCharMaxLength = $length;
    }

    /**
     * @param string $shortLabel
     */
    protected function setAlternativeShortResultLabel(string $shortLabel): void
    {
        if(!empty($shortLabel))
        {
            $this->alternativeShortResultLabel = $shortLabel;
            return;
        }
        $this->disableLimitingResultLabelCharLength();
    }

    /**
     * @return string
     */
    public function getAlternativeShortResultLabel(): string
    {
        return $this->alternativeShortResultLabel;
    }

    public function getResultLabelMaxLength() : int
    {
        return $this->resultLabelCharMaxLength;
    }

    public function isCharLengthLimited() : bool
    {
        return $this->getResultLabelMaxLength() > 0 ;
    }
}
