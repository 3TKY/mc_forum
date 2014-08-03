<?php
class Post {
	/* GLOBAL CLASS VARIABLES */
	private $dbh;
	private $config;
	private $author;

	/* MAIN FUNCTIONS */
	public function create() {
		$e = [];
		$s = [];
		$d = [];

		if ($this->author->isLoggedIn()) {
			$this->author->user_id = $_SESSION['user_id'];
			echo $this->author->user_id . 'logged_in';
		} else {
			echo 'not logged in';
			$e[] = 'You need to login to create a post';
		}
	}

	public function render() {
		

	}

	public function delete() {
		
	}

	public function hide() {
		
	}

	public function edit() {
		
	}

	/* CLASS FUNCTIONS */
	public function __construct(Config $config, PDO $dbh, User $author = NULL) {
		$this->config = $config;
		$this->dbh = $dbh;
		$this->author = $author;
	}
}
?>
