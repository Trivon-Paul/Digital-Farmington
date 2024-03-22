<?php

function mysqlPrep($value) {
	$magicQuotesActive = get_magic_quotes_gpc();
	$phpSupport = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
	if( $phpSupport ) { // PHP v4.3.0 or higher
		// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magicQuotesActive ) { $value = stripslashes( $value ); }
		//Updated to sqli	
		$value = mysqli_real_escape_string( $value );
	} else { // before PHP v4.3.0
		// if magic quotes aren't already on then add slashes manually
		if( !$magic_quotes_active ) { $value = addslashes( $value ); }
		// if magic quotes are active, then the slashes already exist
	}
	return $value;
}

function displayErrors($error_array) {
		echo "<p class='errors'>";
		foreach($error_array as $error) {
			echo " - " . $error . "<br />";
		}
		echo "</p>";
}

//Test a database query
function confirmQuery($result){
	if(!$result){
		//Update to sqli
		global $DBConnect;
		
		die("Database query failed: " . mysqli_error($DBConnect));
	}
}



//FORM VALIDATION
	function checkRequiredFields($requiredFields){
		$errorsDetected = array();
		foreach($requiredFields as $fieldName){
			if(!isset($_POST[$fieldName]) || (empty($_POST[$fieldName]) && !is_numeric($_POST[$fieldName]))){
				$errorsDetected[] = $fieldName;
			}
		}
		return $errorsDetected;
	}

	
	function checkMaxFieldLength($maxFieldLength){
		// ADDED this variable
		global $DBConnect;
		$errorsDetected = array();
		foreach($maxFieldLength as $fieldName => $maxLength){
			//CHANGE from mysqlPrep($_POST[$fieldName])
			if(strlen(trim(mysqli_prepare($DBConnect,$_POST[$fieldName]))) > $maxLength){
				$errorsDetected[] = $fieldName . "too long.";
			}
		}
		return $errorsDetected;
	}
	
?>