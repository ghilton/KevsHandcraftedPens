<?php
	$sql_categ = select_query('categories', '', 'name ASC', "");

?>

<footer>
        	<div class="wrapper">
                	<div class="foot">
                        <ul>
                          <li><a href="/" title="Home">Home</a></li>
      			
      				<?php 	while($fetch_categ = mysql_fetch_assoc($sql_categ)){  ?>
                              <li><a href="category.php?cat=<?php echo $fetch_categ['id']; ?>"><?php echo ucwords($fetch_categ['name']); ?></a></li>
                            <?php } ?>
      			
                          <!--<li><a href="category.php" title="Category">Category</a></li>-->
                          <li><a href="about.php" title="About us">About us</a></li>
                          <?php if($user_status <> 1){ ?>
                          <li>	<a href="customer.php" title="Log In" <?php echo $arr['login']; ?>>Log In</a></li>
                          <li><a href="customerregister.php" title="Register" <?php echo $arr['reg']; ?>>Register</a></li>
                          <?php } else { ?>
                          <li><a href="customerupdate.php" title="Update Profile" <?php echo $arr['login']; ?>>Update profile</a></li>
                          <li><a href="logout.php" title="Logout" <?php echo $arr['reg']; ?>>Logout</a></li>
                          <?php } ?>
                          <li><a href="contact.php" title="Contact">Contact</a></li>
                            <!--<li><span class="most"><img src="images/copy.png" alt="" title="" /><a>&nbsp;<?php echo $site_name; ?></span></li>-->
                        </ul>
                    <div class="clear"></div>
                    </div>
                 	<div class="copy_right_pens">
                        <a href="shoppingcart.php" title="" class="cart_button">Cart :  (<?php echo $t_crt_item; ?>)</a>
                        <a href="checkout.php" title="" class="cart_button checkout_button">Checkout</a>
                	</div>
                <div class="clear"></div>
                
            </div>
            </div>
        </footer>