<?php
session_start();

require_once('includes/class-config.php');
require_once('includes/class-db.php');
require_once('includes/class-post.php');
require_once('includes/class-user.php');
require_once('includes/class-functions.php');

$config = new Config;
$db = new Database($config);
$dbh = $db->connect();
?>
<!DOCTYPE html>
<html lang="<?php echo $config->getLanguage(); ?>">
	<head>
		<meta charset="<?php echo $config->getCharset(); ?>">
		<title><?php echo $config->getTitle(); ?></title>
	</head>
	<body>
		<h1>Test file</h1>
		<pre>
		<?php
		$user = new User($config, $dbh);
		$user->name = 'Xorvian';
		$user->password = 'geen';
		$user->email = 'hoi@hoi.nl';
		print_r($user);
		$user->register();
		?>
		</pre>
	</body>
</html>