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

class DWH {
	/**
     * getCampaigns.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $refreshToken
     * @param string $developerToken
     * @param string $userAgent
     * @param string $clientCustomerId
     * @return string
     */
	public function getCampaigns($clientId, $clientSecret, $refreshToken, $developerToken, $userAgent, $clientCustomerId) {
		$campaigns = new Campaigns($clientId, $clientSecret, $refreshToken, $developerToken, $userAgent, $clientCustomerId);
		return new SoapVar($campaigns::getCampaigns(), SOAP_ENC_OBJECT);
	}
}


$serverUrl = "https://syn.su/dwh/index.php";

$options = [
    'uri' => $serverUrl,
];

$server = new Zend\Soap\Server(null, $options);


if (isset($_GET['wsdl'])) {
    $soapAutoDiscover = new \Zend\Soap\AutoDiscover(new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeComplex());
    $soapAutoDiscover->setBindingStyle(array('style' => 'document'));
    $soapAutoDiscover->setOperationBodyStyle(array('use' => 'literal'));
    $soapAutoDiscover->setClass('DWH');
    $soapAutoDiscover->setUri($serverUrl);
    header("Content-Type: text/xml");
    echo $soapAutoDiscover->generate()->toXml();
} else {
    $soap = new \Zend\Soap\Server($serverUrl . '?wsdl');
    $soap->setObject(new \Zend\Soap\Server\DocumentLiteralWrapper(new DWH()));
    $soap->handle();
}

/*if (isset($_REQUEST['result'])) {
	header("Content-type: text/xml");
	print_r(getCampaigns("522558401318-4ru7mega01jdfe00fr3um4r84h80ip8u.apps.googleusercontent.com", "8xhTUWODmpRevwrVcAylTsbw", "1/2fRVwMsFA_24RU9Kwwh52lkW-491tmp2Zlj_FuHLlVvLWeYXzGOCNIILTOekb9pd", "Wbhg0nhGJRyuZPSrr-TH8g", "Dwh Synergy Controlcenter", "756-124-2143"));
}
*/
?>