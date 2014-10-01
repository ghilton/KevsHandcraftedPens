<?php
if(isset($_SESSION[ADMIN_SESSION])){
	$uniq_val = $_SESSION[ADMIN_SESSION];
	$sql_user = "SELECT * from admin where uniq_id='$uniq_val'";
	$exec_user = mysql_query($sql_user);
	if(mysql_num_rows($exec_user) == 1){
		$flagl='lgin';
		$fetch_user = mysql_fetch_assoc($exec_user);
		$user_id = $fetch_user['userid'];
	}
	else{
		header("Location: login.php?login=req");
	}
}
else{
	header("Location: login.php?login=req");
}
