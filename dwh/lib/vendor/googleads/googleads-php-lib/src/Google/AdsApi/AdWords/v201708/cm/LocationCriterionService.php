<?php

namespace Google\AdsApi\AdWords\v201708\cm;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class LocationCriterionService extends \Google\AdsApi\Common\AdsSoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'AdxError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdxError',
      'ApiError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApiError',
      'ApiException' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApiException',
      'ApplicationException' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApplicationException',
      'AuthenticationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AuthenticationError',
      'AuthorizationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AuthorizationError',
      'ClientTermsError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ClientTermsError',
      'Criterion' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Criterion',
      'DatabaseError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DatabaseError',
      'DateError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DateError',
      'DateRange' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DateRange',
      'DistinctError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DistinctError',
      'FieldPathElement' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\FieldPathElement',
      'IdError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\IdError',
      'InternalApiError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\InternalApiError',
      'Keyword' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Keyword',
      'Location' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Location',
      'LocationCriterion' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\LocationCriterion',
      'LocationCriterionServiceError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\LocationCriterionServiceError',
      'MobileAppCategory' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\MobileAppCategory',
      'MobileApplication' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\MobileApplication',
      'NotEmptyError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NotEmptyError',
      'NullError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NullError',
      'OperationAccessDenied' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OperationAccessDenied',
      'OperatorError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OperatorError',
      'OrderBy' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OrderBy',
      'Paging' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Paging',
      'Placement' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Placement',
      'Predicate' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Predicate',
      'QueryError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\QueryError',
      'QuotaCheckError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\QuotaCheckError',
      'RangeError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RangeError',
      'RateExceededError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RateExceededError',
      'ReadOnlyError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ReadOnlyError',
      'RejectedError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RejectedError',
      'RequestError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RequestError',
      'RequiredError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RequiredError',
      'Selector' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Selector',
      'SelectorError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SelectorError',
      'SizeLimitError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SizeLimitError',
      'SoapHeader' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SoapHeader',
      'SoapResponseHeader' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SoapResponseHeader',
      'StringFormatError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\StringFormatError',
      'StringLengthError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\StringLengthError',
      'CriterionUserInterest' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\CriterionUserInterest',
      'CriterionUserList' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\CriterionUserList',
      'Vertical' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Vertical',
      'getResponse' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\getResponse',
      'queryResponse' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\queryResponse',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(),
                $wsdl = 'https://adwords.google.com/api/adwords/cm/v201708/LocationCriterionService?wsdl')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      $options = array_merge(array (
      'features' => 1,
    ), $options);
      parent::__construct($wsdl, $options);
    }

    /**
     * Returns a list of {@link LocationCriterion}'s that match the specified selector.
     *
     * @param \Google\AdsApi\AdWords\v201708\cm\Selector $selector
     * @return \Google\AdsApi\AdWords\v201708\cm\LocationCriterion[]
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function get(\Google\AdsApi\AdWords\v201708\cm\Selector $selector)
    {
      return $this->__soapCall('get', array(array('selector' => $selector)))->getRval();
    }

    /**
     * Returns the list of {@link LocationCriterion}s that match the query.
     *
     * @param string $query
     * @return \Google\AdsApi\AdWords\v201708\cm\LocationCriterion[]
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function query($query)
    {
      return $this->__soapCall('query', array(array('query' => $query)))->getRval();
    }

}
