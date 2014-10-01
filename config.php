<?php

if(isset($_COOKIE['rem'])){
	$uniqc = mysql_real_escape_string($_COOKIE['rem']);
	$sql = "SELECT count(*) from signup where uniq='".$uniqc."'";
	$exec = mysql_query($sql);
	list($numc) = mysql_fetch_row($exec);
	
	if($numc == '1'){
		$_SESSION['user']= $uniqc;
	}
}

// check user's login status
if(isset($_SESSION['user'])){
	$user_status = '1';
	$user_uniq = $_SESSION['user'];
	$sql = "SELECT * from users where uniq='".$user_uniq."'";
	$exec = mysql_query($sql);
	$fetch_u = mysql_fetch_assoc($exec);
	$uniq = $fetch_u['uniq'];
}

if(isset($_SESSION['cart'])){
}
else{
	$_SESSION['cart'] = rg('cart', 'session', 10);
}

//Check if cart order is complete. IF YES, start a new cart session.
$sql = "SELECT count(*) from place_order where session='".$cart_sess."' AND status='1'";
$exec = mysql_query($sql);
list($num) = mysql_fetch_row($exec);
if($num <> 0){
	$_SESSION['cart'] = random_generator(32);
}

$cart_sess = $_SESSION['cart'];

//for count cart items
$sql_crt = "SELECT count(*) from cart where session='$cart_sess'";
$exec_crt = mysql_query($sql_crt);
list($num_crt) = mysql_fetch_row($exec_crt);
$t_crt_item = $num_crt;


?>