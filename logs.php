<?php

        
class CLogs {
    
    private $db;
    
    function __construct(){

        $this->db_conn();
    }
    
    public function __destruct()
    {
        $this->db = null;
    } 
    
    function db_conn(){
        if(!file_exists('alt_db_conn.php')){
            defined('DB_HOST') or define('DB_HOST', 'localhost');
            defined('DB_NAME') or define('DB_NAME', 'lander');
            defined('DB_USER') or define('DB_USER', 'lander_user');
            defined('DB_PASS') or define('DB_PASS', 'PRp26V');
        }
        //Если есть отдельный файл с натройками, например, dev сервак
        else{
            include_once('alt_db_conn.php');
        }
        
        try {

            // Подключение к базе данных
            define("DSN", "mysql:host=".DB_HOST.";dbname=".DB_NAME."");
            $this->db = new PDO(DSN, DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
            $this->check_table();
        } 
        // Вывод ошибки при неудачном подключении к базе данных
        catch (PDOException $e) {
            die("Не подключиться к базе данных". $e->getMessage());
        }
    }
    
    /*
    $entity_id = уникальный идентификатор сущности (id, email, phone)
    $entity_type = тип сущности(например email, lead и т.п.)
    $msg = текстовое сообщение записи
    $type_msg = тип сообщения: 1 - info, 2 - error...
    $other_data - до информация, например сериализованный массив
    */    
    function add_rec($entity_id, $entity_type, $msg, $type_msg=1, $other_data){
      /*  if($entity_id == ''){
            return false;
        }
        $this->exec(
                "INSERT INTO `sn_logs` (`entity_id`, `entity_type`, `msg`, `type_msg`, `other_data`) VALUES (:entity_id, :entity_type, :msg, :type_msg, :other_data)", 
                array(':entity_id' => $entity_id, ':entity_type' => $entity_type, ':msg' => $msg, ':type_msg' => $type_msg, ':other_data' => $other_data),
                0
                );*/
        
    }
    
    private function check_table(){
      /*  if($this->exec("SHOW TABLES LIKE :db", array(':db' => 'sn_logs'), 1) === false) {
                $tblCreate = $this->exec(
                        "CREATE TABLE IF NOT EXISTS `sn_logs` (
                                `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `entity_id` varchar(250) NOT NULL DEFAULT '' COMMENT 'уникальная сущность',
                                `entity_type` varchar(250) NOT NULL DEFAULT '' COMMENT 'тип сущности',
                                `msg` varchar(250) NOT NULL DEFAULT '' COMMENT 'текстовое сообщение',
                                `type_msg` int(11) NOT NULL DEFAULT '1' COMMENT 'тип сообщения',
                                `other_data` text COMMENT 'JSON-строка с даннными'
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Logs';", 
                        array(), 
                        0
                );
        }        */
    }
    public function exec($sql, $vars, $fetch=1){
        
      /*  if ($this->db == null){
            $this->db_conn();
        }
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute($vars);
        if($result === false) {
            file_put_contents('logs_dberror.log', print_r($vars, true));
        }
		
        if($fetch == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);				// достаем текущий курсор
        } elseif($fetch == 2) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);			// достаем весь результат
        }
        return $result;
    }    */
}
}

$log = new CLogs();