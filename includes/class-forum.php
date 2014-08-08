<?php
class Forum {
	private $config, $dbh, $post;

	/* MAIN FUNCTIONS */
	public function getPosts($first = NULL, $last = NULL, $num = NULL, $browse_type = NULL) {
		$function_response = [];
		$browse_type = strtolower($browse_type);

		if (!$num) {
			$num = $this->config->defaultTopicCount();
		}

		echo $num;

		if ($browse_type == 'popularity') {
			//Order by most replies on opening post
			$stmt = $this->dbh->prepare("

				SELECT *
				FROM posts
				LEFT JOIN (
					SELECT COALESCE(op_id, id) AS topic_id, COUNT(op_id) AS replies
					FROM posts
					GROUP BY topic_id
				) AS r
				ON posts.id = r.topic_id
				WHERE op_id IS NULL
				ORDER BY r.replies DESC, time DESC, id DESC
				LIMIT :topic_count

			");
		} else if ($browse_type == 'start') {
			//Order by opening date of post
			$stmt = $this->dbh->prepare("
				
				SELECT *
				FROM posts
				LEFT JOIN (
					SELECT COALESCE(op_id, id) AS topic_id, COUNT(op_id) AS replies
					FROM posts
					GROUP BY topic_id
				) AS r
				ON posts.id = r.topic_id
				WHERE op_id IS NULL
				ORDER BY time DESC, id DESC
				LIMIT :topic_count

			");
		} else {
			//Order by most recent post in topic (DEFAULT)
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
				), id DESC
				LIMIT :topic_count

			");
		}
		$stmt->bindParam(':topic_count', intval($num), PDO::PARAM_INT);
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