<?php

namespace Google\AdsApi\Dfp\v201802;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class updateReconciliationLineItemReportsResponse
{

    /**
     * @var \Google\AdsApi\Dfp\v201802\ReconciliationLineItemReport[] $rval
     */
    protected $rval = null;

    /**
     * @param \Google\AdsApi\Dfp\v201802\ReconciliationLineItemReport[] $rval
     */
    public function __construct(array $rval = null)
    {
      $this->rval = $rval;
    }

    /**
     * @return \Google\AdsApi\Dfp\v201802\ReconciliationLineItemReport[]
     */
    public function getRval()
    {
      return $this->rval;
    }

    /**
     * @param \Google\AdsApi\Dfp\v201802\ReconciliationLineItemReport[] $rval
     * @return \Google\AdsApi\Dfp\v201802\updateReconciliationLineItemReportsResponse
     */
    public function setRval(array $rval)
    {
      $this->rval = $rval;
      return $this;
    }

}
