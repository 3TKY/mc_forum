<?php
require_once('includes/init.php');

$config = new Config;
$db = new Database($config);
$dbh = $db->connect();

$user = new User($config, $dbh);
$user->name = 'Tofun';
$user->email = 'bazzytk@live.nl';
print_r($user->userExists());
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