<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
	require_once('paypal-1.3.0/paypal.class.php'); 

//	include "include/functions.php";
	$tabl = "place_order";
	
	//for page content
	$sql_cart = "select * from cart where session='".$cart_sess."' order by time DESC";	
	$exec_cart = mysql_query($sql_cart);
	$num_cart = mysql_num_rows($exec_cart);
	if($num_cart == 0){
		header("location: shoppingcart.php"); die;
	}
	
	//for total amount
	$sql_t = "select sum(t_price) as tamount, sum(quantity) as tquantity from cart where session='".$cart_sess."'";
	$exec_t = mysql_query($sql_t);
	$fetch_t = mysql_fetch_assoc($exec_t);
	//print_r($fetch_t);
	
	

	$sql_ck = "select * from $tabl where session='".$cart_sess."'";
	$exec_ck = mysql_query($sql_ck);
	$num_ck = mysql_num_rows($exec_ck);
	$fetch_ck = mysql_fetch_assoc($exec_ck);

	
	if($_POST['submitbtn'] == "Pay With Paypal Now"){
		$dvar['first_name'] = $_POST['first_name'];
		$dvar['last_name'] = $_POST['last_name'];
		$dvar['email'] = $_POST['email'];
		$dvar['address'] = $_POST['address'];
		$dvar['address1'] = $_POST['address1'];
		$dvar['suburb'] = $_POST['suburb'];
		$dvar['post_code'] = $_POST['post_code'];
		$dvar['phone_no'] = $_POST['phone_no'];
		$dvar['comment'] = $_POST['comment'];
		$dvar['amount'] = $fetch_t['tamount'];
		$dvar['quantity'] = $fetch_t['tquantity'];
		if($dvar['first_name'] == ""){
			$flag[26] = "r";
		}
		else if($dvar['first_name'] == ""){
			$flag[27] = "r";
		}
		else if($dvar['email'] == ""){
			$flag[8] = "r";
		}
		else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $dvar['email'])){$flag[9] = "r";}
		else if($dvar['address'] == ""){
			$flag[28] = "r";
		}
		else if($dvar['suburb'] == ""){
			$flag[30] = "r";
		}
		else if($dvar['post_code'] == ""){
			$flag[29] = "r";
		}
		else if($dvar['phone_no'] == ""){
			$flag[32] = "r";
		}
		if(!empty($flag)){
			$flag_r = 'r';
		}
		else{ 
			if($num_ck == 0){
				$column = "uniq";
				$length = "8";
				$uniq = rg($tabl, $column, $length);
				$add_dvar = array('uniq' => $uniq, 'session' => $cart_sess, 'status' => '0', 'time' => time());
	//			$remove_dvar = array('totalamount');
	//			$change_dvar = array('status' => '1');
	
				list($insert_q[0], $insert_q[1]) = insert_query($dvar, $add_dvar, $remove_dvar, $change_dvar);
				$sql = "INSERT into $tabl(sort, $insert_q[0]) SELECT max(sort)+1, $insert_q[1] from $tabl";
			}
			else{

			$add_dvar = array('status' => '0', 'time' => time());
//			$remove_dvar = array('totalamount');
//			$change_dvar = array('status' => '0');
			
			$sql = "UPDATE $tabl SET ".update_query($dvar, $add_dvar, $remove_dvar, $change_dvar)." where session='".$cart_sess."'";
			} //echo $sql;
			if(mysql_query($sql)){
			
				$p = new paypal_class;             // initiate an instance of the class
				if($sandbox_env == 1){
					$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
				}else{
					$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
				}
							
				  // setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
				  $this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
				  $p->add_field('business', $email_merchant);
				  $p->add_field('return', ROOT_URL."/payment_success.php?cart=$cart_sess");
				  $p->add_field('cancel_return', $this_script.'?action=cancel');
				  $p->add_field('notify_url', ROOT_URL."/ipn.php?cart=$cart_sess");
				  $p->add_field('item_name', $site_name);
				  $p->add_field('amount', $dvar['amount']);
	
				  $p->add_field('name', $dvar['first_name']);
				  $p->add_field('last_name', $dvar[last_name]);
				  $p->add_field('state', $dvar['suburb']);
				  $p->add_field('zip', $dvar['post_code']);
				  $p->add_field('address1', $dvar['address']);
				  $p->add_field('address2', $dvar['address1']);
				 // $p->add_field('city', $fetch_u['city']);
				 // $p->add_field('country', $fetch_c['country_name']);
				  $p->add_field('email', $dvar['email']);
			
				  $p->submit_paypal_post(); // submit the fields to paypal
				  //$p->dump_fields();      // for debugging, output a table of all the fields
				  
				 // $flag = 'g';
				  $flag['g'] = 'g';
					
			}
			else{
				$flag['q'] = "r";
				// $flag['g'] = '219';
			}
		}
		
	}
	else if($num_ck <> 0){
		$dvar['first_name'] = $fetch_ck['first_name'];
		$dvar['last_name'] = $fetch_ck['last_name'];
		$dvar['email'] = $fetch_ck['email'];
		$dvar['address'] = $fetch_ck['address'];
		$dvar['address1'] = $fetch_ck['address1'];
		$dvar['suburb'] = $fetch_ck['suburb'];
		$dvar['post_code'] = $fetch_ck['post_code'];
		$dvar['phone_no'] = $fetch_ck['phone_no'];
		$dvar['comment'] = $fetch_ck['comment'];
	}
	else{
		$dvar['first_name'] = $fetch_u['first_name'];
		$dvar['last_name'] = $fetch_u['last_name'];
		$dvar['email'] = $fetch_u['email'];
		$dvar['address'] = $fetch_u['address'];
		$dvar['address1'] = $fetch_u['address1'];
		$dvar['suburb'] = $fetch_u['suburb'];
		$dvar['post_code'] = $fetch_u['post_code'];
		$dvar['phone_no'] = $fetch_u['phone_no'];
		$dvar['comment'] = $fetch_u['comment'];
	}
if($flag['g'] != 'g'){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Checkout | Kev's Handcrafted Pens</title>

<?php include "include/head.php"; ?>
<link href="css/validationEngine.jquery_checkout.css" rel="stylesheet" />

</head>
<body>
<!--header start-->
<?php  include "include/header.php"; ?>
<!--header end--> 
<!--shopping cart section start-->
<section id="shop_pages">
  <div class="wrapper">
    <div class="shopping_row">
      <div class="list_shopping">
        <div class="left_shop_col">
          <h2>Checkout</h2>
          <div class="hold_list">
            <ul>
              <span>Item List</span>
              <?php while($fetch_cart = mysql_fetch_assoc($exec_cart)){ 
			  			$sql_pdt = "select image, id, name  from products where id='".$fetch_cart['product']."' AND status='1'";
						$exec_pdt = mysql_query($sql_pdt);
						$fetch_pdt = mysql_fetch_assoc($exec_pdt);
			  ?>
              <li><a href="javascript:void(0)"><?php echo $fetch_pdt['name']; ?> </a><br/><img src="/pics/<?php echo $fetch_pdt['image']; ?>" width="150px" height="150px"></li>
              <?php } ?>
            </ul>
          </div>
          <div class="form_ROW">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="dev_payapal" >
            <div class="name">
              <label>First Name<span class="star">*</span>:</label>
              <input type="text" placeholder="Type here" name="first_name" value="<?php echo $dvar['first_name']; ?>" class="validate[required]">
            </div>
            <div class="name">
              <label>Last Name<span class="star">*</span>:</label>
              <input type="text" placeholder="Type here" name="last_name" value="<?php echo $dvar['last_name']; ?>" class="validate[required]">
            </div>
            <div class="name">
              <label>Email Address<span class="star">*</span>:</label>
              <input type="text" placeholder="Type here" name="email" value="<?php echo $dvar['email']; ?>" class="validate[required,custom[email]]">
            </div>
            <div class="name">
              <label>Address Line 1<span class="star">*</span>:</label>
              <input type="text" placeholder="Type here" name="address" value="<?php echo $dvar['address']; ?>" class="validate[required]">
            </div>
            <div class="name">
              <label>Address Line 2:</label>
              <input type="text" placeholder="Type here"  name="address1" value="<?php echo $dvar['address1']; ?>">
            </div>
            <div class="name">
              <label>Suburb<span class="star">*</span>:</label>
              <input type="text" placeholder="Type here"  name="suburb" value="<?php echo $dvar['suburb']; ?>" class="validate[required]">
            </div>
            <div class="name">
              <label>Post Code<span class="star">*</span>:</label>
              <input type="text" placeholder="Type here"  name="post_code" value="<?php echo $dvar['post_code']; ?>" class="validate[required]">
            </div>
            <div class="name">
              <label>Contact Phone No<span class="star">*</span>:</label>
              <input type="text" placeholder="Type here"  name="phone_no" value="<?php echo $dvar['phone_no']; ?>" class="validate[required]">
            </div>
            <div class="name">
              <label>Comment:</label>
              <textarea placeholder="Type here" name="comment"><?php echo $dvar['comment']; ?></textarea>
            </div>
             <div class="name">
              <label>&nbsp;</label>
              <input type="submit" value="Pay With Paypal Now" name="submitbtn" class="paypal_button_chk" >
            </div>
        </form>
          </div>
          <div class="clear"></div>
        </div>
        <div class="paybal_row">
          <div class="left-PRICE">
            <div class="pri">Total Quantity: <?php echo $fetch_t['tquantity']; ?></div>
            <div class="pri">Total Price: $<?php echo $fetch_t['tamount']; ?></div>
            <div class="pri"><strong>Term and Conditions:</strong> When you purchase something from our store, as part of the buying and selling process, we collect the personal information you give us such as your name, address and email address. This information will only be used to contact you and fulfill your order and will not be shared with any third parties.<br/>
            <strong>Refunds:</strong> To be eligible for a return, you must contact me immediately and return your item unused and in the same condition that you received it within 10 business days. It must also be in the original packaging.</div>
          </div>
          <div class="total_pay"><!-- <span>Total price: $</span>-->
           <!-- <div class="paypal_button"><a href="#">Pay With Paypal Now</a></div>-->
            <div class="method"><!-- PayPal Logo --><a href="https://www.paypal.com/au/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/au/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, width=600, height=500'); return false;"><img src="https://www.paypalobjects.com/webstatic/en_AU/mktg/logo/Solution_graphics_2_184x80.jpg" border="0" alt="PayPal Logo"></a><!-- PayPal Logo --> 
            
              <!--<div class="right_add"><img src="images/add.png" alt="" title="" /></div>-->
              <div class="clear"></div>
            </div>
          </div>
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
		jQuery("#dev_payapal").validationEngine();
	});
</script> 
<!--footer end-->
</body>
</html>
<?php } ?>