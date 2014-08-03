<?php
header('Content-Type: application/json');

require_once('includes/init.php');

if ($_SERVER['REQUEST_METHOD'] == "GET"){
	$config = new Config;
	$db = new Database($config);
	$dbh = $db->connect();

	$author = new User($config, $dbh);
	$post = new Post ($config, $dbh, $author);

	$post->create();
}
?>
