<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	
	//for page content
	/*$sql_exec = select_query_without_status('content', '', '', "id='1'");
	$fetch_abt = mysql_fetch_assoc($sql_exec);*/
	if($_POST['submitbtn'] == "Login"){ 
		$dvar['email'] = mysql_real_escape_string($_POST['email']);
		$dvar['password'] = mysql_real_escape_string($_POST['password']); 
		$dvar['remember'] = mysql_real_escape_string($_POST['remember']);
		
		//for chk user already exits or not
		 $u_chk = count_query_without_status('users', "email='".$dvar['email']."' AND password='".$dvar['password']."' AND archive=0 AND status='1'");
	    if($dvar['email'] == ""){ $flag['8'] = 'r'; }
		else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $dvar['email'])){ $flag['9'] = 'r'; }
	    else if($dvar['password'] == ""){ $flag['110'] = 'r'; }
		else if($u_chk == "0"){ $flag['20'] = 'r'; }
		else{
		 	$condi = "select * from users where status=1 AND email='".$dvar['email']."' AND password='".$dvar['password']."' AND archive=0";
			$exec = mysql_query($condi);//select_query("users", '', '', $condi); die;
			$num = mysql_num_rows($exec);
			if($u_chk == '1'){ 
				$fetch_log = mysql_fetch_assoc($exec); 
					if($fetch_log['status'] == '1'){
						$_SESSION['user'] = $fetch_log['uniq'];
						if($dvar['remember'] == '1'){
							$_SESSION['remember'] = $fetch_log['uniq'];
						}
						if($page != ''){ 
							header("Location: logging_in.php?page=".urlencode($page));
						}
						else{
							header("location: index.php");
						}
					}
					else{
						$flag[60] = 'r';
					}
			}
			else{
				$flag[60] = 'r';
			}
		}

	
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Customer Login | Kevs Handcrafted Pens</title>
<?php include "include/head.php"; ?>
<link href="css/validationEngine.jquery_contform.css" rel="stylesheet" />
 </head>
<body>
	<!--header start-->
	<?php $arr['login'] = 'class="active"'; include "include/header.php"; ?>
    <!--header end-->
    <!--shopping cart section start-->
    <section id="shop_pages">
    	<div class="wrapper">
        	<div class="shopping_row">
            	<div class="list_shopping">
                	<div class="left_shop_col">
                    	<h2>Customer Login</h2>
                        <div class="customer_discri">
                            <p>Login to have all your details prefilled.</p>
                        </div>
                    </div>
                    <div class="user_login">
                    <div class="user_name">
                     <div style="margin-left:10px"><?php  echo print_messages($flag, $error_message, $success_message);	?></div></div>

                    	<form id="dev_login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        	<div class="user_name"><label>Email:</label><input type="text" placeholder="Email:" class="validate[required,custom[email]]" name="email" value="<?php echo $dvar['email']; ?>"></div>
                            <div class="user_name"><label>Password</label>
                            <input type="password" placeholder="Password" name="password" class="validate[required]"></div>
                             <!--<div class="user_name"><a class="user_name_btn" href="#">Submit</a></div>-->
                            <div class="user_name"><input type="submit" class="user_name_btn" value="Login" name="submitbtn" /></div>
                        </form>
                    </div>
                    <div class="product_img_cusmom">
                    	<div class="boxs_f"><img src="images/cat1.jpg" alt="" title="" /></div>
                        <div class="boxs_l"><img src="images/cat3.jpg" alt="" title="" /></div>
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
		jQuery("#dev_login").validationEngine();
	});
</script>
    <!--footer end-->
</body>
</html>
