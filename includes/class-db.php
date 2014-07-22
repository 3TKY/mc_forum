<?php
class Database {
	private $dbh;
	private $config;

	public function connect() {
		$db_settings = $this->config->getDatabaseConf();

		$db_host = $db_settings['host'];
		$db_name = $db_settings['name'];
		$db_user = $db_settings['user'];
		$db_password = $db_settings['password'];

		try {
			$dbh = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_password);
			return $dbh;
		} catch (Exception $e) {
			echo 'Could not connect to the database.';
			error_log($e->getMessage());
		}
	}

	public function __construct(Config $config) {
		$this->config = $config;
	}
}
?>