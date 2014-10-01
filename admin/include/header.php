<div class="top_header">
  <div class="logo" style="height:71px "> <!--<a href="dashboard.php"> <img src="images/logo2.png"  width="172" height="69" />--> </a> </div>
  <div class="site_name" style="font-size:22px;"><?php echo $site_name; ?> Admin Panel </div>
  <div class="top_header_right">
    <div class="clock">
      <div id="Date"></div>
      <ul>
        <li id="hours">LO</li>
        <li id="point">:</li>
        <li id="min">AD</li>
        <li id="point">:</li>
        <li id="sec">IN</li>
        <li id="ap">G...</li>
      </ul>
    </div>
  </div>
  <a class="log" href="logout.php">Logout</a> <a class="log" href="update_profile.php">Update Profile</a> </div>
<div class="header">
  <div class="list">
    <ul id="nav">
      <!--<li class="dashboard"> <a href="#"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="slideshow4<?php echo $pg_active['user']; ?> ">Profile Managment</span> </span> <span class="dashboardright"></span> </a>
        <ul>
          <li class="listdiv"></li>
           <li><a href="manage_users.php">Users</a></li> 
         <li class="listdivbtm"></li>
        </ul>
      </li>-->
      <li class="dashboard"> <a href="manage_slideshow.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="slideshow4<?php echo $pg_active['sld']; ?> ">Slideshow</span> </span> <span class="dashboardright"></span> </a></li>
      <li class="dashboard"> <a href="manage_category.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="slideshow4<?php echo $pg_active['cat']; ?> ">Category</span> </span> <span class="dashboardright"></span> </a></li>
      <li class="dashboard"> <a href="manage_product.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="slideshow4<?php echo $pg_active['pdt']; ?> ">Products</span> </span> <span class="dashboardright"></span> </a></li>
      <!--<li class="dashboard"> <a href="manage_blogs.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="slideshow4<?php echo $pg_active['blog']; ?> ">Blogs</span> </span> <span class="dashboardright"></span> </a></li>-->
      <li class="dashboard"> <a href="manage_order.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="slideshow4<?php echo $pg_active['order']; ?> ">Orders</span> </span> <span class="dashboardright"></span> </a></li>
      <li class="dashboard"> <a href="javascript:void(0)"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con']; ?>">Configuration</span> </span> <span class="dashboardright"></span> </a>
        <ul>
           <li class="listdiv"></li>
               <!--<li><a href="edit_contact.php?do=edit&id=1">Contact Us</a></li> -->
               <li><a href="edit_aboutus.php?do=edit&id=2">About Us</a></li>
               <!--<li><a href="edit_privacy.php?do=edit&id=3">Privacy Policy</a></li>
               <li><a href="manage_howitwrk.php">How It Works</a></li>
               <li><a href="edit_social_links.php?do=edit&id=1">Social Links</a></li>
               <li><a href="edit_homepage_content.php?do=edit&id=5">Homepage Content</a></li>-->
               <li><a href="edit_terms.php?do=edit&id=4">Terms & Conditions</a></li>
           <li class="listdivbtm"></li>
        </ul>
      </li>
    </ul>
    <div class="clear"></div>
  </div>
</div>
