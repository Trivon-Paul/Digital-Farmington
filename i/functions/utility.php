<?php
/*
 * Ultility.php contains several miscellaneous functions that are used 
 * throughout the application
 */

//Redirect to a different Page	
function redirect($location){
	if ($location != NULL){
	    //echo "location: ".$location;
		header("Location: ".$location);
		exit();
	}
}

//Remove Special Characters
function escapeSpecials($string){
	$string = str_replace(":","",$string);
	$string = str_replace("\\","",$string);
	$string = str_replace("&","",$string);
	$string = str_replace("<","",$string);
	$string = str_replace(">","",$string);
	$string = str_replace(";","",$string);
	$string = str_replace("'","",$string);
	$string = str_replace(" ","",$string);
	
	return $string;
}

//Fix Title Case
function fixTitleCase($string){
	$string = str_replace("/", "/ ",$string);
	$string = str_replace("-", "- ",$string);
	$string = str_replace("–", "– ",$string);
	$string = ucwords(strtolower($string));
	$string = str_replace("/ ", "/",$string);
	$string = str_replace("- ", "-",$string);
	$string = str_replace("– ", "-",$string);
	return $string;
}

//Format date as mm/dd/yyyy
function formatDate($date){
	return date("m/d/y",strtotime($date));
}

//Convert int to binary
function to_binary($int){
	$int = decbin($int);	
	return substr("00000",0,5 - strlen($int)) . $int;
}

//Hash password
function encryptPassword($password){
    return password_hash($password, PASSWORD_BCRYPT);
}

//Get salt from password hash
function comparePassword($password, $hashedPassword){
    return password_verify($password, $hashedPassword);
    //return sha1($password) == $hashedPassword;
}



?>