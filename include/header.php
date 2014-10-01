<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54077288-1', 'auto');
  ga('send', 'pageview');

</script>

<?php
	$sql_categ = select_query('categories', '', 'name ASC', "");

?>

<header>
		<div class="wrapper">
           <div class="head-row">
                <div class="head_left">
                    <a href="/">Kev's Handcrafted Pens</a>
                </div>
         
                <div class="head_right" style="padding-bottom: 5px;">
                	<a href="shoppingcart.php" title="" class="cart_button">Cart :  (<?php echo $t_crt_item; ?>)</a>
                    <a href="checkout.php" title="" class="cart_button checkout_button">Checkout</a>
                </div>
                <div class="clear"></div>
            </div>
            <!--nav start-->
            <nav>
            	<div class="nav_slide"><a href="javascript:void(0)"><img src="images/nav_slide.png" alt="" title="" /></a></div>
            	<div class="navigation">
                    <ul>
                        <li><a href="index.php" title="Home" <?php echo $arr['home']; ?> >Home</a></li>
                        <li><a href="javascript:void(0)" title="Category" <?php echo $arr['cat']; ?>>Category</a>
                         <ul>
                         	<?php 	while($fetch_categ = mysql_fetch_assoc($sql_categ)){  ?>
                              <li><a href="category.php?cat=<?php echo $fetch_categ['id']; ?>"><?php echo ucwords($fetch_categ['name']); ?></a></li>
                            <?php } ?>
                         </ul>
                        </li>
                       <!-- <li><a href="product.php" title="Product" <?php echo $arr['pdt']; ?>>Product</a></li>-->
                        <?php if($user_status <> 1){ ?>
                        <li><a href="customer.php" title="Log In" <?php echo $arr['login']; ?>>Log In</a></li>
                        <li><a href="customerregister.php" title="Register" <?php echo $arr['reg']; ?>>Register</a></li>
                        <li><a href="contact.php" title="Contact" <?php echo $arr['cont']; ?>>Contact</a></li>
                        <?php } else { ?>
                        <li><a href="contact.php" title="Contact" <?php echo $arr['cont']; ?>>Contact</a></li>
                        <li><a href="customerupdate.php" title="Update Profile" <?php echo $arr['login']; ?>>Update Profile</a></li>
                        <li><a href="logout.php" title="Logout" <?php echo $arr['reg']; ?>>Logout</a></li>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div>
                
                
                <div class="clear"></div>
            </nav>
            <!--nav end-->
        </div>
	</header>