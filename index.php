<?php
session_start();

require_once('includes/class-config.php');
require_once('includes/class-db.php');
require_once('includes/class-post.php');

$config = new Config;
$db = new Database($config);
$dbh = $db->connect();
$post = new Post($config, $dbh);
$user = new User($config, $dbh);
?>
<!DOCTYPE html>
<html lang="<?php echo $config->getLanguage(); ?>">
	<head>
		<meta charset="<?php echo $config->getCharset(); ?>">
		<title><?php echo $config->getTitle(); ?></title>
	</head>
	<body>

	</body>
</html>
