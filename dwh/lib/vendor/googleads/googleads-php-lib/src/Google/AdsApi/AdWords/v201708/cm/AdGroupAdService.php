<?php

namespace Google\AdsApi\AdWords\v201708\cm;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class AdGroupAdService extends \Google\AdsApi\Common\AdsSoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'Ad' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Ad',
      'AdCustomizerError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdCustomizerError',
      'AdError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdError',
      'AdGroupAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAd',
      'AdGroupAdCountLimitExceeded' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdCountLimitExceeded',
      'AdGroupAdError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdError',
      'AdGroupAdLabel' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdLabel',
      'AdGroupAdLabelOperation' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdLabelOperation',
      'AdGroupAdLabelReturnValue' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdLabelReturnValue',
      'AdGroupAdOperation' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdOperation',
      'AdGroupAdPage' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdPage',
      'AdGroupAdPolicySummary' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdPolicySummary',
      'AdGroupAdReturnValue' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdGroupAdReturnValue',
      'AdSharingError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdSharingError',
      'AdUnionId' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdUnionId',
      'AdxError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AdxError',
      'ApiError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApiError',
      'ApiException' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApiException',
      'AppUrl' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AppUrl',
      'ApplicationException' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApplicationException',
      'LabelAttribute' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\LabelAttribute',
      'Audio' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Audio',
      'AuthenticationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AuthenticationError',
      'AuthorizationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AuthorizationError',
      'CallOnlyAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\CallOnlyAd',
      'TextLabel' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\TextLabel',
      'DisplayAttribute' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DisplayAttribute',
      'ClientTermsError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ClientTermsError',
      'CountryConstraint' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\CountryConstraint',
      'CustomParameter' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\CustomParameter',
      'CustomParameters' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\CustomParameters',
      'DatabaseError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DatabaseError',
      'DateError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DateError',
      'DateRange' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DateRange',
      'DeprecatedAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DeprecatedAd',
      'Dimensions' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Dimensions',
      'DistinctError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DistinctError',
      'DynamicSettings' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DynamicSettings',
      'EntityAccessDenied' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\EntityAccessDenied',
      'EntityCountLimitExceeded' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\EntityCountLimitExceeded',
      'EntityNotFound' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\EntityNotFound',
      'ExemptionRequest' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ExemptionRequest',
      'ExpandedDynamicSearchAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ExpandedDynamicSearchAd',
      'ExpandedTextAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ExpandedTextAd',
      'FeedAttributeReferenceError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\FeedAttributeReferenceError',
      'FieldPathElement' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\FieldPathElement',
      'ForwardCompatibilityError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ForwardCompatibilityError',
      'FunctionError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\FunctionError',
      'FunctionParsingError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\FunctionParsingError',
      'IdError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\IdError',
      'Image' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Image',
      'ImageAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ImageAd',
      'ImageError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ImageError',
      'InternalApiError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\InternalApiError',
      'Label' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Label',
      'ListReturnValue' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ListReturnValue',
      'Media' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Media',
      'MediaBundle' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\MediaBundle',
      'MediaBundleError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\MediaBundleError',
      'MediaError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\MediaError',
      'Media_Size_DimensionsMapEntry' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Media_Size_DimensionsMapEntry',
      'Media_Size_StringMapEntry' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Media_Size_StringMapEntry',
      'NewEntityCreationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NewEntityCreationError',
      'NotEmptyError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NotEmptyError',
      'NullError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NullError',
      'Operation' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Operation',
      'OperationAccessDenied' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OperationAccessDenied',
      'OperatorError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OperatorError',
      'OrderBy' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OrderBy',
      'Page' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Page',
      'Paging' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Paging',
      'PagingError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\PagingError',
      'PolicyTopicConstraint' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\PolicyTopicConstraint',
      'PolicyTopicEntry' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\PolicyTopicEntry',
      'PolicyTopicEvidence' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\PolicyTopicEvidence',
      'PolicyViolationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\PolicyViolationError',
      'PolicyViolationError.Part' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\PolicyViolationErrorPart',
      'PolicyViolationKey' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\PolicyViolationKey',
      'Predicate' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Predicate',
      'ProductAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ProductAd',
      'QueryError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\QueryError',
      'QuotaCheckError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\QuotaCheckError',
      'RangeError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RangeError',
      'RateExceededError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RateExceededError',
      'ReadOnlyError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ReadOnlyError',
      'RejectedError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RejectedError',
      'RequestError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RequestError',
      'RequiredError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RequiredError',
      'ResponsiveDisplayAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ResponsiveDisplayAd',
      'RichMediaAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RichMediaAd',
      'Selector' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Selector',
      'SelectorError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SelectorError',
      'ShowcaseAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ShowcaseAd',
      'SizeLimitError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SizeLimitError',
      'SoapHeader' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SoapHeader',
      'SoapResponseHeader' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SoapResponseHeader',
      'StatsQueryError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\StatsQueryError',
      'StringFormatError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\StringFormatError',
      'StringLengthError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\StringLengthError',
      'String_StringMapEntry' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\String_StringMapEntry',
      'TempAdUnionId' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\TempAdUnionId',
      'TemplateAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\TemplateAd',
      'TemplateElement' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\TemplateElement',
      'TemplateElementField' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\TemplateElementField',
      'TextAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\TextAd',
      'ThirdPartyRedirectAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ThirdPartyRedirectAd',
      'UrlData' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\UrlData',
      'UrlError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\UrlError',
      'UrlList' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\UrlList',
      'Video' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Video',
      'DynamicSearchAd' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DynamicSearchAd',
      'getResponse' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\getResponse',
      'mutateResponse' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\mutateResponse',
      'mutateLabelResponse' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\mutateLabelResponse',
      'queryResponse' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\queryResponse',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(),
                $wsdl = 'https://adwords.google.com/api/adwords/cm/v201708/AdGroupAdService?wsdl')
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
     * Returns a list of AdGroupAds.
     * AdGroupAds that had been removed are not returned by default.
     *
     * @param \Google\AdsApi\AdWords\v201708\cm\Selector $serviceSelector
     * @return \Google\AdsApi\AdWords\v201708\cm\AdGroupAdPage
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function get(\Google\AdsApi\AdWords\v201708\cm\Selector $serviceSelector)
    {
      return $this->__soapCall('get', array(array('serviceSelector' => $serviceSelector)))->getRval();
    }

    /**
     * Applies the list of mutate operations (ie. add, set, remove):
     * <p>Add - Creates a new {@linkplain AdGroupAd ad group ad}. The
     * {@code adGroupId} must
     * reference an existing ad group. The child {@code Ad} must be sufficiently
     * specified by constructing a concrete ad type (such as {@code TextAd})
     * and setting its fields accordingly.</p>
     * <p>Set - Updates an ad group ad. Except for {@code status},
     * ad group ad fields are not mutable. Status updates are
     * straightforward - the status of the ad group ad is updated as
     * specified. If any other field has changed, it will be ignored. If
     * you want to change any of the fields other than status, you must
     * make a new ad and then remove the old one.</p>
     * <p>Remove - Removes the link between the specified AdGroup and
     * Ad.</p>
     * applying the operation in the input list with the same index. For an
     * add/set operation, the return AdGroupAd will be what is saved to the db.
     * In the case of the remove operation, the return AdGroupAd will simply be
     * an AdGroupAd containing an Ad with the id set to the Ad being removed from
     * the AdGroup.
     *
     * @param \Google\AdsApi\AdWords\v201708\cm\AdGroupAdOperation[] $operations
     * @return \Google\AdsApi\AdWords\v201708\cm\AdGroupAdReturnValue
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function mutate(array $operations)
    {
      return $this->__soapCall('mutate', array(array('operations' => $operations)))->getRval();
    }

    /**
     * Adds labels to the AdGroupAd or removes labels from the AdGroupAd.
     * <p>Add - Apply an existing label to an existing {@linkplain AdGroupAd ad group ad}. The
     * {@code adGroupId} and {@code adId} must reference an existing
     * {@linkplain AdGroupAd ad group ad}. The {@code labelId} must reference an existing
     * {@linkplain Label label}.
     * <p>Remove - Removes the link between the specified {@linkplain AdGroupAd ad group ad} and
     * {@linkplain Label label}.
     * applying the operation in the input list with the same index. For an
     * add operation, the returned AdGroupAdLabel contains the AdGroupId, AdId and the LabelId.
     * In the case of a remove operation, the returned AdGroupAdLabel will only have AdGroupId and
     * AdId.
     *
     * @param \Google\AdsApi\AdWords\v201708\cm\AdGroupAdLabelOperation[] $operations
     * @return \Google\AdsApi\AdWords\v201708\cm\AdGroupAdLabelReturnValue
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function mutateLabel(array $operations)
    {
      return $this->__soapCall('mutateLabel', array(array('operations' => $operations)))->getRval();
    }

    /**
     * Returns a list of AdGroupAds based on the query.
     *
     * @param string $query
     * @return \Google\AdsApi\AdWords\v201708\cm\AdGroupAdPage
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function query($query)
    {
      return $this->__soapCall('query', array(array('query' => $query)))->getRval();
    }

}
