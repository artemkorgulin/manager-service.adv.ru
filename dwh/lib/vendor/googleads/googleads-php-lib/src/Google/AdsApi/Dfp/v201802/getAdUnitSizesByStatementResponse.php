<?php

namespace Google\AdsApi\Dfp\v201802;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class getAdUnitSizesByStatementResponse
{

    /**
     * @var \Google\AdsApi\Dfp\v201802\AdUnitSize[] $rval
     */
    protected $rval = null;

    /**
     * @param \Google\AdsApi\Dfp\v201802\AdUnitSize[] $rval
     */
    public function __construct(array $rval = null)
    {
      $this->rval = $rval;
    }

    /**
     * @return \Google\AdsApi\Dfp\v201802\AdUnitSize[]
     */
    public function getRval()
    {
      return $this->rval;
    }

    /**
     * @param \Google\AdsApi\Dfp\v201802\AdUnitSize[] $rval
     * @return \Google\AdsApi\Dfp\v201802\getAdUnitSizesByStatementResponse
     */
    public function setRval(array $rval)
    {
      $this->rval = $rval;
      return $this;
    }

}
