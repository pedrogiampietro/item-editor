<?php

class Config {

	const mysqlHost = self::getEnv('DB_HOST', 'trolley.proxy.rlwy.net:46752');
	const mysqlUser = self::getEnv('DB_USER', 'root');
	const mysqlPassword = self::getEnv('DB_PASSWORD', 'DgdYpjeqPSHeKwYiAbKRrbkKHXKbgBFP');
	const mysqlDB = self::getEnv('DB_NAME', 'railway');
	
	private function __construct() {}
	
	private static function getEnv($key, $default = '') {
		$value = getenv($key);
		return $value !== false ? $value : $default;
	}
}

?>