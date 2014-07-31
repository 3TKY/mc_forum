<?php
class User {
	private $config;
	private $dbh;

	public $name;
	public $password;
	public $email;
	private $user_id;
	private $last_login;

	private $logged_in;

	public function register() {
		$user_exists = $this->userExists($this->name, $this->email);

		print_r($user_exists);

		if (!$user_exists['name'] && !$user_exists['email']) {
			/*
			$stmt = $this->dbh->prepare("INSERT INTO users (name, password, email) VALUES (:name, :password, :email)");
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':password', $this->password);
			$stmt->bindParam(':email', $this->email);
			$stmt->execute();
			*/

			$email_valid = filter_var($this->email, FILTER_VALIDATE_EMAIL);
			$name_valid = ;



		} else {
			if ($user_exists['name']) {
			
			}
			if ($user_exists['email']) {
			
			}
		}

		/*$stmt = $this->dbh->prepare("INSERT INTO users (name, password, email) VALUES (:name, :password, :email)");
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':email', $this->email);
		$stmt->execute();*/
	}

	public function userExists($name = NULL, $email = NULL) {
		$name_exists;
		$email_exists;

		if ($name) {
			$stmt = $this->dbh->prepare("SELECT COUNT(*) AS num FROM users WHERE name = :name");
			$stmt->bindParam(':name', $this->name);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$name_exists = $result['num'];
		}

		if ($email) {
			$stmt = $this->dbh->prepare("SELECT COUNT(*) AS num FROM users WHERE email = :email");
			$stmt->bindParam(':email', $this->email);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$email_exists = $result['num'];
		}

		$user_exists = array('name' => $name_exists, 'email' => $email_exists);
		return $user_exists;
	}

	public function login() {
		if ($this->logged_in) {
			//User was already logged in
		} elseif ($this->checkCredentials($this->name, $this->password)) {
			
		} else {
			//Wrong username or password error
		}
	}

	public function logout() {
		$this->logged_in = 0;
	}

	public function delete($user_id) {
		
	}

	public function ban($reason, $duration) {
		
	}

	private function checkCredentials($username, $password) {
		//Check if username and password match
		if (1) {
			//Correct username or password
			return TRUE;
		} else {
			//Wrong username or password
			return FALSE;
		}
	}

	public function getName() {
		if ($this->user_id) {
			$stmt = $this->dbh->prepare("SELECT name FROM users WHERE id = :user_id");
			$stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->name = $result['name'];
			return $this->name;
		}
	}

	public function getLastLogin() {
		if ($this->user_id) {
			$stmt = $this->dbh->prepare("SELECT last_login FROM users WHERE id = :user_id");
			$stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->last_login = $result['last_login'];
			return $this->last_login;
		}
	}

	public function __construct(Config $config, PDO $dbh, $user_id = NULL) {
		$this->config = $config;
		$this->dbh = $dbh;
		$this->user_id = $user_id;
	}
}
?>