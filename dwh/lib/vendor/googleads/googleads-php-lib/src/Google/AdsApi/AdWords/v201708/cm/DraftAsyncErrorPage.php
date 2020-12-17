<?php

namespace Google\AdsApi\AdWords\v201708\cm;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class DraftAsyncErrorPage extends \Google\AdsApi\AdWords\v201708\cm\Page
{

    /**
     * @var \Google\AdsApi\AdWords\v201708\cm\DraftAsyncError[] $entries
     */
    protected $entries = null;

    /**
     * @param int $totalNumEntries
     * @param string $PageType
     * @param \Google\AdsApi\AdWords\v201708\cm\DraftAsyncError[] $entries
     */
    public function __construct($totalNumEntries = null, $PageType = null, array $entries = null)
    {
      parent::__construct($totalNumEntries, $PageType);
      $this->entries = $entries;
    }

    /**
     * @return \Google\AdsApi\AdWords\v201708\cm\DraftAsyncError[]
     */
    public function getEntries()
    {
      return $this->entries;
    }

    /**
     * @param \Google\AdsApi\AdWords\v201708\cm\DraftAsyncError[] $entries
     * @return \Google\AdsApi\AdWords\v201708\cm\DraftAsyncErrorPage
     */
    public function setEntries(array $entries)
    {
      $this->entries = $entries;
      return $this;
    }

}
