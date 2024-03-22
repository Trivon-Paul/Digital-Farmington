<?php
if($_POST['formName'] == "poiForm"){
    global $DBConnect;
	//FORM VALIDATION
	$errors = array();	
	
	$maxFieldLength = array("title" => 200);
	$requiredFields = array("title");
	$errors = array_merge($errors, checkRequiredFields($requiredFields));
	$errors = array_merge($errors, checkMaxFieldLength($maxFieldLength));
			
	if (empty($errors)) {
		
                
		$title = 		trim(htmlentities($_POST['title']));
		$category = 	$_POST['category'];
		$useAddress = 	isset($_POST['useAddress']) ? $_POST['useAddress']: 0;
		$latPos = 			trim(htmlentities($_POST['lat']));
		$longPos = 		trim(htmlentities($_POST['long']));
		$address = 		trim(htmlentities($_POST['address']));
		$startDate = 	trim(htmlentities($_POST['startDate']));
		$endDate = 		trim(htmlentities($_POST['endDate']));
		$content = 		trim($_POST['content']);
                //$content = 		trim(htmlentities($_POST['content']));
		$hidden =       isset($_POST['hidden']) ? $_POST['hidden']: 0;		
        
	 
		$query1 = "INSERT INTO poi
						(title, content, startDate, endDate, latPos, longPos, useAddress, address, hidden)
				VALUES 	(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_stmt_init($DBConnect);
		//Create Prepared Statement
        if(mysqli_stmt_prepare($stmt, $query1)){
		//  bind parameters to dummy variables
		  mysqli_stmt_bind_param($stmt, 'ssiissisi', $title, $content, $startDate, $endDate, $latPos, $longPos, $useAddress, $address, $hidden );
		}
		$result1 = mysqli_stmt_execute($stmt);
		
		$result2;
		$poiID = mysqli_insert_id($DBConnect);
		
		if($result1){
			$sql = array(); 
			foreach( $category as $row ) 
				$sql[] = '("'.$poiID.'", '.$row.')';
			$result2 = mysqli_query($DBConnect,'INSERT INTO z_poi_cat (poiID, category) VALUES '.implode(',', $sql));
			
		}

        mysqli_stmt_close($stmt);
		if($result1 && $result2){
			//Works
			 $_SESSION['message'] = "POI Created Successfully";
			$redirectPath = "/admin.php?poi=".$poiID;
			 redirect($redirectPath);
		} else {
			$_SESSION['message'] = "POI Creation Failed<br />If the problem persists, contact your server administrator<br />". mysqli_error($DBConnect);
			$redirectPath = "/admin.php?poi";
			redirect($redirectPath);
			
		}
	}
}
?>