<?php
include "../init.php";					// include init
include "../config_db.php";				// database connection details stored here
include "include/protecteed.php";		// page protect function here

$id = $_GET['id'];
$item = "Product";
$tabl = 'products';
$page_parent = 'manage_product.php';  // for redirection

$query_string = array("search" => $_GET['search'],"type" => "1" ,"page" => $_GET['page'], "rel_id" => $_GET['rel_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

// for fetch data
$sql = "SELECT * from $tabl where id='".$id."'";
$exec = mysql_query($sql) or die(mysql_error());
$fetch = mysql_fetch_assoc($exec);


//for category
$sql_cat = "select * from categories where status=1 AND archived=0 AND type=1 AND id = '".$fetch['category']."'";
$exec_cat = mysql_query($sql_cat);
$fetch_cat = mysql_fetch_assoc($exec_cat);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View <?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<script type="text/javascript">
jQuery(document).ready(function () {
	$('input#start_date').simpleDatepicker({ startdate: 2012, enddate: 2099 });
	$('input#end_date').simpleDatepicker({ startdate: 2012, enddate: 2099 });
});
</script>
</head>
<body>
<div align="center">
  <div class="container">
	<?php $pg_active['pdt'] = 'active'; require_once('include/header.php');  ?>
    <div class="content">
      <div class="viewform">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <table width="950" border="0" cellpadding="5">
          <tr>
            <td align="right" class="label_form"><div class="view1">Name :</div></td>
         	<td><div class="view2"><?php echo ucwords($fetch['name']); ?></div></td>
         </tr>
          <tr>
            <td align="right" class="label_form"><div class="view1">Category :</div></td>
         	<td><div class="view2"><?php echo ucwords($fetch_cat['name']); ?></div></td>
         </tr>
          <tr>
            <td align="right" class="label_form"><div class="view1">Price :</div></td>
         	<td><div class="view2">$<?php echo $fetch['price']; ?></div></td>
         </tr>
         <tr>
              <td align="right" class="label_form"><div class="view1">Images :</div></td>
              <td><div class="view2"> <div class="pic"><img src="<?php if($fetch['thumb'] <> ''){echo '../thumb/'.$fetch['thumb'];}else{echo 'images/1.png';} ?>" alt="images/1" width="98" height="98" /> </div></div></td>
         </tr>  
          <tr>
            <td align="right" valign="top" class="label_form"><div class="view1">Description :</div></td>
         	<td><div class="view2"><?php echo $fetch['description']; ?></div></td>
         </tr>
          <tr>
            <td align="right" valign="top" class="label_form"><div class="view1">Other Features  :</div></td>
         	<td><div class="view2"><?php echo $fetch['features']; ?></div></td>
         </tr>
         <?php while($fetch1 = mysql_fetch_assoc($exec1)){ if($fetch1['image'] <> ''){ ?>
         <tr>
              <td align="right" class="label_form"><div class="view1">Images :</div></td>
              <td><div class="view2"> <div class="pic"><img src="<?php echo '../pics/'.$fetch1['image']; ?>" alt="images/1" width="98" height="98" /> </div></div></td>
         </tr> 
         <?php } } ?> 
         <tr>
         	<td align="right" class="label_form"><div class="view1">Status :</div></td>
            <td><div class="view2">
			<?php 
				if($fetch['status'] == 1){ ?> <span style="color:#0C0">Active</span><?php } 
				else if($fetch['status'] == 0){ ?><span style="color:#C00">Inactive</span><?php } ?>
				<?php //else if($dvar['status'] == 2){ echo '<span style="color:#990000">Banned</span>';}
			 ?>
             </div></td>
         </tr>
         <tr><td></td>
            <td><a class="a_button" href="<?php echo $page_parent."?1=1".$q_string; ?>">Close</a></td>
         </tr>     
       </table>
        </form>
      </div>
      <?php include "include/footerlogo.php";  ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
