<?php


class Events
{

	private static $sql;

	/**
	 * Объект pdo
	 * @param pdo объект PDO
	 */
	public function __construct($sql)
	{
		self::$sql = $sql;
	}

	/**
	 * Получить все мероприятия
	 * @return json результат
	 */
	public function getEvents()
	{
		return self::jsonTable('events');
	}

	public function getEventsById($id)
	{
		return self::jsonTable('events where id = ' . $id);
	}

	public function getEventsByEventId($id)
	{
		return self::jsonTable('events where ticketsId = ' . $id);
	}

	public function getEventsByCRMId($id)
	{
		return self::jsonTable('events where idcrm = ' . $id);
	}

	public function addEvents($params)
	{
		$query = 'INSERT INTO events ';
		$keys = array_keys($params);
		$fields = '';
		foreach ($keys as $key) {
			$fields .= ',`' . $key . '`';
		}
		$query .= '(' . substr($fields, 1) . ') VALUES ';
		$fields = '';
		foreach ($keys as $key) {
			$fields .= ',:' . $key;
		}
		$query .= '(' . substr($fields, 1) . ')';
	
		$stmt = self::$sql->prepare($query);
		$stmt->execute($params);
		return self::$sql->lastInsertId();
	}

	public static function interpolateQuery($query, $params) {
		$keys = array();
	
		# build a regular expression for each parameter
		foreach ($params as $key => $value) {
			if (is_string($key)) {
				$keys[] = '/:'.$key.'/';
			} else {
				$keys[] = '';
			}
		}
	
		$query = preg_replace($keys,$params, $query, 1, $count);
	
		#trigger_error('replaced '.$count.' keys');
	
		return $query;
	}

	public function updateTimeTicket($eventId, $activityTime, $reservationTime, $placeSelectionTime)
	{
		$request = new Request();
		$request::sendRequest("https://payment.1001tickets.org/bitrix/events.php", ["token" => "4c6620bc1aa03a4c099387a862e27d3a", "method" => "updateBookingTime", "event" => $eventId, "time" => $activityTime]);
		$request::sendRequest("https://payment.1001tickets.org/bitrix/events.php", ["token" => "4c6620bc1aa03a4c099387a862e27d3a", "method" => "updateBookingTimeOnline", "event" => $eventId, "time" => $reservationTime]);
		$request::sendRequest("https://payment.1001tickets.org/bitrix/events.php", ["token" => "4c6620bc1aa03a4c099387a862e27d3a", "method" => "updatePickingTime", "event" => $eventId, "time" => $placeSelectionTime]);
	}

	public function updateEventsById($params, $id)
	{
		$query = 'UPDATE events SET ';
		$keys = array_keys($params);
		$fields = '';
		foreach ($keys as $key) {
			$fields .= ',`' . $key . '` = :' . $key;
		}
		$query .= substr($fields, 1) . ' WHERE id = ' . $id;
		$stmt = self::$sql->prepare($query);
		$stmt->execute($params);
		return true;
	}

	/**
	 * Возвращает json результата
	 * @param string название таблицы
	 * @return json поля таблицы в json`e
	 */
	private function jsonTable($tableName)
	{
		$stmt = self::$sql->prepare("SELECT * FROM " . $tableName);
		$stmt->execute();
		$data = [];
		$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($stmt as $row) {
			$data[] = $row;
		}
		return json_encode($data);
	}
}

?>