<?php 
session_start();
$cart_sess = $_SESSION['cart'];
session_destroy();
session_start();
$_SESSION['cart'] = $cart_sess;  
header("location:index.php");
?>