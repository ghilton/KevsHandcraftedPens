<?php

echo "<ul id='nav'>
			<li $dash><a href='dashboard.php'>Dashboard</a></li>
			<li $prof><a href='update_password.php'>Update Profile</a></li>
			<li $sld><a href='slideshow.php'>Slideshow</a></li>
			<li $cat><a href='#'>Tips</a>
				<ul>
					<li><a href='categories.php'>Categories</a></li>
					<li><a href='subcategories.php'>Sub Categories</a></li>
					<li><a href='manage_tips.php'>Tips</a></li>
				</ul>
			</li>
			<li $cust><a href='#'>Customers</a>
				<ul>
					<li><a href='manage_customers.php'>View</a></li>
					<li><a href='add_edit_customers.php'>Add</a></li>
					<li><a href='modify.php'>Modify</a></li>
				</ul>
			</li>
			<li $sub><a href='#'>Subscribers</a>
				<ul>
					<li><a href='manage_subscribers.php'>View</a></li>
					<li><a href='add_edit_subscribers.php'>Add</a></li>
					<li><a href='modify_subscribers.php'>Modify</a></li>
				</ul>
			</li>
			<li $con><a href='#'>Configuration Section</a>
				<ul>";
					//<li><a href='manage_pages.php'>Pages</a></li>
			  echo "<li><a href='ad_page.php?do=edit&id=3&rel=3'>FAQ</a></li>
					<li><a href='add_page.php?do=edit&id=1&rel=1'>About Us</a></li>
					<li><a href='add_page.php?do=edit&id=7&rel=7'>Contact Us</a></li>
					<li><a href='addpage.php?do=edit&id=9&rel=9'>Tips Library</a></li>
					<li><a href='addpage.php?do=edit&id=10&rel=10'>Featured Tips</a></li>
					<li><a href='addpage.php?do=edit&id=11&rel=11'>Request a Tip</a></li>
					<li><a href='add_page.php?do=edit&id=11&rel=11'>Advertise Here</a></li>
					<li><a href='ad_page.php?do=edit&id=13&rel=13'>Terms and Conditions</a></li>
					<li><a href='ad_page.php?do=edit&id=4&rel=4'>Privacy Policy</a></li>
					<li><a href='add_page.php?do=edit&id=12&rel=12'>Home Page Blue Section</a></li>
					<li><a href='add_page.php?do=edit&id=13&rel=13'>Home page - Why Sign Up</a></li>
					<li><a href='add_page.php?do=edit&id=14&rel=14'>Sign Up</a></li>
					<li><a href='add_page.php?do=edit&id=16&rel=16'>Home page - From Our Blog</a></li>
					<li><a href='add_page.php?do=edit&id=15&rel=15'>Home page - About Us</a></li>
					<li><a href='manage_service.php'>Services</a></li>
				</ul>
			</li>
			<li><a href='logout.php'>Logout</a></li>
       </ul>";

?>