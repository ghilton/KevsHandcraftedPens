<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	$id = mysql_real_escape_string($_GET['id']);

	//for page content
	$sql_pdt = select_query('products', '', '', "id='".$id."'");
	$fetch_pdt = mysql_fetch_assoc($sql_pdt);
	$num = mysql_num_rows($sql_pdt);
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo ucwords($fetch_pdt['name']); ?> | Kev's Handcrafted Pens</title>
<?php include "include/head.php"; ?>
 </head>
<body>
	<!--header start-->
	<?php $arr['pdt'] = 'class="active"'; include "include/header.php"; ?>
    <!--header end-->
    <!--category section start-->
    <section class="product_row">
    	<div class="wrapper" style="min-height:325px">
        <?php if($num == 0){ ?>
          <h2 class="area_hed">No, Product Found </h2>
        <?php } else{ ?>
          <h2 class="area_hed"><?php echo ucwords($fetch_pdt['name']); ?></h2>
          <div class="product_main">
          	<div class="row_pro">
            	<div class="img-PRO"><img src="<?php if($fetch_pdt['image'] <> ''){ echo 'pics/'.$fetch_pdt['image']; } else{ ?>images/product.jpg<?php } ?>" alt="" title="" /></div>
                <h2 class="hed">Product Description</h2>
                <p class="product_more"><?php echo $fetch_pdt['description']; ?></p>
            </div>
            <div class="feature_list_main">
            	<div class="prise_row">
                <div class="price">$<?php echo $fetch_pdt['price']; ?></div> 
                     
                <a href="shoppingcart.php?do=cart&id=<?php echo $fetch_pdt['id']; ?>" title="Add to cart" class="cart">Add to Cart</a>
                <div class="clear"></div>
                </div>
                <div class="listing">
                	<h2>Features</h2>
                    <?php echo $fetch_pdt['features']; ?>
                    <!-- PayPal Logo --><a href="https://www.paypal.com/au/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/au/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, width=600, height=500'); return false;"><img src="https://www.paypalobjects.com/webstatic/en_AU/mktg/logo/Solution_graphics_2_184x80.jpg" border="0" alt="PayPal Logo"></a><!-- PayPal Logo -->
                </div>
            </div>
            <div class="clear"></div>
          </div>
    	<?php } ?></div>
      </section>
     <!--category section end-->
    
    <!--footer start-->
    	<?php include "include/footer.php"; ?> 

    <!--footer end-->
</body>
</html>