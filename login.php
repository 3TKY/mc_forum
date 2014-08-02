<?php
header('Content-Type: application/json');

require_once('includes/init.php');

if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$config = new Config;
	$db = new Database($config);
	$dbh = $db->connect();

	//Temporary register form
	if(isset($_POST['name'])) {
		$name = $_POST['name'];
	} else {
		$name = '';
	}

	if(isset($_POST['pass'])) {
		$pass = $_POST['pass'];
	} else {
		$pass = '';
	}

	if(isset($_POST['email'])) {
		$email = $_POST['email'];
	} else {
		$email = '';
	}

	//Create new instance of user for the user to be registered and assign input values
	$user = new User($config, $dbh);
	$user->name = $name;
	$user->password = $pass;
	$user->email = $email;

	echo $user->login();
}
?>