<?php

class Files {

	private static $sql;
	  
	/**
     * Объект pdo
     * @param pdo объект PDO
     */
	public function __construct($sql) {
		self::$sql = $sql;
	}

	public function getFiles() {
		return self::jsonTable('files');
	}

	public function addFile($file,$fileType) {
		$fileName = 'id_'.self::randomString(4).time().'.'.$fileType;
		$filePath = dirname(__FILE__) . '/files/'.$fileName;
		move_uploaded_file($file['file']['tmp_name'], $filePath);
		if (file_exists($filePath)) {
			$query = 'INSERT INTO files (`path`) VALUES (:file)';
			$stmt = self::$sql->prepare($query);
			$stmt->execute(['file' => $fileName]); 
			return self::$sql->lastInsertId();
		} else {
			return "upload error";
		}
	}

	private function randomString($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
	    $pieces = [];
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pieces []= $keyspace[random_int(0, $max)];
	    }
	    return implode('', $pieces);
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