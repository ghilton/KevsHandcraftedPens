<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<?php include("include/head.php"); ?>
</head>

<body>
<div align="center">
  <div class="container">
	<?php
        require_once('include/header.php'); 
    ?>
    <div class="content"> <span class="text_0"><a href="#">Welcome To The <?php echo $site_name; ?> Admin Panel</a></span>
      <?php include "include/footerlogo.php"; ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
