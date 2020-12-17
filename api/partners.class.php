<?php


class Partners {

	private static $sql;
	
	/**
     * Объект pdo
     * @param pdo объект PDO
     */
	public function __construct($sql) {
		self::$sql = $sql;
	}

	/**
     * Получить всех партнеров
     * @return json результат
     */
	public function getPartners() {
		return self::jsonTable('partners');
	}

	public function getPartnersById($id) {
		return self::jsonTable('partners where id = '.$id);
	}

	public function getPartnersByEventId($eventId,$apiUrl) {
		$query = 'SELECT partners.id,partners.name,files.path as file, partners.number, partners.link, partners.type, partners.filesId as fileId FROM partners inner join files on files.id = partners.filesId where partners.eventId = :eventId';
		$stmt = self::$sql->prepare($query);
		$stmt->execute(['eventId'=>$eventId]);
		$data = [];
		$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($stmt as $row) {
			$row['file'] = $apiUrl.'/files/'.$row['file'];
			$data[] = $row;
		}
		return json_encode($data);
	}

	public function getPartnersByCRMEventId($eventId,$apiUrl) {
		$query = 'SELECT partners.id,partners.name,files.path as file, partners.number, partners.link, partners.type FROM partners inner join files on files.id = partners.filesId inner join events on events.id = partners.eventId where events.idcrm = :eventId ORDER BY partners.number ASC';
		$stmt = self::$sql->prepare($query);
		$stmt->execute(['eventId'=>$eventId]);
		$data = [];
		$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($stmt as $row) {
			$row['file'] = $apiUrl.'/files/'.$row['file'];
			$data[] = $row;
		}
		return json_encode($data);
	}

	public function addPartners($params) {
		$query = 'INSERT INTO partners ';
		$keys = array_keys($params);
		$fields = '';
		foreach ($keys as $key) {
			$fields .= ',`'.$key.'`';
		}
		$query .= '('.substr($fields,1).') VALUES ';
		$fields = '';
		foreach ($keys as $key) {
			$fields .= ',:'.$key;
		}
		$query .= '('.substr($fields,1).')';
		$stmt = self::$sql->prepare($query);
		$stmt->execute($params);
		return self::$sql->lastInsertId();
	}

	public function updatePartnersById($params,$id) {
		$query = 'UPDATE partners SET ';
		$keys = array_keys($params);
		$fields = '';
		foreach ($keys as $key) {
			$fields .= ',`'.$key.'` = :'.$key;
		}
		$query .= substr($fields,1).' WHERE id = '.$id;
		$stmt = self::$sql->prepare($query);
		$stmt->execute($params);
		return true;
	}

	public function deletePartnersById($id) {
		$query = 'DELETE FROM partners WHERE id = '.$id;
		$stmt = self::$sql->query($query);
		return true;
	}
	
	/**
     * Возвращает json результата
	 * @param string название таблицы
	 * @return json поля таблицы в json`e
     */
	private function jsonTable($tableName) {
		$stmt = self::$sql->prepare("SELECT * FROM ".$tableName);
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