<?php



include "include/config_db.php";// database connection details stored here



include "include/protecteed.php";// page protect function here



$tabl = 'content';



if($_POST['submitbut'] == 'Submit'){



	$name = $_POST['name'];



	$content = stripslashes($_POST['page']);



	$publish = $_POST['publish'];



	$referer = $_POST['referer'];



	if($name == ''){$flag[0] = 'r';}



	else if($content == ''){$flag[1] = 'r';}



	if(in_array('r', $flag)){



		$flagz = 'r';



	}



	else{



		if($_GET['do'] == 'edit'){



			$id = mysql_real_escape_string($_GET['id']);



			$sql = "UPDATE $tabl SET name='$name', content='$content', publish='$publish', time=NOW() where id = '$id'";



		}



		else{



			$sql = "INSERT into $tabl(content_h, description, publish, time) values('$name', '$content', '$publish', NOW())";



		}



		if(mysql_query($sql) or die(mysql_error())){



			header("Location: $referer");



		}



	}



}



else if($_GET['do'] == 'edit'){



	$id = mysql_real_escape_string($_GET['id']);



	$sql = "SELECT * from $tabl where id='$id'";



	$exec = mysql_query($sql) or die(mysql_error());



	$fetch = mysql_fetch_assoc($exec);



	$name = $fetch[content_h];



	$content = $fetch[description];



	$publish = $fetch[publish];



	$referer = $_SERVER['HTTP_REFERER'];



}



else{



	$publish = 'checked="checked"';



	$referer = $_SERVER['HTTP_REFERER'];



}



if($publish == '1'){$publish_s  = 'checked="checked"';}



// Fetch content to show in ckeditor



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Edit Page</title>



    <link type="text/css" href="css/style1.css" rel="stylesheet" />



    <link type="text/css" href="css/style.css" rel="stylesheet" />



	<script type="text/javascript" src="scripts/jquery-latest.pack.js"></script>



    <script type="text/javascript" src="thickbox/thickbox-compressed.js"></script>



	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>



    <link rel="stylesheet" href="thickbox/thickbox.css" type="text/css" media="screen" />



</head>







<body>



<div class="container">



<?php



	$con = 'class="current"';



	require_once('include/header.php'); 



	require_once('include/top_menu.php');



	



	if($flag == 'g'){



		echo '<div class="success">Success:  Page Added Successfully.</div>'; 



	}



	if($flagz == 'r'){



		if($flag[0] == 'r'){



			echo '<div class="error">Error:  Please enter Name of the Page.</div>'; 



		}



		else if($flag[1] == 'r'){



			echo '<div class="error">Error:  Please enter Content of the Page.</div>'; 



		}



	}



?>



<br />



<br />







Here you can add content to your page. This content can be literally anything: Text, Images, Videos, Flash, Music etc<br /><br />







	<form action="add_page.php?do=<?php echo $_GET['do'].'&subsite='.$_GET['subsite'].'&id='.$_GET['id']; ?>" method="post">



        <input name="referer" value="<?php echo $referer; ?>" type="hidden" />



		<p>



			<label>Name:</label>



            <input name="name" value="<?php echo $name; ?>" type="text" />



		</p>



        <br />



		<p>



        	<input name="publish" <?php echo $publish_s; ?> value="1" type="checkbox" /> Publish this page



		</p>



        <br />



		<p>



			<label>Content:</label>



			<textarea class="ckeditor" cols="80" id="editor1" name="page" rows="10"><?php echo $content; ?></textarea>



		</p>



        <br />



			<input type="submit" name="submitbut" value="Submit" />



	</form>





</div>

</body>



</html>