<?php
	//for banner
	$sql_banner = select_query("slideshow", "", " sort ASC", "archive='0'");
?>
<div class="banner">
    <div class="flexslider">
      <ul class="slides">
      <?php while($fetch_banner = mysql_fetch_assoc($sql_banner)){ ?>
        <li> <img src="pics/<?php echo $fetch_banner['image']; ?>" width="100%"  alt="img" />
          <div class="sub_container">
            <div class="txt_main">
              <div class="txt_a"><?php echo $fetch_banner['name']; ?></div>
              <div class="clear"></div>
              <div class="txt_b"><?php echo strlen($fetch_banner['description']) > 100 ? substr($fetch_banner['description'], 0,100) : $fetch_banner['description']; ?></div>
              <div class="clear"></div>
              <a href="#" class="snwbtn">Sign Up Now!</a> </div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>