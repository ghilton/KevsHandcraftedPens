<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	
$tabl = "cart";
$item = "cart";
$id = mysql_real_escape_string($_GET['id']);

if($_GET['do'] == "cart"){
	$dvar['product'] = $_GET['id'];
	//for product cost
	$sql_p = "select price, image, id, name  from products where id='".$id."' AND status='1'";
	$exec_p = mysql_query($sql_p);
	$fetch_p = mysql_fetch_assoc($exec_p);
	
	
	//for check cart entry
	$sql_cart1 = "select * from cart where session='".$cart_sess."' AND product='".$dvar['product']."'";
	$exec_cart1 = mysql_query($sql_cart1);
	$num_cart1 = mysql_num_rows($exec_cart1);
	$fetch_cart1 = mysql_fetch_assoc($exec_cart1);
	if($num_cart1 <> 0){
		$dvar['quantity'] = $fetch_cart1['quantity'] + 1;
	}else{
		$dvar['quantity'] = 1;
	}
	$dvar['price'] = $fetch_p['price'];
	$dvar['t_price'] = $fetch_p['price']*$dvar['quantity'];
	if($num_cart1 <> 0){
		$add_dvar = array( 'time' => time());
//		$remove_dvar = array('id');
//			$change_dvar = array('status' => '0');
		//$remove_dvar = array('c_password');
		$sql = "UPDATE $tabl SET ".update_query($dvar, $add_dvar, $remove_dvar, $change_dvar)." where id='".$fetch_cart1['id']."'";
		$fg = 'ed';
	}else{
		$column = "uniq";
		$length = "12";
		$uniq = rg($tabl, $column, $length);
		$add_dvar = array('uniq' => $uniq, 'session' => $cart_sess, 'time' => time());
	//	$remove_dvar = array('min_quantity', 'max_quantity');
	//	$change_dvar = array('status' => '1');
	
		list($insert_q[0], $insert_q[1]) = insert_query($dvar, $add_dvar, $remove_dvar, $change_dvar);
		
		$sql = "INSERT into $tabl(sort, $insert_q[0]) SELECT max(sort)+1, $insert_q[1] from $tabl";
		$fg = 'ad';
	}
	if(mysql_query($sql)){
		header("location: shoppingcart.php"); die;
	}
	else{
		die(mysql_error());
		$flag['q'] = 'r';
	}
}
if($_GET['do'] == "delete"){
	$id = mysql_real_escape_string($_GET['id']);
	$sql_del = "delete from cart where id='".$id."'";
	if(mysql_query($sql_del)){
		header("location: shoppingcart.php");
		die;
	}
}
if($flag[$fg] <> ''){
	$sql_cart = "select * from cart where session='".$cart_sess."' order by time DESC";
}
else{
	$sql_cart = "select * from cart where session='".$cart_sess."' order by time DESC";
}
$exec_cart = mysql_query($sql_cart);
$num_cart = mysql_num_rows($exec_cart);

//for total amount
$sql_t = "select sum(t_price) as tamount, sum(quantity) as tquantity from cart where session='".$cart_sess."'";
$exec_t = mysql_query($sql_t);
$fetch_t = mysql_fetch_assoc($exec_t);

//for update quantity
if($_POST['updatebtn'] == "update"){
	$quantity = trim($_POST['quantity']);
	$price = $_POST['price'];
	$p_id = $_POST['item'];
	$t_price = $price*$quantity;
	
	if($quantity <= 0 || $quantity == ""){
        $sql_up = "update cart set quantity='0', t_price='0' where id='".$p_id."'";
		
	}else{
		$sql_up = "update cart set quantity='".$quantity."', t_price='".$t_price."' where id='".$p_id."'";
		if(mysql_query($sql_up)){
			header("location: shoppingcart.php"); die;
		}
	}

	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shopping Cart | Kev's Handcrafted Pens</title>
<?php include "include/head.php"; ?>
</head>
<body>
<!--header start-->
<?php include "include/header.php"; ?>
<!--header end--> 
<!--shopping cart section start-->
<section id="shop_pages">
  <div class="wrapper">
    <div class="shopping_row">
      <div class="list_shopping">
        <section id="shop_pages">
          <div class="wrapper">
            <div class="hop-rows">
              <h2 class="my_cart_heading">My Cart</h2>
              <table cellpadding="0" border="0" cellspacing="0">
                <tr class="most_we">
                  <td style="text-align:left; padding-left:15px;">Product</td>
                  <td>Qty</td>
                  <td>Price/Unit</td>
                  <td>Total</td>
                  <td>Remove</td>
                </tr>
                <?php if($num_cart == 0){ ?>
                <tr>
                  <td colspan="5" align="center" ><h1>No item found</h1></td>
                </tr>
				<?php }else{ while($fetch_cart = mysql_fetch_assoc($exec_cart)){   
						$sql_pdt = "select image, id, name  from products where id='".$fetch_cart['product']."' AND status='1'";
						$exec_pdt = mysql_query($sql_pdt);
						$fetch_pdt = mysql_fetch_assoc($exec_pdt);
				?>
                <tr>
                  <td><div class="use_ron"><img class="my_cart_item_img" src="pics/<?php echo $fetch_pdt['image']; ?>" width="88" >
                     	 <h3><?php echo $fetch_pdt['name']; ?></h3>
                       </div>
                  </td>
                  <td  style=" text-align:center">
                    <div style="margin-left:10px"><?php  echo print_messages($flag, $error_message, $success_message);	?></div>

                  	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                  		<input type="text" placeholder="1" value="<?php echo $fetch_cart['quantity']; ?>" name="quantity" class="type_box">
                        <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="item" >
                        <input type="hidden" value="<?php echo $fetch_cart['price']; ?>" name="price" >
                        <input type="submit" value="update" name="updatebtn" class="cart_update_btn" title="Update" >
                  	</form>
                  </td>
                  <td  style=" text-align:center">$ <?php echo $fetch_cart['price']; ?></td>
                  <td  style=" text-align:center">$ <?php echo $fetch_cart['t_price']; ?></td>
                  <td  style=" text-align:center"><a href="shoppingcart.php?do=delete&id=<?php echo $fetch_cart['id']; ?>" title="Delete"><img src="images/close.png" alt="" title="" /></a></td>
                </tr>
                <?php } } ?>
                <tr>
                  <td colspan="5">&nbsp;</td>
                </tr>
                <tr class="most_we">
                  <td style="text-align:left; padding-left:15px;">Total</td>
                  <td >Qty: <?php echo $fetch_t['tquantity']; ?> </td>
                  <td></td>
                  <td >$<?php echo $fetch_t['tamount']; ?></td>
                  <td></td>
                </tr>
              </table>
            </div>
          </div>
        </section>
        <div class="paybal_row">
          <div class="left-PRICE">
            <div class="method">Accepted Payment Methods:<br/>
            <!-- PayPal Logo --><a href="https://www.paypal.com/au/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/au/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, width=600, height=500'); return false;"><img src="https://www.paypalobjects.com/webstatic/en_AU/mktg/logo/Solution_graphics_2_184x80.jpg" border="0" alt="PayPal Logo"></a><!-- PayPal Logo -->
              <!--<div class="right_add" style="float:none;"><img src="images/add.png" alt="" title="" /></div>-->
            </div>
            <!--<div class="pri">Price: $</div>
                            <!0<div class="pri">Term and Conditions<br/>
                            </div>--> 
          </div>
          <div class="total_pay">
            <div class="paypal_button" style="margin-bottom:15px;"><a href="<?php if($num_cart == 0){ ?>javascript:void(0)<?php } else{ echo 'checkout.php';} ?>"  >Checkout Now</a></div>
            <div class="pri"><strong>Term and Conditions:</strong> When you purchase something from our store, as part of the buying and selling process, we collect the personal information you give us such as your name, address and email address. This information will only be used to contact you and fulfill your order and will not be shared with any third parties.<br/>
            <strong>Refunds:</strong> To be eligible for a return, you must contact me immediately and return your item unused and in the same condition that you received it within 10 business days. It must also be in the original packaging.
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
<!--footer end-->
</body>
</html>