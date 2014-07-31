<?php
$name = $_GET['name'];
$pass = $_GET['pass'];
$email = $_GET['email'];

require_once('includes/class-config.php');
require_once('includes/class-db.php');
require_once('includes/class-user.php');

$config = new Config;
$db = new Database($config);
$dbh = $db->connect();

$user = new User($config, $dbh);
$user->name = $name;
$user->password = $pass;
$user->email = $email;

$user->register();
?>