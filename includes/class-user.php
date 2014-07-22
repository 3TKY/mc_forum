<?php
class User {
	private $config;
	private $dbh;

	private $username;
	private $password;
	private $user_id;
	private $last_login;
	
	/*
	$stmt = $dbh->prepare("SELECT name FROM users WHERE id = :user_id");
	$stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetch();
	*/

	public function register() {
		
	}

	public function login() {
		
	}

	public function delete($user_id) {
		
	}

	public function ban($reason, $duration) {
		
	}

	private function checkCredentials($username, $password) {
		
	}

	public function getName($user_id) {
		
	}

	public function getLastLogin($user_id) {
		
	}

	public function __construct(Config $config, PDO $dbh) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>