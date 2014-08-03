<?php
class Post {
	/* GLOBAL CLASS VARIABLES */
	private $dbh;
	private $config;

	private $author;

	public $content;

	/* MAIN FUNCTIONS */
	public function create() {
		$e = [];
		$s = FALSE;
		$d = [];
		
		$d['content'] = $this->content;

		if ($this->author->isLoggedIn()) {
			if (strlen($this->content)) {
				$this->author->user_id = $_SESSION['user_id'];
				
				$stmt = $this->dbh->prepare("INSERT INTO posts (author, content, user_id, time) VALUES ()");

				$s = TRUE;
			} else {
				//Empty post error DEV
				$e[] = 'Your post cannot be empty';
			}
		} else {
			$e[] = 'You need to login to create a post';
		}

		$function_response = [];
		$function_response['errors'] = $e;
		$function_response['success'] = $s;
		$function_response['data'] = $d;

		return json_encode($function_response);
	}

	public function render() {
		

	}

	public function delete() {
		
	}

	public function hide() {
		
	}

	public function edit() {
		
	}

	/* SUPPORT FUNCTIONS */
	public function setContent($text) {
		$this->content = htmlspecialchars($text);
	}

	/* CLASS FUNCTIONS */
	public function __construct(Config $config, PDO $dbh, User $author = NULL) {
		$this->config = $config;
		$this->dbh = $dbh;
		$this->author = $author;
	}
}
?>
