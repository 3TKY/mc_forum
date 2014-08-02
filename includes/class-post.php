<?php
class Post {
	/* GLOBAL CLASS VARIABLES */
	private $dbh;
	private $config;

	/* MAIN FUNCTIONS */
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

	/* CLASS FUNCTIONS */
	public function __construct(Config $config, PDO $dbh) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>
