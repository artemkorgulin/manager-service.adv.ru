<?php

namespace Google\AdsApi\Dfp\v201711;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class getCreativeSetsByStatementResponse
{

    /**
     * @var \Google\AdsApi\Dfp\v201711\CreativeSetPage $rval
     */
    protected $rval = null;

    /**
     * @param \Google\AdsApi\Dfp\v201711\CreativeSetPage $rval
     */
    public function __construct($rval = null)
    {
      $this->rval = $rval;
    }

    /**
     * @return \Google\AdsApi\Dfp\v201711\CreativeSetPage
     */
    public function getRval()
    {
      return $this->rval;
    }

    /**
     * @param \Google\AdsApi\Dfp\v201711\CreativeSetPage $rval
     * @return \Google\AdsApi\Dfp\v201711\getCreativeSetsByStatementResponse
     */
    public function setRval($rval)
    {
      $this->rval = $rval;
      return $this;
    }

}
