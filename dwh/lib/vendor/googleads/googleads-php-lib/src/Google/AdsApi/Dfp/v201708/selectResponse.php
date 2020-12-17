<?php

namespace Google\AdsApi\Dfp\v201708;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class selectResponse
{

    /**
     * @var \Google\AdsApi\Dfp\v201708\ResultSet $rval
     */
    protected $rval = null;

    /**
     * @param \Google\AdsApi\Dfp\v201708\ResultSet $rval
     */
    public function __construct($rval = null)
    {
      $this->rval = $rval;
    }

    /**
     * @return \Google\AdsApi\Dfp\v201708\ResultSet
     */
    public function getRval()
    {
      return $this->rval;
    }

    /**
     * @param \Google\AdsApi\Dfp\v201708\ResultSet $rval
     * @return \Google\AdsApi\Dfp\v201708\selectResponse
     */
    public function setRval($rval)
    {
      $this->rval = $rval;
      return $this;
    }

}
