<?php

namespace Google\AdsApi\AdWords\v201708\cm;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class FeedItemGeoRestriction
{

    /**
     * @var string $geoRestriction
     */
    protected $geoRestriction = null;

    /**
     * @param string $geoRestriction
     */
    public function __construct($geoRestriction = null)
    {
      $this->geoRestriction = $geoRestriction;
    }

    /**
     * @return string
     */
    public function getGeoRestriction()
    {
      return $this->geoRestriction;
    }

    /**
     * @param string $geoRestriction
     * @return \Google\AdsApi\AdWords\v201708\cm\FeedItemGeoRestriction
     */
    public function setGeoRestriction($geoRestriction)
    {
      $this->geoRestriction = $geoRestriction;
      return $this;
    }

}
