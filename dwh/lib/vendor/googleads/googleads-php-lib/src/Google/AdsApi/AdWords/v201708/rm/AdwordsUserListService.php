<?php

namespace Google\AdsApi\AdWords\v201708\rm;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class AdwordsUserListService extends \Google\AdsApi\Common\AdsSoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'AuthenticationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AuthenticationError',
      'AuthorizationError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\AuthorizationError',
      'CollectionSizeError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\CollectionSizeError',
      'DateError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DateError',
      'DateRange' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DateRange',
      'DistinctError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DistinctError',
      'EntityNotFound' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\EntityNotFound',
      'FieldPathElement' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\FieldPathElement',
      'InternalApiError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\InternalApiError',
      'NotEmptyError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NotEmptyError',
      'NotWhitelistedError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NotWhitelistedError',
      'NullError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\NullError',
      'OperationAccessDenied' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OperationAccessDenied',
      'OperatorError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OperatorError',
      'OrderBy' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\OrderBy',
      'Paging' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Paging',
      'Predicate' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Predicate',
      'QueryError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\QueryError',
      'QuotaCheckError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\QuotaCheckError',
      'RangeError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RangeError',
      'RateExceededError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RateExceededError',
      'ReadOnlyError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ReadOnlyError',
      'RejectedError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RejectedError',
      'RequestError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RequestError',
      'RequiredError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\RequiredError',
      'SelectorError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SelectorError',
      'SizeLimitError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SizeLimitError',
      'SoapHeader' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SoapHeader',
      'SoapResponseHeader' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\SoapResponseHeader',
      'StringFormatError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\StringFormatError',
      'StringLengthError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\StringLengthError',
      'DatabaseError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\DatabaseError',
      'ApiError' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApiError',
      'ApiException' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApiException',
      'ApplicationException' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ApplicationException',
      'Selector' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Selector',
      'ListReturnValue' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\ListReturnValue',
      'Operation' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Operation',
      'Page' => 'Google\\AdsApi\\AdWords\\v201708\\cm\\Page',
      'AddressInfo' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\AddressInfo',
      'CombinedRuleUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\CombinedRuleUserList',
      'UserListConversionType' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\UserListConversionType',
      'CrmBasedUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\CrmBasedUserList',
      'DataUploadResult' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\DataUploadResult',
      'DateKey' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\DateKey',
      'DateRuleItem' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\DateRuleItem',
      'DateSpecificRuleUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\DateSpecificRuleUserList',
      'ExpressionRuleUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\ExpressionRuleUserList',
      'LogicalUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\LogicalUserList',
      'LogicalUserListOperand' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\LogicalUserListOperand',
      'Member' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\Member',
      'MutateMembersError' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\MutateMembersError',
      'MutateMembersOperand' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\MutateMembersOperand',
      'MutateMembersOperation' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\MutateMembersOperation',
      'MutateMembersReturnValue' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\MutateMembersReturnValue',
      'NumberKey' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\NumberKey',
      'NumberRuleItem' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\NumberRuleItem',
      'RelativeDate' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\RelativeDate',
      'BasicUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\BasicUserList',
      'Rule' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\Rule',
      'RuleBasedUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\RuleBasedUserList',
      'RuleItem' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\RuleItem',
      'RuleItemGroup' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\RuleItemGroup',
      'SimilarUserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\SimilarUserList',
      'StringKey' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\StringKey',
      'StringRuleItem' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\StringRuleItem',
      'UserList' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\UserList',
      'UserListError' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\UserListError',
      'UserListLogicalRule' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\UserListLogicalRule',
      'UserListOperation' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\UserListOperation',
      'UserListPage' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\UserListPage',
      'UserListReturnValue' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\UserListReturnValue',
      'getResponse' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\getResponse',
      'mutateResponse' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\mutateResponse',
      'mutateMembersResponse' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\mutateMembersResponse',
      'queryResponse' => 'Google\\AdsApi\\AdWords\\v201708\\rm\\queryResponse',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(),
                $wsdl = 'https://adwords.google.com/api/adwords/rm/v201708/AdwordsUserListService?wsdl')
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
     * Returns the list of user lists that meet the selector criteria.
     *
     * @param \Google\AdsApi\AdWords\v201708\cm\Selector $serviceSelector
     * @return \Google\AdsApi\AdWords\v201708\rm\UserListPage
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function get(\Google\AdsApi\AdWords\v201708\cm\Selector $serviceSelector)
    {
      return $this->__soapCall('get', array(array('serviceSelector' => $serviceSelector)))->getRval();
    }

    /**
     * Applies a list of mutate operations (i.e. add, set):
     *
     * Add - creates a set of user lists
     * Set - updates a set of user lists
     * Remove - not supported
     *
     * @param \Google\AdsApi\AdWords\v201708\rm\UserListOperation[] $operations
     * @return \Google\AdsApi\AdWords\v201708\rm\UserListReturnValue
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function mutate(array $operations)
    {
      return $this->__soapCall('mutate', array(array('operations' => $operations)))->getRval();
    }

    /**
     * Mutate members of user lists by either adding or removing their lists of members.
     * The following {@link Operator}s are supported: ADD and REMOVE. The SET operator
     * is not supported.
     *
     * <p>Note that operations cannot have same user list id but different operators.
     *
     * @param \Google\AdsApi\AdWords\v201708\rm\MutateMembersOperation[] $operations
     * @return \Google\AdsApi\AdWords\v201708\rm\MutateMembersReturnValue
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function mutateMembers(array $operations)
    {
      return $this->__soapCall('mutateMembers', array(array('operations' => $operations)))->getRval();
    }

    /**
     * Returns the list of user lists that match the query.
     *
     * @param string $query
     * @return \Google\AdsApi\AdWords\v201708\rm\UserListPage
     * @throws \Google\AdsApi\AdWords\v201708\cm\ApiException
     */
    public function query($query)
    {
      return $this->__soapCall('query', array(array('query' => $query)))->getRval();
    }

}
