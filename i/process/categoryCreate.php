<?php
if(isset($_POST['newCategory'])){
	
	$addDot = 	$_POST['addDot'];	
	$addCategory = 	$_POST['addCategory'];	
	
	$query = "INSERT INTO category
				(name, dot)
		VALUES 	('{$addCategory}','{$addDot}')";
	$result = mysqli_query($DBConnect, $query);
	
			
	if($result){
		//SUCCESS
		$message = "Category Successfully Added";

	} else {
		//FAILURE
		$message = "Update Failed<br />If the problem persists, contact your server administrator - 1";
		$message .= mysqli_error($DBConnect);

	}
		
	
	$_SESSION['message'] = $message;
}
?>
