<?php

namespace Google\AdsApi\Dfp\v201708;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class getPackagesByStatementResponse
{

    /**
     * @var \Google\AdsApi\Dfp\v201708\PackagePage $rval
     */
    protected $rval = null;

    /**
     * @param \Google\AdsApi\Dfp\v201708\PackagePage $rval
     */
    public function __construct($rval = null)
    {
      $this->rval = $rval;
    }

    /**
     * @return \Google\AdsApi\Dfp\v201708\PackagePage
     */
    public function getRval()
    {
      return $this->rval;
    }

    /**
     * @param \Google\AdsApi\Dfp\v201708\PackagePage $rval
     * @return \Google\AdsApi\Dfp\v201708\getPackagesByStatementResponse
     */
    public function setRval($rval)
    {
      $this->rval = $rval;
      return $this;
    }

}
