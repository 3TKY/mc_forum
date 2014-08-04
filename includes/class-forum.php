<?php
class Forum {
	private config, dbh, post;

	/* MAIN FUNCTIONS */
	public function getPosts($first = NULL, $last = NULL, $num = NULL) {
		if (!$num) {
			$num = $this->config->initialPostNum();
		}

		echo $num;
	}

	/* CLASS FUNCTIONS */
	public function __construct(Config $config = NULL, PDO $dbh = NULL, Post $post) {
		$this->config = $config;
		$this->dbh = $dbh;
		$this->post = $post;
	}
}
?>