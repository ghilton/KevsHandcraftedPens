<?php
include "../init.php";// database connection details stored here
include "../config_db.php";// database connection details stored here
include "include/protecteed.php";// page protect function here
$id = $_GET['id'];
$tabl = 'categories';
$item = 'Category';
if($_POST['submitbut'] == "Close"){
	header("location: manage_category.php");
}
else{
	  $sql = "SELECT * from $tabl where id='$id'";
	  $exec = mysql_query($sql) or die(mysql_error());
	  $fetch = mysql_fetch_assoc($exec);
	  $dvar['cat_name']=$fetch['name'];
	  $dvar['status']=$fetch['status'];
}

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
	<?php
    $pg_active['cat'] = 'active';
    require_once('include/header.php'); 
    ?>
    <div class="content">
      <div class="viewform" >
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <table width="1150" border="0" cellpadding="5" style=" margin-right:30px;">
         
         
          <tr>
            <td align="right" class="label_form"><div class="view1">Category Name :</div></td>
         	<td><div class="view2" style="width:645px;"><?php echo $dvar['cat_name'] ?></div></td>
         </tr>
         
         
         <tr>
         	<td align="right" class="label_form"><div class="view1">Status :</div></td>
            <td><div class="view2">
			<?php 
				if($dvar['status'] == 1){echo '<span style="color:#009900">Active</span>';} 
				else if($dvar['status'] == 0){ echo '<span style="color:#ff0000">Inactive</span>';} 
				else if($dvar['status'] == 2){ echo '<span style="color:#990000">Banned</span>';}
			 ?>
             </div></td>
         </tr>
         
         
         
       </table>
      <div class="slideshowdelend" style="float:left; margin-left:250px;">
		<input type="submit" name="submitbut" value="Close" class="formbutton" />
      </div>
        </form>
      </div>
      <?php
	  	 include "include/footerlogo.php";
	  ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
