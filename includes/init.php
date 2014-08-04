<?php
session_start();

//Load classes when they are called by the script
spl_autoload_register(function($class) {
	require_once('includes/class-' . strtolower($class) . '.php');
});
?>
