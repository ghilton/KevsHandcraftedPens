<?php 
	session_start();
	session_destroy(); // destroy session                
	header("Location: login.php");
?>