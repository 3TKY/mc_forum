<?php
class Post {
	/* GLOBAL CLASS VARIABLES */
	private $dbh, $config, $author;

	public $content;

	/* MAIN FUNCTIONS */
	public function create() {
		$e = [];
		$s = FALSE;
		$d = [];
		
		$d['content'] = $this->content;

		if ($this->author->isLoggedIn()) {
			if (strlen($this->content)) {
				//Get user id from login session
				$this->author->user_id = $_SESSION['login']['user_id'];
				
				//Insert post in table
				$stmt = $this->dbh->prepare("
				
					INSERT INTO posts (user_id, content, time)
					VALUES (:author, :content, :time)
				
				");
				$stmt->bindParam(':author', $this->author->user_id, PDO::PARAM_INT);
				$stmt->bindParam(':content', $this->content);
				$stmt->bindParam(':time', time(), PDO::PARAM_INT);
				$stmt->execute();

				$s = TRUE;
			} else {
				//Empty post error DEV
				$e[] = 'Your post cannot be empty';
			}
		} else {
			$e[] = 'You need to login to create a post';
		}

		//Output JSON response
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
