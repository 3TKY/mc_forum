<?php
class User {
	private $config;
	private $dbh;

	public function __construct(Config $config, PDO $dbh) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>