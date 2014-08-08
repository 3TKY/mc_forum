<?php
class Forum {
	private $config, $dbh, $post;

	/* MAIN FUNCTIONS */
	public function getPosts($first = NULL, $last = NULL, $num = NULL) {
		$function_response = [];

		if (!$num) {
			$num = $this->config->initialPostNum();
		}

		//Show posts: order by most recent post
		$stmt = $this->dbh->prepare("

			SELECT * 
			FROM posts
			LEFT JOIN (
				SELECT COALESCE(op_id, id) AS topic_id, COUNT(op_id) AS replies
				FROM posts
				GROUP BY topic_id
			) AS r
			ON posts.id = r.topic_id
			WHERE posts.id IN (
				SELECT DISTINCT topic_id
				FROM (
					SELECT *, COALESCE(op_id, id) AS topic_id
					FROM posts
					ORDER BY time DESC
				) AS t1
			)
			ORDER BY FIND_IN_SET(posts.id, (
				SELECT GROUP_CONCAT(DISTINCT topic_id)
				FROM (
					SELECT COALESCE(op_id, id) AS topic_id
					FROM posts
					ORDER BY time DESC
				) AS t2
				)
			)

		");
		$stmt->execute();
		$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

		print_r($topics);

		return json_encode($function_response);
	}

	/* CLASS FUNCTIONS */
	public function __construct(Config $config = NULL, PDO $dbh = NULL, Post $post) {
		$this->config = $config;
		$this->dbh = $dbh;
		$this->post = $post;
	}
}
?>