<?php

require __DIR__ . '/lib/vendor/autoload.php';

use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\v201802\cm\CampaignService;
use Google\AdsApi\AdWords\v201802\cm\OrderBy;
use Google\AdsApi\AdWords\v201802\cm\Paging;
use Google\AdsApi\AdWords\v201802\cm\Selector;
use Google\AdsApi\AdWords\v201802\cm\SortOrder;
use Google\AdsApi\AdWords\v201802\cm\NetworkSetting;
use Google\AdsApi\AdWords\v201802\cm\Budget;
use Google\AdsApi\AdWords\v201802\cm\ConversionOptimizerEligibility;
use Google\AdsApi\Common\OAuth2TokenBuilder;


class Campaigns
{

    const PAGE_LIMIT = 500;
    
    private $Id = [];
    private $Name = [];
    private $Status = []; 
    private $ServingStatus = [];  
    private $StartDate = []; 
    private $EndDate = [];
    private $BudgetId = []; 
    private $Eligible = [];
    private $AdServingOptimizationStatus = [];
    private $AdvertisingChannelType = [];
	private $AdvertisingChannelSubType = [];
	private $TargetGoogleSearch = [];
	private $TargetSearchNetwork = [];
	private $TargetContentNetwork = [];
	private $TargetPartnerSearchNetwork = [];
	private $BiddingStrategyId = [];
	private $TrackingUrlTemplate = [];
	private static $ClientId;
	private static $ClientSecret;
	private static $RefreshToken;
	private static $DeveloperToken;
	private static $UserAgent;
	private static $ClientCustomerId;
	private static $Session;
	
	
	//("522558401318-4ru7mega01jdfe00fr3um4r84h80ip8u.apps.googleusercontent.com", "8xhTUWODmpRevwrVcAylTsbw", "1/2fRVwMsFA_24RU9Kwwh52lkW-491tmp2Zlj_FuHLlVvLWeYXzGOCNIILTOekb9pd", "Wbhg0nhGJRyuZPSrr-TH8g", "Dwh Synergy Controlcenter", "756-124-2143")
	public function __construct($clientId, $clientSecret, $refreshToken, $developerToken, $userAgent, $clientCustomerId) {
		 self::$ClientId = $clientId;
		 self::$ClientSecret = $clientSecret;
		 self::$RefreshToken = $refreshToken;
		 self::$DeveloperToken =  $developerToken;
		 self::$UserAgent = $userAgent;
		 self::$ClientCustomerId = $clientCustomerId;
		 $oAuth2Credential = (new OAuth2TokenBuilder())->withClientId($clientId)->withClientSecret($clientSecret)->withRefreshToken($refreshToken)->build();	
	   	 self::$Session = (new AdWordsSessionBuilder())->withDeveloperToken($developerToken)->withUserAgent($userAgent)->withClientCustomerId($clientCustomerId)->withOAuth2Credential($oAuth2Credential)->build();
	}

    public static function getCampaigns() {
	    $adWordsServices = new AdWordsServices();
        $campaignService = $adWordsServices->get(self::$Session, CampaignService::class);
        $selector = new Selector();
        $selector->setFields(['Id', 'Name', 'Status', 'ServingStatus', 'StartDate', 'EndDate', 'BudgetId', 'Eligible', 'AdServingOptimizationStatus', 'AdvertisingChannelType',
'AdvertisingChannelSubType', 'TargetGoogleSearch', 'TargetSearchNetwork', 'TargetContentNetwork', 'TargetPartnerSearchNetwork',
'BiddingStrategyId', 'TrackingUrlTemplate','Labels']);
        $selector->setOrdering([new OrderBy('Name', SortOrder::ASCENDING)]);
        $selector->setPaging(new Paging(0, self::PAGE_LIMIT));
		$result = [];
        $totalNumEntries = 0;
        $i=0;
        do {
            $page = $campaignService->get($selector);
            if ($page->getEntries() !== null) {
                $totalNumEntries = $page->getTotalNumEntries();
                foreach ($page->getEntries() as $campaign) {
	            	$result['items'.$i]['Id']   = $campaign->getId();
	            	$result['items'.$i]['Name'] = $campaign->getName();
	            	$result['items'.$i]['Status'] = $campaign->getStatus();
	            	$result['items'.$i]['ServingStatus'] = $campaign->getServingStatus();
	            	$result['items'.$i]['StartDate'] = $campaign->getStartDate();
	            	$result['items'.$i]['EndDate'] = $campaign->getEndDate();
	            	$result['items'.$i]['BudgetId'] = $campaign->getBudget()->getBudgetId();
	            	$result['items'.$i]['Eligible'] = $campaign->getConversionOptimizerEligibility()->getEligible();
	            	$result['items'.$i]['AdServingOptimizationStatus'] = $campaign->getAdServingOptimizationStatus();
	            	$result['items'.$i]['AdvertisingChannelType'] = $campaign->getAdvertisingChannelType();
	            	$result['items'.$i]['AdvertisingChannelSubType'] = $campaign->getAdvertisingChannelSubType();
	            	$result['items'.$i]['TargetGoogleSearch'] = $campaign->getNetworkSetting()->getTargetGoogleSearch();
	            	$result['items'.$i]['TargetSearchNetwork'] = $campaign->getNetworkSetting()->getTargetSearchNetwork();
	            	$result['items'.$i]['TargetContentNetwork'] = $campaign->getNetworkSetting()->getTargetContentNetwork();
	            	$result['items'.$i]['TargetPartnerSearchNetwork'] = $campaign->getNetworkSetting()->getTargetPartnerSearchNetwork();
	            	$result['items'.$i]['BiddingStrategyId'] = $campaign->getBiddingStrategyConfiguration();
	            	$result['items'.$i]['TrackingUrlTemplate'] = $campaign->getTrackingUrlTemplate();
	            	$result['items'.$i]['RejectionReasons'] = $campaign->getConversionOptimizerEligibility()->getRejectionReasons();
					$result['items'.$i]['Labels'] = $campaign->getLabels();
                    $i++;
                }                
            }
            $selector->getPaging()->setStartIndex(
                $selector->getPaging()->getStartIndex() + self::PAGE_LIMIT
            );
        } while ($selector->getPaging()->getStartIndex() < $totalNumEntries);
        return $result;
    }
}