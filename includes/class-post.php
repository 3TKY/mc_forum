<?php
class Post {
	private $dbh;
	private $config;

	public function create() {
		
	}

	public function display() {
		
	}

	public function delete() {
		
	}

	public function hide() {
		
	}

	public function edit() {
		
	}

	public function __construct(Config $config, PDO $dbh) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>