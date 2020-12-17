<?php

class Versions {

	private static $sql;
	
	public function __construct($sql) {
		self::$sql = $sql;
	}

	public function getVersions() {
		return self::jsonTable('versions');
	}

	public function getVersionsById($id) {
		return self::jsonTable('versions where id = '.$id);
	}

	public function getVersionsByEventId($eventId,$apiUrl) {
		$query = 'SELECT versions.id, versions.name,versions.specialText,versions.discount,files.path as file FROM versions inner join files on files.id = versions.filesId where versions.eventId = :eventId';
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

	public function getVersionsByCRMEventId($eventId,$apiUrl) {
		$query = 'SELECT versions.id, versions.name,versions.specialText,versions.discount,files.path as file FROM versions inner join files on files.id = versions.filesId inner join events on events.id = versions.eventId where events.idcrm = :eventId';
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

	public function addVersions($params) {
		$query = 'INSERT INTO versions ';
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

	public function updateVersionsById($params,$id) {
		$query = 'UPDATE versions SET ';
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

	public function deleteVersionsById($id) {
		$query = 'DELETE FROM versions WHERE id = '.$id;
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