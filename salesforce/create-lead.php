<?php 





$salesforce['username'] = 'vrudenko@synergy.ru'; 
$salesforce['password'] = 'sgf2017verarudenko';
$salesforce['security_token'] = 'XXXXXXXXXXXXXX'; 


require_once ('salesforce-toolkit/SforcePartnerClient.php');

try {
	
	$wsdl = 'salesforce-toolkit/partner.wsdl.xml';
	
	
	$mySforceConnection = new SforcePartnerClient();
	$mySforceConnection->createConnection($wsdl);
	$mySforceConnection->login($salesforce['username'], $salesforce['password'].$salesforce['security_token']);

	

	$records = array();
	$records[0] = new SObject();
	$records[0]->type = 'Lead';
	$records[0]->fields = array(
	    'FirstName' => $row['first_name'],
	    'LastName' => $row['last_name'],
	    'Title' => $row['job_title'],
	    'LeadSource' => 'WEB',
	    'Company' => $row['organization'],
	    'NumberOfEmployees' => (int)$row['no_employees'],
	    'PostalCode' => $row['postal_code'],
	    'State' => $row['geo_state'],
	    'Email' => $row['email'],
	    'Country' => $row['country'],
	    'Phone' => $row['phone']
	);
	

	$response = $mySforceConnection->create($records);

} catch (Exception $e) {
	
	# Catch and send out email to support if there is an error
	$errmessage =  "Exception ".$e->faultstring."<br/><br/>\n";
	$errmessage .= "Last Request:<br/><br/>\n";
	$errmessage .= $mySforceConnection->getLastRequestHeaders();
	$errmessage .= "<br/><br/>\n";
	$errmessage .= $mySforceConnection->getLastRequest();
	$errmessage .= "<br/><br/>\n";
	$errmessage .= "Last Response:<br/><br/>\n";
	$errmessage .= $mySforceConnection->getLastResponseHeaders();
	$errmessage .= "<br/><br/>\n";
	$errmessage .= $mySforceConnection->getLastResponse();
//	$status = sendmail(ADMIN_EMAIL,'ERROR! Salesforce Error', $errmessage);
	print_r($errmessage);
}




function sendmail($to,$subject,$message,$from='no-reply@yourdomain.com') {

	$headers  = "From: ".$from . PHP_EOL;
	$headers .= "Reply-To: ".$from . PHP_EOL;
	$headers .= "Return-Path: ".$from . PHP_EOL;
	$headers .= "MIME-Version: 1.0" . PHP_EOL;
	$headers .= "Content-type: text/html; charset=UTF-8" . PHP_EOL;
  
  if( mail($to,'=?UTF-8?B?'.base64_encode($subject).'?=',"$message",$headers) ) {
     return true;
  } else {
     return false;
  }
}