<?php
header('Content-Type: application/json');

require_once('includes/init.php');

$user = new User;
echo $user->logout();
?>
