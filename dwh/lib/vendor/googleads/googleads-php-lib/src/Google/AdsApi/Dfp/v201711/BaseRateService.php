<?php

namespace Google\AdsApi\Dfp\v201711;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class BaseRateService extends \Google\AdsApi\Common\AdsSoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'ObjectValue' => 'Google\\AdsApi\\Dfp\\v201711\\ObjectValue',
      'ApiError' => 'Google\\AdsApi\\Dfp\\v201711\\ApiError',
      'ApiException' => 'Google\\AdsApi\\Dfp\\v201711\\ApiException',
      'ApiVersionError' => 'Google\\AdsApi\\Dfp\\v201711\\ApiVersionError',
      'ApplicationException' => 'Google\\AdsApi\\Dfp\\v201711\\ApplicationException',
      'AuthenticationError' => 'Google\\AdsApi\\Dfp\\v201711\\AuthenticationError',
      'BaseRateAction' => 'Google\\AdsApi\\Dfp\\v201711\\BaseRateAction',
      'BaseRateActionError' => 'Google\\AdsApi\\Dfp\\v201711\\BaseRateActionError',
      'BaseRate' => 'Google\\AdsApi\\Dfp\\v201711\\BaseRate',
      'BaseRateError' => 'Google\\AdsApi\\Dfp\\v201711\\BaseRateError',
      'BaseRatePage' => 'Google\\AdsApi\\Dfp\\v201711\\BaseRatePage',
      'BooleanValue' => 'Google\\AdsApi\\Dfp\\v201711\\BooleanValue',
      'CollectionSizeError' => 'Google\\AdsApi\\Dfp\\v201711\\CollectionSizeError',
      'CommonError' => 'Google\\AdsApi\\Dfp\\v201711\\CommonError',
      'Date' => 'Google\\AdsApi\\Dfp\\v201711\\Date',
      'DateTime' => 'Google\\AdsApi\\Dfp\\v201711\\DateTime',
      'DateTimeValue' => 'Google\\AdsApi\\Dfp\\v201711\\DateTimeValue',
      'DateValue' => 'Google\\AdsApi\\Dfp\\v201711\\DateValue',
      'DeleteBaseRates' => 'Google\\AdsApi\\Dfp\\v201711\\DeleteBaseRates',
      'EntityChildrenLimitReachedError' => 'Google\\AdsApi\\Dfp\\v201711\\EntityChildrenLimitReachedError',
      'FeatureError' => 'Google\\AdsApi\\Dfp\\v201711\\FeatureError',
      'FieldPathElement' => 'Google\\AdsApi\\Dfp\\v201711\\FieldPathElement',
      'InternalApiError' => 'Google\\AdsApi\\Dfp\\v201711\\InternalApiError',
      'Money' => 'Google\\AdsApi\\Dfp\\v201711\\Money',
      'NotNullError' => 'Google\\AdsApi\\Dfp\\v201711\\NotNullError',
      'NullError' => 'Google\\AdsApi\\Dfp\\v201711\\NullError',
      'NumberValue' => 'Google\\AdsApi\\Dfp\\v201711\\NumberValue',
      'ParseError' => 'Google\\AdsApi\\Dfp\\v201711\\ParseError',
      'PermissionError' => 'Google\\AdsApi\\Dfp\\v201711\\PermissionError',
      'ProductBaseRate' => 'Google\\AdsApi\\Dfp\\v201711\\ProductBaseRate',
      'ProductPackageItemBaseRate' => 'Google\\AdsApi\\Dfp\\v201711\\ProductPackageItemBaseRate',
      'ProductTemplateBaseRate' => 'Google\\AdsApi\\Dfp\\v201711\\ProductTemplateBaseRate',
      'PublisherQueryLanguageContextError' => 'Google\\AdsApi\\Dfp\\v201711\\PublisherQueryLanguageContextError',
      'PublisherQueryLanguageSyntaxError' => 'Google\\AdsApi\\Dfp\\v201711\\PublisherQueryLanguageSyntaxError',
      'QuotaError' => 'Google\\AdsApi\\Dfp\\v201711\\QuotaError',
      'RangeError' => 'Google\\AdsApi\\Dfp\\v201711\\RangeError',
      'RequiredCollectionError' => 'Google\\AdsApi\\Dfp\\v201711\\RequiredCollectionError',
      'RequiredError' => 'Google\\AdsApi\\Dfp\\v201711\\RequiredError',
      'ServerError' => 'Google\\AdsApi\\Dfp\\v201711\\ServerError',
      'SetValue' => 'Google\\AdsApi\\Dfp\\v201711\\SetValue',
      'SoapRequestHeader' => 'Google\\AdsApi\\Dfp\\v201711\\SoapRequestHeader',
      'SoapResponseHeader' => 'Google\\AdsApi\\Dfp\\v201711\\SoapResponseHeader',
      'Statement' => 'Google\\AdsApi\\Dfp\\v201711\\Statement',
      'StatementError' => 'Google\\AdsApi\\Dfp\\v201711\\StatementError',
      'StringFormatError' => 'Google\\AdsApi\\Dfp\\v201711\\StringFormatError',
      'StringLengthError' => 'Google\\AdsApi\\Dfp\\v201711\\StringLengthError',
      'String_ValueMapEntry' => 'Google\\AdsApi\\Dfp\\v201711\\String_ValueMapEntry',
      'TextValue' => 'Google\\AdsApi\\Dfp\\v201711\\TextValue',
      'UnknownBaseRate' => 'Google\\AdsApi\\Dfp\\v201711\\UnknownBaseRate',
      'UpdateResult' => 'Google\\AdsApi\\Dfp\\v201711\\UpdateResult',
      'Value' => 'Google\\AdsApi\\Dfp\\v201711\\Value',
      'createBaseRatesResponse' => 'Google\\AdsApi\\Dfp\\v201711\\createBaseRatesResponse',
      'getBaseRatesByStatementResponse' => 'Google\\AdsApi\\Dfp\\v201711\\getBaseRatesByStatementResponse',
      'performBaseRateActionResponse' => 'Google\\AdsApi\\Dfp\\v201711\\performBaseRateActionResponse',
      'updateBaseRatesResponse' => 'Google\\AdsApi\\Dfp\\v201711\\updateBaseRatesResponse',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(),
                $wsdl = 'https://ads.google.com/apis/ads/publisher/v201711/BaseRateService?wsdl')
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
     * Creates a list of new {@link BaseRate} objects.
     *
     * @param \Google\AdsApi\Dfp\v201711\BaseRate[] $baseRates
     * @return \Google\AdsApi\Dfp\v201711\BaseRate[]
     * @throws \Google\AdsApi\Dfp\v201711\ApiException
     */
    public function createBaseRates(array $baseRates)
    {
      return $this->__soapCall('createBaseRates', array(array('baseRates' => $baseRates)))->getRval();
    }

    /**
     * Gets a {@link BaseRatePage} of {@link BaseRate} objects that satisfy the given
     * {@link Statement#query}.
     *
     * The following fields are supported for filtering:
     *
     * <table>
     * <tr>
     * <th scope="col">PQL Property</th>
     * <th scope="col">Object Property</th>
     * </tr>
     * <tr>
     * <td>{@code rateCardId}</td>
     * <td>{@link BaseRate#rateCardId}</td>
     * </tr>
     * <tr>
     * <td>{@code id}</td>
     * <td>{@link BaseRate#id}</td>
     * </tr>
     * <tr>
     * <td>{@code productTemplateId}</td>
     * <td>{@link ProductTemplateBaseRate#id}<br><b>Note:</b>&nbsp;Cannot be
     * combined with {@code productId}.
     * </tr>
     * <td>{@code productId}</td>
     * <td>{@link ProductBaseRate#id}<br><b>Note:</b>&nbsp;Cannot be combined with
     * {@code productTemplateId}.
     * </tr>
     *
     * a set of base rates.
     *
     * @param \Google\AdsApi\Dfp\v201711\Statement $filterStatement
     * @return \Google\AdsApi\Dfp\v201711\BaseRatePage
     * @throws \Google\AdsApi\Dfp\v201711\ApiException
     */
    public function getBaseRatesByStatement(\Google\AdsApi\Dfp\v201711\Statement $filterStatement)
    {
      return $this->__soapCall('getBaseRatesByStatement', array(array('filterStatement' => $filterStatement)))->getRval();
    }

    /**
     * Performs actions on {@link BaseRate} objects that satisfy the given
     * {@link Statement#query}.
     *
     * a set of base rates.
     *
     * @param \Google\AdsApi\Dfp\v201711\BaseRateAction $baseRateAction
     * @param \Google\AdsApi\Dfp\v201711\Statement $filterStatement
     * @return \Google\AdsApi\Dfp\v201711\UpdateResult
     * @throws \Google\AdsApi\Dfp\v201711\ApiException
     */
    public function performBaseRateAction(\Google\AdsApi\Dfp\v201711\BaseRateAction $baseRateAction, \Google\AdsApi\Dfp\v201711\Statement $filterStatement)
    {
      return $this->__soapCall('performBaseRateAction', array(array('baseRateAction' => $baseRateAction, 'filterStatement' => $filterStatement)))->getRval();
    }

    /**
     * Updates the specified {@link BaseRate} objects.
     *
     * @param \Google\AdsApi\Dfp\v201711\BaseRate[] $baseRates
     * @return \Google\AdsApi\Dfp\v201711\BaseRate[]
     * @throws \Google\AdsApi\Dfp\v201711\ApiException
     */
    public function updateBaseRates(array $baseRates)
    {
      return $this->__soapCall('updateBaseRates', array(array('baseRates' => $baseRates)))->getRval();
    }

}
