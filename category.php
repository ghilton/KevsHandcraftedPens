<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	$id = mysql_real_escape_string($_GET['cat']);
	
		//for page content
	$sql_cat = select_query('categories', '', '', "id='".$id."'");
	$fetch_cat = mysql_fetch_assoc($sql_cat);

	
	//for page content
	$sql_pdt = select_query('products', '', '', "category='".$id."'");
	$num = mysql_num_rows($sql_pdt);
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo ucwords($fetch_cat['name']); ?> | Kev's Handcrafted Pens</title>
<?php include "include/head.php"; ?>
 </head>
<body>
	<!--header start-->
	<?php $arr['cat'] = 'class="active"'; include "include/header.php"; ?>
    <!--header end-->
    <!--category section start-->
    <section class="category_row" <?php if($num <> '0'){ ?>style="min-height:300px"<?php } ?>>
    	<div class="wrapper">
          <h1 class="area"><?php echo ucwords($fetch_cat['name']); ?></h1>
          <?php if($num <> '0'){ ?>
    		<div class="mai_cate_row">
            	<div class="row_box_1">
            <?php $i=1; while($fetch_pdt = mysql_fetch_assoc($sql_pdt)){ ?>
                <div class="first<?php if($i%3==0){echo ' three'; } ?>">
                	<div class="img_category"><a href="product.php?id=<?php echo $fetch_pdt['id']; ?>"><img src="pics/<?php echo $fetch_pdt['image']; ?>" alt="<?php echo ucwords($fetch_cat['name']); ?>" title="" /></a></div>
                    <h2><a href="product.php?id=<?php echo $fetch_pdt['id']; ?>"><?php echo ucwords($fetch_pdt['name']); ?></a></h2>
                    <!--<p class="cate_dis"><?php echo strlen($fetch_pdt['description']) > 150 ? substr($fetch_pdt['description'], 0,150)."..." : $fetch_pdt['description']; ?> </p>-->
                    <p class="cate_dis">$<?php echo $fetch_pdt['price']; ?></p>
                </div>
                <?php $i++; } ?>
                <div class="clear"></div>
            </div>
  		    </div>
            <?php } ?>
      	</div>
<section class="about"  <?php if($num == '0'){ ?>style="min-height:343px"<?php } ?>>
  <div class="wrapper">
    <p class="description"> <?php echo nl2br($fetch_cat['description']); ?> </p>
</section>
      </section>
     <!--category section end-->
    <!--footer start-->
    	<?php include "include/footer.php"; ?> 

    <!--footer end-->
</body>
</html>