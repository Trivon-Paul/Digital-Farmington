<?php
error_reporting(0); 
require('constants.php');

  //Create a Database Connection

  // Sets up connection to DB
  $DBConnect = mysqli_connect(DB_SERVER,DB_USER,DB_PASS, DB_NAME); //Connect to db server using constants
  if(mysqli_connect_errno()) {
	  die("Database connection failed: " . mysqli_connect_error());
  }
 
  
  //Select a Database to use
  mysqli_select_db($DBConnect,DB_NAME); 
  if(mysqli_connect_errno()) {
	  die("Database selection failed: " . mysqli_connect_error());
  }
?>