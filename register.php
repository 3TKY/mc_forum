<?php
header('Content-Type: application/json');

require_once('includes/init.php');

$functions = new Functions();

if ($_SERVER['REQUEST_METHOD'] == "GET"){
	$config = new Config;
	$db = new Database($config);
	$dbh = $db->connect();

	if(isset($_GET['name'])) {
		$name = $_GET['name'];
	} else {
		$name = '';
	}

	if(isset($_GET['pass'])) {
		$pass = $_GET['pass'];
	} else {
		$pass = '';
	}

	if(isset($_GET['email'])) {
		$email = $_GET['email'];
	} else {
		$email = '';
	}

	//Create new instance of user for the user to be registered and assign input values
	$user = new User($config, $dbh);
	$user->name = $name;
	$user->password = $pass;
	$user->email = $email;

	echo $user->register();
}
?>