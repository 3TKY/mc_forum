<?php
header('Content-Type: application/json');

require_once('includes/init.php');

if ($_SERVER['REQUEST_METHOD'] == "GET"){
	$config = new Config;
	$db = new Database($config);
	$dbh = $db->connect();

	$author = new User($config, $dbh);
	$post = new Post ($config, $dbh, $author);

	if(isset($_GET['content'])) {
		$content = $_GET['content'];
	} else {
		$content = '';
	}

	$post->setContent($content);

	echo $post->create();
}
?>
