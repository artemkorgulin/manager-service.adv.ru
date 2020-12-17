<?php

namespace Google\AdsApi\AdWords\v201708\cm;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class ProductTypeFull extends \Google\AdsApi\AdWords\v201708\cm\ProductDimension
{

    /**
     * @var string $value
     */
    protected $value = null;

    /**
     * @param string $ProductDimensionType
     * @param string $value
     */
    public function __construct($ProductDimensionType = null, $value = null)
    {
      parent::__construct($ProductDimensionType);
      $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
      return $this->value;
    }

    /**
     * @param string $value
     * @return \Google\AdsApi\AdWords\v201708\cm\ProductTypeFull
     */
    public function setValue($value)
    {
      $this->value = $value;
      return $this;
    }

}
