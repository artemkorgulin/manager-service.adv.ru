<?php

require 'config.php';

class MySQL {

	private static $config;

	public function __construct($config) {
        self::$config = $config;
    }

	public function createConnection() {
		try {
			return new PDO("mysql:host=".self::$config['host'].";dbname=".self::$config['name'], self::$config['user'], self::$config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
		} catch(PDOException $e) {
			$logger = new Logger();
			$logger::add('ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage());
		}
	}
}


?>