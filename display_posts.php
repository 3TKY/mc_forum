<?php
header('Content-Type: application/json');

require_once('includes/init.php');

$config = new Config;

$db = new Database($config);
$dbh = $db->connect();

$author = new User($config, $dbh);

$post = new Post ($config, $dbh, $author);

$forum = new Forum ($config, $dbh, $post);

if (1==2) {
	
} else {
	$forum->getPosts();
}
?>
