<?php
	require_once("init.php");
	require_once("config_db.php");
	require_once("config.php");
	$tabl = "users";
	$page = $_GET['page'];
	
	if(isset($_SESSION['remember'])){
		setcookie('rem', $_SESSION['remember'], time()+3600*24*365);
	}
	if($page != ''){
		header("Location: $page");}
	else{
		if($fetch_u['user_type'] == 1){
			header("Location: index.php");
		}
		else if($fetch_u['user_type'] == 2){
			header("Location: index.php");
		}

	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Logging In</title>

<meta HTTP-EQUIV="REFRESH" content="0; url=index.php"></head>

<body>
Logging In...
</body>
</html>