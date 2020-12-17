<?php
	$postData = "<ApiRequest xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xs='http://www.w3.org/2001/XMLSchema'>
    				<ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
    				<Data xsi:type='Subscriber'>
       					<Mode>AddAndUpdate</Mode>
       					<Force>true</Force>
       					<ListId>".$_REQUEST['listId']."</ListId>
       					<Email>".$_REQUEST['email']."</Email>
       					<Firstname>".$_REQUEST['name']."</Firstname>
       					<Lastname></Lastname>
       					<TrackingCode>".$_REQUEST['id']."</TrackingCode>
       					<Vendor>".$_REQUEST['land']."</Vendor>
       					<Ip>".$_REQUEST['ip']."</Ip>
       					<Properties>
          					<Property>
             					<Id>2</Id>
             					<Value xsi:type='xs:string'>".$_REQUEST['phone']."</Value>
          					</Property>
          					<Property>
          				   		<Id>3</Id>
          				   		<Value xsi:type='xs:dateTime'>".date("Y-m-d", strtotime($_REQUEST['dateCreated']))."</Value>
          					</Property>
       					</Properties>
    				</Data>
 				</ApiRequest>";
	$response = cURLsend('https://api5.esv2.com/v2/Api/Subscribers/',$postData);
  if ($response == "") {
    echo "OK";
  } else {
    print_r($response);
  }
	
	
	//	$xml = new SimpleXMLElement($response);

function cURLsend($url,$postData) {
	$curl = curl_init($url);
  	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
  	if ($postData != false) {
    	curl_setopt($curl, CURLOPT_POST, 1);
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
  	}
  	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  	$response = curl_exec($curl);
  	curl_close($curl);
  	return $response;
}

?>