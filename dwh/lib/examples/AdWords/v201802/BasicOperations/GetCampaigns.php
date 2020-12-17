<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\AdsApi\Examples\AdWords\v201802\BasicOperations;

require __DIR__ . '/../../../../vendor/autoload.php';

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


class GetCampaigns
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

    public static function runExample(AdWordsServices $adWordsServices, AdWordsSession $session) {
        $campaignService = $adWordsServices->get($session, CampaignService::class);
        
        $selector = new Selector();
        $selector->setFields(['Id', 'Name', 'Status', 'ServingStatus', 'StartDate', 'EndDate', 'BudgetId', 'Eligible', 'AdServingOptimizationStatus', 'AdvertisingChannelType',
'AdvertisingChannelSubType', 'TargetGoogleSearch', 'TargetSearchNetwork', 'TargetContentNetwork', 'TargetPartnerSearchNetwork',
'BiddingStrategyId', 'TrackingUrlTemplate']);
        $selector->setOrdering([new OrderBy('Name', SortOrder::ASCENDING)]);
        $selector->setPaging(new Paging(0, self::PAGE_LIMIT));

        $totalNumEntries = 0;
        $i=0;
        do {
            $page = $campaignService->get($selector);

            if ($page->getEntries() !== null) {
                $totalNumEntries = $page->getTotalNumEntries();
                foreach ($page->getEntries() as $campaign) {
	            	$Id[$i]   = $campaign->getId();
	            	$Name[$i] = $campaign->getName();
	            	$Status[$i] = $campaign->getStatus();
	            	$ServingStatus[$i] = $campaign->getServingStatus();
	            	$StartDate[$i] = $campaign->getStartDate();
	            	$EndDate[$i] = $campaign->getEndDate();
	            	$BudgetId[$i] = $campaign->getBudget()->getBudgetId();
	            	$Eligible[$i] = $campaign->getConversionOptimizerEligibility()->getEligible();
	            	$AdServingOptimizationStatus[$i] = $campaign->getAdServingOptimizationStatus();
	            	$AdvertisingChannelType[$i] = $campaign->getAdvertisingChannelType();
	            	$AdvertisingChannelSubType[$i] = $campaign->getAdvertisingChannelSubType();
	            	$TargetGoogleSearch[$i] = $campaign->getNetworkSetting()->getTargetGoogleSearch();
	            	$TargetSearchNetwork[$i] = $campaign->getNetworkSetting()->getTargetSearchNetwork();
	            	$TargetContentNetwork[$i] = $campaign->getNetworkSetting()->getTargetContentNetwork();
	            	$TargetPartnerSearchNetwork[$i] = $campaign->getNetworkSetting()->getTargetPartnerSearchNetwork();
	            	$BiddingStrategyId[$i] = $campaign->getBiddingStrategyConfiguration();
	            	$TrackingUrlTemplate[$i] = $campaign->getTrackingUrlTemplate();
                    $i++;
                }
                
            }

            $selector->getPaging()->setStartIndex(
                $selector->getPaging()->getStartIndex() + self::PAGE_LIMIT
            );
            exit;
        } while ($selector->getPaging()->getStartIndex() < $totalNumEntries);

        printf("Number of results found: %d\n", $totalNumEntries);
        echo "<br>";
        //print_r($BiddingStrategyId);
    }

    public static function main()
    {      
      		$oAuth2Credential = (new OAuth2TokenBuilder())->withClientId("522558401318-4ru7mega01jdfe00fr3um4r84h80ip8u.apps.googleusercontent.com")->withClientSecret("8xhTUWODmpRevwrVcAylTsbw")->withRefreshToken("1/2fRVwMsFA_24RU9Kwwh52lkW-491tmp2Zlj_FuHLlVvLWeYXzGOCNIILTOekb9pd")->build();
      		
	   	  $session = (new AdWordsSessionBuilder())->withDeveloperToken("Wbhg0nhGJRyuZPSrr-TH8g")->withUserAgent("Dwh Synergy Controlcenter")->withClientCustomerId("756-124-2143")->withOAuth2Credential($oAuth2Credential)->build();
	   	  
        self::runExample(new AdWordsServices(), $session);
    }
}

GetCampaigns::main();
