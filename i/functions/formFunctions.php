<?php require_once('../DB/DBConnect.php'); ?>
<?php

	function mysqlPrep($value) {
     	global $DBConnect;
		$magicQuotesActive = get_magic_quotes_gpc();
		$phpSupport = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $phpSupport ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
				if( $magicQuotesActive ) { $value = stripslashes( $value ); }
				// updated of php7
			$value = mysqli_real_escape_string($DBConnect, $value );
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
		$errorsDetected = array();
		foreach($maxFieldLength as $fieldName => $maxLength){
			if(strlen(trim(mysqlPrep($_POST[$fieldName]))) > $maxLength){
				$errorsDetected[] = $fieldName . "too long.";
			}
		}
		return $errorsDetected;
	}
	
?>