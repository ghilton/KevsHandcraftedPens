<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	
	//for page content
	/*$sql_exec = select_query_without_status('content', '', '', "id='1'");
	$fetch_abt = mysql_fetch_assoc($sql_exec);*/
	if($_POST['submitbtn'] == "Regester"){
		$dvar['email'] = $_POST['email'];
		$dvar['name'] = $_POST['name'];
		$dvar['subject'] = $_POST['subject'];
		$dvar['comment'] = $_POST['comment'];
		
		if($dvar['name'] == ""){ $flag['26'] = 'r'; }
	    else if($dvar['email'] == ""){ $flag['8'] = 'r'; }
		else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $dvar['email'])){ $flag['9'] = 'r'; }
		else if($dvar['subject'] == ""){ $flag['27'] = 'r'; }
		else if($dvar['comment'] == ""){ $flag['28'] = 'r'; }
		if(!empty($flag)){
			$flag_r = 'r';
		}
		else{
			$subject = $dvar['subject'];
			$email_to = $email_def;
			//$subject = "You have receive an query";
			//$message = wordwrap($HTML, 70);
			$message = "Hi Admin,"."<br />
You have receive an query as details are below:<br />
Name : ".$dvar['name']."<br />
Email : ".$dvar['email']."<br />
Subject : ".$dvar['subject']."<br />
Message : ".$dvar['comment']."<br />

From<br >".
$site_name;
			//$message = $dvar['message'];
			$messagef = wordwrap($message, 70);
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From: '.$site_name.'<'.$dvar['email'].'>'. "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";
			//$sent = mail($email_to,$subject,$message,$headers);
			if(mail($email_to,$subject,$messagef,$headers)){
				$flag[5] = 'g';
			}else{
				$flag['e'] = 'r';
			}
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Contact Us | Kevs Handcrafted Pens</title>
<?php include "include/head.php"; ?>
<link href="css/validationEngine.jquery_payment.css" rel="stylesheet" />
<?php if($flag['g'] <> ''){ ?>
<meta http-equiv="refresh" content="3; URL=contact.php">
<?php } ?>
<body>
	<!--header start-->
	<?php $arr['cont'] = 'class="active"'; include "include/header.php"; ?>
    <!--header end-->
    <!--contact us section start-->
    <section id="shop_pages">
    	<div class="wrapper">
    	 	<div class="register_heading">
              		<p>Please fill out the form below to contact me regarding Kevs Handcrafted Pens:</p>
           	 </div>
        	<div class="shopping_row">
            	<div class="list_shopping">
                    <div class="user_login">
                    <div style="margin-left:10px"><?php  echo print_messages($flag, $error_message, $success_message);	?></div>
         			 <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="dev_signup" >
                        	<div class="user_name"><label>Name:</label><input name="name" type="text" placeholder="Name" class="validate[required]" ></div>
                            <div class="user_name"><label>Email</label><input name="email" type="text" placeholder="Email" class="validate[required,custom[email]]"></div>
                            <div class="user_name"><label>Subject</label><input type="text" name="subject" placeholder="Subject" class="validate[required]" ></div>
                            <div class="user_name">
                            <label>Message</label>
                            <textarea class="validate[required]" placeholder="Type here" name="comment" name="comment"><?php echo $dvar['comment']; ?></textarea>
                          </div>
                          <div class="user_name"><input type="submit" class="user_name_btn" value="Send" name="submitbtn" /></div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
     </section>
     <!--contact us section end-->
    
    <!--footer start-->
<?php include "include/footer.php"; ?> 
<script type="text/javascript" src="js/jquery.js" ></script> 
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/script.js"></script> 
<script src="js/jquery.validationEngine-en.js"></script> 
<script src="js/jquery.validationEngine.js"></script> 
<script type="text/javascript">
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#dev_signup").validationEngine();
	});
</script> 
    <!--footer end-->
</body>
</html>