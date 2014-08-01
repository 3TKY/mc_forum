<?php
class User {
	private $config;
	private $dbh;
	private $functions;

	public $name;
	public $password;
	public $email;
	private $user_id;
	private $last_login;
	private $password_hashed;

	public function register() {
		//Error array
		$e = [];
		$user_exists = $this->userExists($this->name, $this->email);

		//Check if unique index user data already exists
		if (!$user_exists['name'] && !$user_exists['email']) {
			$input_valid = $this->validateUser($this->name, $this->email, $this->password);
			
			//Validate register form input
			if($input_valid['name'] && $input_valid['email'] && $input_valid['password']) {
				//Hash password for secure storage
				$salt = $this->getSalt();
				$this->password_hashed = $this->hashPassword($this->password, $salt);

				//Inser user database record
				$stmt = $this->dbh->prepare("INSERT INTO users (name, password, email) VALUES (:name, :password, :email)");
				$stmt->bindParam(':name', $this->name);
				$stmt->bindParam(':password', $this->password_hashed);
				$stmt->bindParam(':email', $this->email);
				$stmt->execute();

				echo 'User registered:' . print_r($this);
			} else {
				if (!$input_valid['name']) {
					//Invalid name error
				}
				if (!$input_valid['email']) {
					//Invalid email error
				}
				if (!$input_valid['password']) {
					//Invalid password error
				}
			}
		} else {
			if ($user_exists['name']) {
				//Name already exists error
			}
			if ($user_exists['email']) {
				//Email already exists error
			}
		}
		
		//Output JSON response
		return $response = 'JSON';
	}

	public function login() {
		return $this->checkCredentials($this->name, $this->password);
		return $this->checkCredentials($this->email, $this->password);
		if ($this->isLoggedIn()) {
			//User was already logged in
		} elseif ($this->checkCredentials($this->name, $this->password)) {
			//Login
			echo 'login';
		} elseif (!$this->name || $this->password) {
			echo 'nodata';
		} else {
			//Wrong username or password error
			'error';
		}
	}

	public function logout() {
		$this->logged_in = 0;
	}

	//Delete a user
	public function delete($user_id) {
		
	}

	//Ban user for violation of rules
	public function ban($reason, $duration) {
		
	}

	private function checkCredentials($identifier, $password) {
		$stmt = $this->dbh->prepare("SELECT password FROM users WHERE name = :name OR email = :email");
		$stmt->bindParam(':name', $identifier);
		$stmt->bindParam(':email', $identifier);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$hash = $result['password'];

		$password_hashed = $this->hashPassword($password, $hash);

		if ($password_hashed == $hash) {
			//Correct username or password
			return TRUE;
		}

		return FALSE;
	}

	private function getSalt() {
		$rand = str_replace('+', 'x', base64_encode(mcrypt_create_iv(32,MCRYPT_DEV_URANDOM)));
		$prefix = '$2a$07$';

		$salt = $prefix . $rand . '$';
	
		return $salt;
	}

	private function hashPassword($password, $salt) {
		$hash = crypt($password, $salt);
		return $hash;
	}

	//Validate user data input
	private function validateUser($name, $email, $password) {
		$email_valid = filter_var($email, FILTER_VALIDATE_EMAIL);

		$name_valid = preg_match('/^[a-zA-Z0-9_]{1,16}$/', $name);

		$password_valid = preg_match('/^(?=.*[A-Z].*[A-Z])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z]).{6,}$/', $password);

		$input_valid = array('name' => $name_valid, 'email' => $email_valid, 'password' => $password_valid);

		return $input_valid;
	}

	public function isLoggedIn() {
		return FALSE;
	}

	//Get name from user id
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

	public function userExists($name = NULL, $email = NULL) {
		$user_exists = [];

		//Check if username already exists
		$stmt = $this->dbh->prepare("SELECT COUNT(*) AS num FROM users WHERE name = :name");
		if ($name) {
			$stmt->bindParam(':name', $name);
			
		} else {
			$stmt->bindParam(':name', $this->name);
		}
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_exists['name'] = $result['num'];

		//Check if email already exists
		$stmt = $this->dbh->prepare("SELECT COUNT(*) AS num FROM users WHERE email = :email");
		if ($email) {
			$stmt->bindParam(':email', $email);
		} else {
			$stmt->bindParam(':email', $this->email);
		}
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_exists['email'] = $result['num'];

		return $user_exists;
	}

	public function __construct(Config $config, PDO $dbh, $user_id = NULL) {
		$this->config = $config;
		$this->dbh = $dbh;
		$this->user_id = $user_id;
	}
}
?>