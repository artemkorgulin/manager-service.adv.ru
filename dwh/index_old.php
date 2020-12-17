<?php
ini_set("soap.wsdl_cache_enabled", 0);

require	__DIR__ . "/lib/vendor/autoload.php";
require __DIR__ . "/Campaigns.php";

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
use Spatie\ArrayToXml\ArrayToXml;

function getCampaigns($clientId, $clientSecret, $refreshToken, $developerToken, $userAgent, $clientCustomerId) {

	if (!$clientId || !$clientSecret || !$refreshToken || !$developerToken || !$userAgent || !$clientCustomerId) {
		return new soap_fault('Parametr','No require parametr');
	}

	$campaigns = new Campaigns($clientId, $clientSecret, $refreshToken, $developerToken, $userAgent, $clientCustomerId);
//	$xml = new SimpleXMLElement('<root/>');
//	for ($i=0;$i<count($campaigns::getCampaigns());$i++) {
//		array_walk_recursive($campaigns::getCampaigns()[$i],[$xml, 'addChild']);
	//}

	//return ArrayToXml::convert($campaigns::getCampaigns()); //$xml->asXML();
	return '<?xml version="1.0" encoding="UTF-8"?>
<note>
  <to>Tove</to>
  <from>Jani</from>
  <heading>Reminder</heading>
  <body>Dont forget me this weekend!</body>
</note>';

}

$server = new soap_server();
$server->configureWSDL('SynergyDWH','https://syn.su/dwh/index.php');
$server->wsdl->schemaTargetNamespace = 'https://syn.su/dwh/index.php';



$server->register("getCampaigns",
				['clientId'=>'xsd:string', 'clientSecret'=>'xsd:string', 'refreshToken'=>'xsd:string', 'developerToken'=>'xsd:string', 'userAgent'=>'xsd:string', 'clientCustomerId'=>'xsd:string'],
				['return'=>'xsd:string'],
				"https://syn.su/dwh/index.php",
				'urn:https://syn.su/dwh/?wsdl',
				'rpc',
				'encoded',
				'dwh'
);

	$server->service(file_get_contents('php://input'));


/*if (isset($_REQUEST['result'])) {
	header("Content-type: text/xml");
	print_r(getCampaigns("522558401318-4ru7mega01jdfe00fr3um4r84h80ip8u.apps.googleusercontent.com", "8xhTUWODmpRevwrVcAylTsbw", "1/2fRVwMsFA_24RU9Kwwh52lkW-491tmp2Zlj_FuHLlVvLWeYXzGOCNIILTOekb9pd", "Wbhg0nhGJRyuZPSrr-TH8g", "Dwh Synergy Controlcenter", "756-124-2143"));
}
*/


?>