<?php require_once('../DB/DBConnect.php'); ?>
<?php
if($_POST['formName'] == "poiForm"){
	//FORM VALIDATION
	global $DBConnect;
	$errors = array();	
	if (empty($errors)) {
		$poiID = 	trim(htmlentities($_POST['poiID']));
		$title = 	trim(htmlentities($_POST['title']));
		$category = 	$_POST['category'];
		$useAddress = 	isset($_POST['useAddress']) ? $_POST['useAddress']: 0;
		$latPos = 	trim(htmlentities($_POST['lat']));
		$longPos = 	trim(htmlentities($_POST['long']));
		$address = 	trim(htmlentities($_POST['address']));
		$startDate = 	trim(htmlentities($_POST['startDate']));
		$endDate = 	trim(htmlentities($_POST['endDate']));
		$content = 	trim($_POST['content']);
               
		$hidden =       isset($_POST['hidden']) ? $_POST['hidden']: 0;		
	
		$query1 = "UPDATE poi SET
			title =           ?,
			content =         ?,
			startDate =       ?,
			endDate =         ?,
			latPos =          ?,
			longPos =         ?,
                        useAddress =      ?,
			address =         ?,
                        hidden =          ?
			WHERE id =        ?";
                       
		$stmt = mysqli_stmt_init($DBConnect);
		if(mysqli_stmt_prepare($stmt, $query1)){
			//  bind parameters to dummy variables
			  mysqli_stmt_bind_param($stmt, 'ssiissisii', $title, $content, $startDate, $endDate, $latPos, $longPos, $useAddress, $address, $hidden, $poiID );
			}
               	$result1 = mysqli_stmt_execute($stmt);
		 mysqli_stmt_close($stmt);
		if($result1 && !empty($_POST['category'])){
	                
			$queryD = "DELETE FROM z_poi_cat WHERE poiID = '{$poiID}' ";
			
			$resultD = mysqli_query($DBConnect, $queryD);
				
				$sql = array(); 
				foreach( $category as $row ) 
					$sql[] = '("'.$poiID.'", '.$row.')';
				$result2 = mysqli_query($DBConnect,'INSERT into z_poi_cat (poiID, category) VALUES '.implode(',', $sql));
				//echo "<script>console.log('SQL: ".$sql." ');</script>";
				
		}


				
		if($result1){
			//SUCCESS
			$message = "Successfully Updated";

		} else {
			//FAILURE
			$message = "Update Failed<br />If the problem persists, contact your server administrator - 21";
			$message .= mysqli_error($DBConnect);

		}
		
	} else {
			$message = "Update Failed - If the problem persists, contact your server administrator - 2 <br />";
			$message .= mysqli_error($DBConnect);
		//Error in Update
	}
	$_SESSION['message'] = $message;
}
?>