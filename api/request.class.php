<?php

class Request {
	
	/**
	 * cURL запрос
	 * @param string урл для запроса
	 * @param array POST параметры
	 * @return response результат запроса
	 */
	public function sendRequest($url,$postData) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		if ($postData) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, 
				[
	    			'Content-Type: application/json',
	    			'Accept: application/json'
	    		]
	    	);
		}
		if ($postData != false) {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
		}
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
}

?>