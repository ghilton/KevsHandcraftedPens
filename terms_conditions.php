<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	
	//for page content
	$sql_exec = select_query_without_status('content', '', '', "id='4'");
	$fetch_abt = mysql_fetch_assoc($sql_exec);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Terms & Conditions | Kev's Handcrafted Pens</title>
<?php include "include/head.php"; ?>
</head>
<body>
<!--header start-->
<?php include "include/header.php"; ?>
<!--header end--> 
<!--section about-->
<section class="about">
  <div class="wrapper">
  	<div>
    <h1 class="heading_pens"> <?php echo $fetch_abt['name']; ?></h1>
    <p class="discripation"> <?php echo $fetch_abt['description']; ?> </p>
    </div>
  </div>
</section>
<!--section about--> 
<!--footer start-->
<?php include "include/footer.php"; ?>
<!--footer end-->
</body>
</html>
