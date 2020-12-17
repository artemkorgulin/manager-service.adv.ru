<?php
	class SMS{
		static protected $_instance;

		static public function send_verification_code($config, $lead=NULL)
		{ 
			if(empty($lead)) {
				$lead = GV::$lead;
			}
			
			if(!(self::$_instance instanceof self)) {
				self::$_instance = new self;
			}

			switch(mb_strtolower($config['type'])) {
				case 'smsc':
				
					$param = $config[$config['type']];
					$param['phones'] = $lead->phone;
					$param['mes'] = !empty($param['mes']) ? $param['mes'] : "Ваш код подтверждения:" . decrypt($lead->vk);


					$result = self::$_instance->smsc($param);
					$_SESSION['PARZ']=$param;
					$_SESSION['PARZ1']=$result;
					if(isset($result->sendresult->error)) {
						Log::putStack('[SMS] SMS не отправлено');
						return $result->sendresult->error;
			
						return false;
					}
					return true;
					break;
				case 'devino':
					Log::putStack('[SMS] Интеграция в &laquo;DevinoTelecom&raquo; в разработке');
					return false;
					break;
			}
			return false;
		}
		
		/**
		 * Отсылка SMS через сервис SMS-Центр
		 */
		public function smsc($param)
		{ 

			$client = null;
			try {
				$client = new SoapClient('http://smsc.ru/sys/soap.php?wsdl');
			} catch(SoapFault $e) {
				Log::putStack('[SMS] Сервис &laquo;SMS-Центр&raquo; недоступен');
			}
			if($client instanceof SoapClient) {
				if(DEBUG){
				echo "<div style='background:#f00; color:#fff; '>
				LID - ".$lead->vk."<br>
				LID p- ".$lead->phone."<br>
				";
				print_r($param);
				echo "</div>";
				}
				return $client->send_sms($param);
			}
			return false;
		}
	}