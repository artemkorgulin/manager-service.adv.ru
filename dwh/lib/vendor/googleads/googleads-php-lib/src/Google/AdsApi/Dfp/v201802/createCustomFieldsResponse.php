<?php

namespace Google\AdsApi\Dfp\v201802;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class createCustomFieldsResponse
{

    /**
     * @var \Google\AdsApi\Dfp\v201802\CustomField[] $rval
     */
    protected $rval = null;

    /**
     * @param \Google\AdsApi\Dfp\v201802\CustomField[] $rval
     */
    public function __construct(array $rval = null)
    {
      $this->rval = $rval;
    }

    /**
     * @return \Google\AdsApi\Dfp\v201802\CustomField[]
     */
    public function getRval()
    {
      return $this->rval;
    }

    /**
     * @param \Google\AdsApi\Dfp\v201802\CustomField[] $rval
     * @return \Google\AdsApi\Dfp\v201802\createCustomFieldsResponse
     */
    public function setRval(array $rval)
    {
      $this->rval = $rval;
      return $this;
    }

}
