<?php
include "init.php";
include "config_db.php";
include "config.php";
//include "include/functions.php"; 

$tabl = "place_order";

$uniq_id = mysql_real_escape_string($_GET['cart']);
$cart_sess = $uniq_id;
if(isset($_SESSION['cart'])){
	 unset($_SESSION['cart']);	
}

//echo $cart_sess;
		//for page content
	$sql_cart = "select * from cart where session='".$cart_sess."' order by time DESC";	
	$exec_cart = mysql_query($sql_cart);
	$num_cart = mysql_num_rows($exec_cart);
	
	//for total amount
	$sql_t = "select sum(t_price) as tamount, sum(quantity) as tquantity from cart where session='".$cart_sess."'";
	$exec_t = mysql_query($sql_t);
	$fetch_t = mysql_fetch_assoc($exec_t);
	//print_r($fetch_t);
	
	

	$sql_ck = "select * from $tabl where session='".$cart_sess."'";
	$exec_ck = mysql_query($sql_ck);
	$num_ck = mysql_num_rows($exec_ck);
	$fetch_ck = mysql_fetch_assoc($exec_ck);





?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Payment Successful | Kev's Handcrafted Pens</title>
<?php include "include/head.php"; ?>
</head>
<body>
<!--header start-->
<?php include "include/header.php"; ?>
<!--header end--> 
<!--shopping cart section start-->
<section id="shop_pages" style="min-height:375px">
  <div class="wrapper">
    <div class="shopping_row">
      <div class="list_shopping">
        <section id="shop_pages">
          <div class="wrapper">
            <div class="hop-rows">
              <h2 class="my_cart_heading"> Payment Success </h2>
                <div class="clear"></div>
               	 <div class="paybal_row">
                  <div class="left-PRICE">
                    <div class="pay_ment kls">Thank You For Your Order! Your transaction has been completed and a receipt for your purchase has been emailed to you. You may log into your account at <a href="http://www.paypal.com/au">www.paypal.com/au</a> to view details of this transaction.
                    </div>
                  </div>
                  <div class="clear"></div>
                </div><br />
                 <div class="clear"></div>
                <table cellpadding="0" border="0" cellspacing="0">
                <tr class="most_we">
                  <td style="text-align:left; padding-left:15px;">Order Details</td>
                  <td>Qty</td>
                  <td>Price/Unit</td>
                  <td>Total</td>
                  <td>Order Id</td>
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
                  <td  style=" text-align:center"><?php echo $fetch_cart['quantity']; ?></td>
                  <td  style=" text-align:center">$ <?php echo $fetch_cart['price']; ?></td>
                  <td  style=" text-align:center">$ <?php echo $fetch_cart['t_price']; ?></td>
                  <td  style=" text-align:center"><?php echo $fetch_ck['id']; ?></td>
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