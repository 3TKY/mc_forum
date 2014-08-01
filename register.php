<pre>
<?php
require_once('includes/init.php');

$config = new Config;
$db = new Database($config);
$dbh = $db->connect();

//Temporary register form
$name = $_GET['name'];
$pass = $_GET['pass'];
$email = $_GET['email'];

//Create new instance of user for the user to be registered and assign input values
$user = new User($config, $dbh);
$user->name = $name;
$user->password = $pass;
$user->email = $email;

echo $user->register();
?>
</pre>