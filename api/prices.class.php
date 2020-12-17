<?php

class Prices {

    private static $sql;

    /**
     * Объект pdo
     * @param pdo объект PDO
     */
	public function __construct($sql) {
		self::$sql = $sql;
    }
    
    /**
     * Получить все цены
     * @return json результат
     */
    public function getPrices() {
		return self::jsonTable('prices');
    }

    /**
     * Получить цену по ID
     * @param int id записи
     * @return json результат
     */
    public function getPricesById($id) {
		return self::jsonTable('prices where id = '.$id);
	}
	
	public function getPricesByCRMEventId($eventId,$apiUrl) {
		$query = 'SELECT prices.id, prices.productId, prices.productName, prices.price, prices.eventId FROM prices  inner join events on events.id = prices.eventId where events.idcrm = :eventId';
		$stmt = self::$sql->prepare($query);
		$stmt->execute(['eventId'=>$eventId]);
		$data = [];
		$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($stmt as $row) {
            $row["price"] = json_decode($row["price"],true);
			$data[] = $row;
		}
		return $data;
	}

    /**
     * Добавить цену
     * @param array параметры для insert [параметр]=значение 
     * @return int id записи из БД
     */
    public function addPrices($params) {
		$query = 'INSERT INTO prices ';
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

    /**
     * Изменить цену по ID 
     * @param array параметры для update [параметр]=на что поменять 
     * @param int id записи 
     * @return boolean true
     */
	public function updatePricesById($params,$id) {
		$query = 'UPDATE prices SET ';
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