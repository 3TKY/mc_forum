<?php
header('Content-Type: application/json');

require_once('includes/init.php');

$config = new Config;

$db = new Database($config);
$dbh = $db->connect();

$author = new User($config, $dbh);

$forum = new Forum ($config, $dbh);

$cursor = NULL;
if (isset($_GET['cursor'])) {
	$cursor = $_GET['cursor'];
}

$browse_mode = NULL;
if (isset($_GET['browse_mode'])) {
	$browse_mode = $_GET['browse_mode'];
}

$count = NULL;
if (isset($_GET['count'])) {
	$count = $_GET['count'];
}

echo $forum->getTopics($cursor, $browse_mode, $count);
?>
