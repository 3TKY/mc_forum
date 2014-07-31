<?php
require_once('includes/init.php');

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
	</body>
</html>