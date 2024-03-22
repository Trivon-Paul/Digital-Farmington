<?php
if(isset($_POST['updateCategories'])){
	//Added var here
	global $DBConnect;

	$dotColor = 	$_POST['dot'];	
	$category = 	$_POST['category'];	

	$addDot = 	$_POST['addDot'];	
	$addCategory = 	$_POST['addCategory'];	
	
	if(!empty($addCategory)){
		$sql = array(); 
		foreach( $category as $key => $row ) 
			$sql[] = '("'.$addDot[$key].'", '.$addCategory[$key].')';
  
		$result2 = mysqli_query($DBConnect,'INSERT INTO category (name, dot) VALUES '.implode(',', $sql));
	}
	
	
	//Update existing
	$totalUpdate = count($dotColor);
	$completed = 0;
	foreach($dotColor as $key => $value){
		$query = "UPDATE category SET
				name = '{$category[$key]}',
				dot = {$dotColor[$key]}
				WHERE id = '{$key}'";		
		
		$result = mysqli_query($DBConnect, $query);
		$completed++;
	}

	if($completed == $totalUpdate){
		//SUCCESS
		$message = "Category Successfully Updated";

	} else {
		//FAILURE
		$message = "Update Failed<br />If the problem persists, contact your server administrator - 1";
		// Updated to sqli
		$message .= mysqli_error($DBConnect);

	}
		
	
	$_SESSION['message'] = $message;
}
?>
