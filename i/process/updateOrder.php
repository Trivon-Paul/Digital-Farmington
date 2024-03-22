<?php
//CHECK THIS FILE ONCE EVERYTHING ELSE HAS BEEN UPDATED
//This file deals with query to add photo to gallery for a POI
if(isset($_POST['sortOrder'])){
	global $DBConnect;
	//FORM VALIDATION
	   /*
		$id = 			mysqlPrep($_POST['poiID']);
		$image = 		mysqlPrep($_POST['image']);
		$sizeRatio = 	mysqlPrep($_POST['sizeRatio']);
		$caption = 		mysqlPrep($_POST['caption']);
		*/

		$id = 			$_POST['poiID'];
		$image = 		$_POST['image'];
		$sizeRatio = 	$_POST['sizeRatio'];
		$caption = 		$_POST['caption'];

		$query = "UPDATE poi SET
					gallery =  ?,
					sizeRatio = ?,
					caption = ?
					WHERE id = ? ";		
	    echo "<script>console.log('HELLO?');</script>";
		$stmt = mysqli_stmt_init($DBConnect);
		//Create Prepared Statement
		if(mysqli_stmt_prepare($stmt, $query)){
           //bind parameters to dummy variables
		   mysqli_stmt_bind_param($stmt, 'sssi', $image, $sizeRatio, $caption, $id);
		   //Perform Query
		  
		   echo "<script>console.log('HELLO?');</script>";
		}
		// $result = mysql_query($query, $DBConnect);
		
		// Changed from if($result) 
		if( mysqli_stmt_execute($stmt)){
			//SUCCESS
			echo "<script>console.log('success!!');</script>";
			$_SESSION['message'] =  "Gallery Successfully Updated";

		} else {
			//FAILURE
			echo "<script>console.log('failure!!');</script>";
			$_SESSION['message'] =  "Update Failed<br />If the problem persists, contact your server administrator - 1";
			$_SESSION['message'] =  mysqli_error($DBConnect);

		}
}

?>
