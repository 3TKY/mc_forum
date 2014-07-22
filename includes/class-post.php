<?php
class Post {
	private $dbh;
	private $config;
	private $name = NULL;
	private $password = NULL;
	
	$stmt = $dbh->prepare("SELECT name FROM users WHERE id = :user_id");
	$stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetch(); 

	public function __construct(Config $config, Database $dbh) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>