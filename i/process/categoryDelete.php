<?php require_once('../DB/DBConnect.php'); ?>
<?php require_once('../functions/functions.php'); ?>
<?php require_once('../functions/queryFunctions.php'); ?>
<?php require_once('../DB/session.php'); ?>
<?php 

$catID = $_GET['catID'];

$query = "SELECT * FROM `z_poi_cat` WHERE `category` = '{$catID}'";
$result = mysqli_query($DBConnect, $query);
$numRows = mysqli_num_rows($result);
if(!$numRows){
	$query2 = "DELETE FROM `category` WHERE `id` = '{$catID}' LIMIT 1";
	$result2 = mysqli_query($DBConnect, $query2);
	if($result2)
		echo "Success";
	else
		echo "Failure - Contact your server administrator";
} else {
	echo "There are POIs in this Category";
}
?>
