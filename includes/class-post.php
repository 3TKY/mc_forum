<?php
class Post {
	private $dbh;
	private $config; 

	public function __construct(Config $config, PDO $dbh) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>