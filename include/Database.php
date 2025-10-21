<?php

include_once('config.php');

class Database {
	private $connection;
	private static $instance = null;
	
	private function __construct() {
		$this->connection = new mysqli(Config::mysqlHost, Config::mysqlUser, Config::mysqlPassword, Config::mysqlDB);
		if ($this->connection->connect_errno) { throw new Exception("CANT CONNECT TO THE DATABASE"); }
	}
	
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new Database();
		}
		return self::$instance;
	}
	
	public function getConnection() {
		return $this->connection;
	}
}

?>