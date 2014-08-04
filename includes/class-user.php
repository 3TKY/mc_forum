<?php
class User {
	/* GLOBAL CLASS VARIABLES */
	private $config, $dbh;
	public $name, $email, $user_id, $password;
	private $last_login,  $password_hashed;

	/* MAIN FUNCTIONS */
	public function register() {
		//Response data arrays
		$e = [];
		$d = [];
		$s = FALSE;

		$d['username'] = $this->name;
		$d['email'] = $this->email;

		//Check if all fields have been used
		if (strlen($this->name) && strlen($this->password) && strlen($this->email)) {
			$user_exists = $this->userExists($this->name, $this->email);

			//Check if unique index user data already exists
			if (!$user_exists['name'] && !$user_exists['email']) {
				$input_valid = $this->validateUser($this->name, $this->email, $this->password);
			
				//Validate register form input
				if($input_valid['name'] && $input_valid['email'] && $input_valid['password']) {
					//Hash password for secure storage
					$salt = $this->createSalt();
					$this->password_hashed = $this->hashPassword($this->password, $salt);

					//Inser user database record
					$stmt = $this->dbh->prepare("INSERT INTO users (name, password, email) VALUES (:name, :password, :email)");
					$stmt->bindParam(':name', $this->name);
					$stmt->bindParam(':password', $this->password_hashed);
					$stmt->bindParam(':email', $this->email);
					$stmt->execute();

					$s = TRUE;
				} else {
					if (!$input_valid['name']) {
						//Invalid username error
						$e[] = "Your username may only be 16 characters long and can only consist of alphanumerical characters and '_'";
					}
					if (!$input_valid['email']) {
						//Invalid email error
						$e[] = "This is not a valid email adress";
					}
					if (!$input_valid['password']) {
						//Invalid password error
						$e[] = "Your password should be at least 6 characters long, contain 2 numbers, 2 lowercase and 2 capital letters";
					}
				}
			} else {
				if ($user_exists['name']) {
					//Name already exists error
					$e[] = "This username is already in use";
				}
				if ($user_exists['email']) {
					//Email already exists error
					$e[] = "This email adress is already in use";
				}
			}
		} else {
			if (!strlen($this->name)) {
				//No username specified error
				$e[] = "You didn't pick a username yet";
			}
			if (!strlen($this->email)) {
				//No username specified error
				$e[] = "Your email adress cannot be empty";
			}
			if (!strlen($this->password)) {
				//No username specified error
				$e[] = "You need a password to keep your account secure";
			}
		}
		
		//Output JSON response
		$function_response = [];
		$function_response['errors'] = $e;
		$function_response['success'] = $s;
		$function_response['data'] = $d;
		
		return json_encode($function_response);
	}

	public function login() {
		$e = [];
		$d = [];
		$s = FALSE;

		$d['username'] = $this->name;
		$d['email'] = $this->email;
		$d['id'] = $this->user_id;

		if ((!strlen($this->name) && !strlen($this->email)) || !strlen($this->password)) {
			//No input data for login form
			$e[] = 'You need to fill in all the fields';
		} elseif ($this->checkCredentials($this->name, $this->password) || $this->checkCredentials($this->email, $this->password)) {
			$this->getId();
			$d['id'] = $this->user_id;

			//Login
			$_SESSION['login']['logged_in'] = TRUE;
			$_SESSION['login']['user_id'] = $this->user_id;

			$this->setLastLogin();
			$d['time'] = $this->last_login;

			$s = TRUE;
		} else {
			//Wrong username or password error
			$e[] = 'Wrong combination of username and password';
		}

		//Output JSON response
		$function_response = [];
		$function_response['errors'] = $e;
		$function_response['success'] = $s;
		$function_response['data'] = $d;
		
		return json_encode($function_response);
	}

	public function logout() {
		unset($_SESSION['login']);
		$function_response = [];
		$function_response['success'] = TRUE;

		return json_encode($function_response);
	}

	/* CLASS DATA FUNCTIONS */
	public function isLoggedIn() {
		if (isset($_SESSION['login']['logged_in'])) {
			return TRUE;
		}
		
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

	//Ged id from user name or email
	public function getId() {
		$stmt = $this->dbh->prepare("SELECT id FROM users WHERE name = :name OR email = :email");
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':email', $this->email);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->user_id = $result['id'];

		return $this->user_id;
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

		return NULL;
	}

	public function setLastLogin() {
		if ($this->user_id) {
			$time = time();

			$stmt = $this->dbh->prepare("UPDATE users SET last_login = :last_login WHERE id = :user_id");
			$stmt->bindParam(':last_login', $time);
			$stmt->bindParam(':user_id', $this->user_id);
			$stmt->execute();

			$this->last_login = $time;
		}
	}

	/* SUPPORT FUNCTIONS */
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

	private function createSalt() {
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

	/* CLASS FUNCTIONS */
	public function __construct(Config $config = NULL, PDO $dbh = NULL) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>
