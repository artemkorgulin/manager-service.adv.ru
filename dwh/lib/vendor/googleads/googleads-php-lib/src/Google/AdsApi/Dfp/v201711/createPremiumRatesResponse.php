<?php

namespace Google\AdsApi\Dfp\v201711;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class createPremiumRatesResponse
{

    /**
     * @var \Google\AdsApi\Dfp\v201711\PremiumRate[] $rval
     */
    protected $rval = null;

    /**
     * @param \Google\AdsApi\Dfp\v201711\PremiumRate[] $rval
     */
    public function __construct(array $rval = null)
    {
      $this->rval = $rval;
    }

    /**
     * @return \Google\AdsApi\Dfp\v201711\PremiumRate[]
     */
    public function getRval()
    {
      return $this->rval;
    }

    /**
     * @param \Google\AdsApi\Dfp\v201711\PremiumRate[] $rval
     * @return \Google\AdsApi\Dfp\v201711\createPremiumRatesResponse
     */
    public function setRval(array $rval)
    {
      $this->rval = $rval;
      return $this;
    }

}
