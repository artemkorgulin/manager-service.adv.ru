<?php
require 'requires.php';

define('API_URL', 'https://syn.su/api/');

$method = $_SERVER['REQUEST_METHOD'];


$phpinput = file_get_contents('php://input');
$json = json_decode($phpinput);


$logger = new logger();
$logger::add($phpinput);

$request = new Request();

$error = null;
$response = null;

$mysql = new MySQL($config);
$pdo = $mysql::createConnection();



if ($json->token == 'a202dfb21d529c783e8c4851be62fb77' || $_POST['token'] == 'a202dfb21d529c783e8c4851be62fb77') {
	switch ($json->model) {
		case 'Events':
			$events = new Events($pdo);
			switch ($json->method) {
				case 'get':
					$response = $events::getEvents();
					break;

				case 'getEventsByEventId':
					$response = $events::getEventsByEventId($json->eventId);
					break;

				case 'getEventsByCRMId':
					$response = $events::getEventsByCRMId($json->eventId);
					break;

				case 'add':
					$response = $events::addEvents(['name' => $json->name, 'detailname' => $json->detailname != '' ? $json->detailname : '', 'idcrm' => $json->idcrm, 'url' => $json->url, 'activityTime' => $json->activityTime > 0 ? $json->activityTime : 0, 'reservationTime' => $json->reservationTime > 0 ? $json->reservationTime : 0, 'placeSelectionTime' => $json->placeSelectionTime > 0 ? $json->placeSelectionTime : 0, 'ticketsId' => $json->ticketsId > 0 ? $json->ticketsId : 0, 'active' => $json->active > 0 ? $json->active : 0, 'shopId' => $json->shopId > 0 ? $json->shopId : 0, 'month_cnt' => $json->month_cnt > 0 ? $json->month_cnt : 0, 'first_summ' => $json->first_summ > 0 ? $json->first_summ : 0, 'recurrent_type' => $json->recurrent_type > 0 ? $json->recurrent_type : 0, 'recurrent_period' => $json->recurrent_period > 0 ? $json->recurrent_period : 0]);
					if ($response > 0) {
						$responseTicket = $events::updateTimeTicket($json->ticketsId, $json->activityTime, $json->reservationTime, $json->placeSelectionTime);
					}
					updateJson($pdo, $json->eventId, $request);
					break;

				case 'update':
					$events::updateEventsById(['name' => $json->name, 'detailname' => $json->detailname, 'idcrm' => $json->idcrm, 'url' => $json->url, 'activityTime' => $json->activityTime, 'reservationTime' => $json->reservationTime, 'placeSelectionTime' => $json->placeSelectionTime, 'ticketsId' => $json->ticketsId, 'active' => $json->active, 'shopId' => $json->shopId > 0 ? $json->shopId : 0, 'month_cnt' => $json->month_cnt != '' ? $json->month_cnt : '', 'first_summ' => $json->first_summ != '' ? $json->first_summ : '', 'recurrent_type' => $json->recurrent_type != '' ? $json->recurrent_type : '', 'recurrent_period' => $json->recurrent_period != '' ? $json->recurrent_period : ''], $json->eventId);
					updateJson($pdo, $json->eventId, $request);
					$responseTicket = $events::updateTimeTicket($json->ticketsId, $json->activityTime, $json->reservationTime, $json->placeSelectionTime);
					$response = 'update';
					break;
			}
			break;
		case 'Prices':
			$prices = new Prices($pdo);
			switch ($json->method) {
				case 'get':
					$response = $prices::getPrices();
					break;

				case 'add':
					$response = $prices::addPrices(['productId' => $json->productId, 'productName' => $json->productName, 'price' => $json->price, 'eventId' => $json->eventId]);
					updateJson($pdo, $json->eventId, $request);
					break;

				case 'update':
					$prices::updatePricesById(['productId' => $json->productId, 'productName' => $json->productName, 'price' => $json->price, 'eventId' => $json->eventId], $json->priceId);
					updateJson($pdo, $json->eventId, $request);
					$response = 'update';
					break;

				case 'getPricesById':
					$response = $prices::getPricesById($json->priceId, API_URL);
					break;

				case 'getPricesByCRMEventId':
					$response = $prices::getPricesByCRMEventId($json->eventId, API_URL);
					break;
			}
			break;
		case 'Partners':
			$partners = new Partners($pdo);
			switch ($json->method) {
				case 'get':
					$response = $partners::getPartners();
					break;

				case 'add':
					$link = $json->link;
					if ($json->link == '' || !isset($json->link)) {
						$link = null;
					}
					$response = $partners::addPartners(['eventId' => $json->eventId, 'name' => $json->name, 'link' => $link, 'number' => $json->number, 'filesId' => $json->filesId, 'type' => $json->type]);
					updateJson($pdo, $json->eventId, $request);
					break;

				case 'update':
					$link = $json->link;
					if ($json->link == '' || !isset($json->link)) {
						$link = null;
					}
					$partners::updatePartnersById(['eventId' => $json->eventId, 'name' => $json->name, 'filesId' => $json->filesId, 'number' => $json->number, 'type' => $json->type, 'link' => $link], $json->partnerId);
					updateJson($pdo, $json->eventId, $request);
					$response = 'update';
					break;

				case 'getPartnersByEventId':
					$response = $partners::getPartnersByEventId($json->eventId, API_URL);
					break;

				case 'getPartnersByCRMEventId':
					$response = $partners::getPartnersByCRMEventId($json->eventId, API_URL);
					break;
				case 'delete':
					$idEvent = $partners::getPartnersById($json->id);
					$response = $partners::deletePartnersById($json->id);
					updateJson($pdo, $idEvent, $request);
					break;
			}
			break;
		case 'Versions':
			$versions = new Versions($pdo);
			switch ($json->method) {
				case 'get':
					$response = $versions::getVersions();
					break;

				case 'add':
					$response = $versions::addVersions(['eventId' => $json->eventId, 'name' => $json->name, 'specialText' => $json->specialText, 'filesId' => $json->filesId, 'discount' => $json->discount]);
					updateJson($pdo, $json->eventId, $request);
					break;

				case 'update':
					$versions::updateVersionsById(['eventId' => $json->eventId, 'name' => $json->name, 'specialText' => $json->specialText, 'filesId' => $json->filesId, 'discount' => $json->discount], $json->versionId);
					updateJson($pdo, $json->eventId, $request);
					$response = 'update';
					break;

				case 'getVersionsByEventId':
					$response = $versions::getVersionsByEventId($json->eventId, API_URL);
					break;

				case 'getVersionsByCRMEventId':
					$response = $versions::getVersionsByCRMEventId($json->eventId, API_URL);
					break;

				case 'delete':
					$idEvent = $versions::getVersionsById($json->id);
					$response = $versions::deleteVersionsById($json->id);
					updateJson($pdo, $idEvent, $request);
					break;
			}
			break;
		case 'Files':
			$file = new Files($pdo);
			switch ($json->method) {
				case 'get':
					$response = $file::getFiles();
					break;
			}
	}
	if ($_POST['model'] == 'Files') {
		$file = new Files($pdo);
		switch ($_POST['method']) {
			case 'add':
				$response = $file::addFile($_FILES, $_POST['fileType']);
				if ($response == 'upload error') {
					$error = $response;
					$response = null;
				}
				break;
		}
	}
} else {
	$error = 'Неверный параметр token';
}

function updateJson($pdo, $eventId, $request)
{
	$events = new Events($pdo);
	$event = json_decode($events::getEventsById($eventId))[0];
	$request::sendRequest($event->url . 'getInfo.php?' . http_build_query(['eId' => $event->idcrm, 'update' => true]), false);
}

if($json->model=="Prices" && $json->method=="getPricesByCRMEventId") {
    echo json_encode($response = ['error' => $error, 'response' => $response]);
} else {
    echo json_encode($response = ['error' => $error, 'response' => $response]);
}
?>