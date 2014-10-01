<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	
	//for page content
	/*$sql_exec = select_query_without_status('content', '', '', "id='1'");
	$fetch_abt = mysql_fetch_assoc($sql_exec);*/
	$tabl = "users";
	
	if($_POST['submitbtn'] == "Register"){
		$dvar['email'] = $_POST['email'];
		$dvar['first_name'] = $_POST['first_name'];
		$dvar['last_name'] = $_POST['last_name'];
		$dvar['password'] = $_POST['password'];
		$dvar['address'] = $_POST['address'];
		$dvar['address1'] = $_POST['address1'];
		$dvar['suburb'] = $_POST['suburb'];
		$dvar['post_code'] = $_POST['post_code'];
		$dvar['phone_no'] = $_POST['phone_no'];
		$dvar['comment'] = $_POST['comment'];
		
		$u_chk = count_query_without_status('users', "email='".$dvar['email']."' AND archive=0");
		
	    if($dvar['email'] == ""){ $flag['8'] = 'r'; }
		else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $dvar['email'])){ $flag['9'] = 'r'; }
	    else if($u_chk <> "0"){ $flag['105'] = 'r'; }
		else if($dvar['password'] == ""){ $flag['110'] = 'r'; }
		else if($dvar['first_name'] == ""){ $flag['26'] = 'r'; }
		else if($dvar['last_name'] == ""){ $flag['27'] = 'r'; }
		else if($dvar['address'] == ""){ $flag['28'] = 'r'; }
		else if($dvar['suburb'] == ""){ $flag['30'] = 'r'; }
		else if($dvar['post_code'] == ""){ $flag['40'] = 'r'; }
		else if($dvar['phone_no'] == ""){ $flag['32'] = 'r'; }
		if(!empty($flag)){
			$flag_r = 'r';
		}
		else{
			$uniq = rg($tabl, 'uniq', '10');
			$add_dvar = array('uniq' => $uniq, 'status' => '1', 'time' => time());
//			$remove_dvar = array('terms', 'cpassword', 'cemail');
//			$change_dvar = array('status' => '1');
			list($insert_q[0], $insert_q[1]) = insert_query($dvar, $add_dvar, $remove_dvar, $change_dvar);
			 $sql = "INSERT into $tabl(sort, $insert_q[0]) SELECT max(sort)+1, $insert_q[1] from $tabl";
		}
		if(mysql_query($sql)){
			$flag['g'] = '2';
		}
		else{
			$flag['q'] = 'r';
		}
	}
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Customer Registration | Kevs Handcrafted Pens</title>
<?php include "include/head.php"; ?>
<link href="css/validationEngine.jquery_contform.css" rel="stylesheet" />
<?php if($flag['g'] <> ''){ ?>
<meta http-equiv="refresh" content="3; URL=customer.php">
<?php } ?>
</head>
<body>
<!--header start-->
<?php $arr['reg'] = 'class="active"'; include "include/header.php"; ?>
<!--header end--> 
<!--shopping cart section start-->
<section id="shop_pages">
  <div class="wrapper">
    <div class="shopping_row">
      <div class="list_shopping">
        <div class="left_shop_col">
          <h2>Customer Registration</h2>
          <div class="hold_list">
            <div class="register_heading">
              <p>Register to save your details and make it easier to order from Kev's Handcrafted Pens again in the future.</p>
            </div>
            <div class="imb"><img src="images/productcustomer.jpg" alt="" title="" /></div>
          </div>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="dev_signup" >
          <div class="form_ROW">
            <div class="name"><span>Please fill out the form below to register:</span></div>
             <div style="margin-left:10px"><?php  echo print_messages($flag, $error_message, $success_message);	?></div>

            <div class="name">
              <label>Email</label>
              <input type="text" placeholder="Type here" name="email" value="<?php echo $dvar['email']; ?>" class="validate[required,custom[email]]">
            </div>
            <div class="name">
              <label>Password:</label>
              <input class="validate[required]"  type="password" placeholder="Type here" name="password" value="<?php echo $dvar['password']; ?>">
            </div>
            <div class="name">
              <label>First Name</label>
              <input  class="validate[required]"  type="text" placeholder="Type here" name="first_name" value="<?php echo $dvar['first_name']; ?>">
            </div>
            <div class="name">
              <label>Last Name</label>
              <input  class="validate[required]"  type="text" placeholder="Type here" name="last_name" value="<?php echo $dvar['last_name']; ?>">
            </div>
            <!--<div class="name">
              <label>Email Address</label>
              <input type="text" placeholder="Type here" >
            </div>-->
            <div class="name">
              <label>Address Line 1:</label>
              <input  class="validate[required]"  type="text" placeholder="Type here" name="address" value="<?php echo $dvar['address']; ?>">
            </div>
            <div class="name">
              <label>Address Line 2:</label>
              <input type="text" placeholder="Type here" name="address1" value="<?php echo $dvar['address1']; ?>">
            </div>
            <div class="name">
              <label>Suburb</label>
              <input  class="validate[required]"  type="text" placeholder="Type here" name="suburb" value="<?php echo $dvar['suburb']; ?>">
            </div>
            <div class="name">
              <label>Post Code</label>
              <input  class="validate[required]"  type="text" placeholder="Type here" name="post_code" value="<?php echo $dvar['post_code']; ?>">
            </div>
            <div class="name">
              <label>Contact Phone No:</label>
              <input  class="validate[required]"  type="text" placeholder="Type here" name="phone_no" value="<?php echo $dvar['phone_no']; ?>">
            </div>
            <div class="name">
              <label>Comment</label>
              <textarea placeholder="Type here" name="comment"><?php echo $dvar['comment']; ?></textarea>
            </div>
            <div class="button_register"><input class="button_register_btn" type="submit" value="Register" name="submitbtn" ></div>
          </div>
          </form>
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--shopping car section end--> 

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
