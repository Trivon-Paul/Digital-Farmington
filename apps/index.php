<?php
if(isset($_GET['embed'])){
	$embed = true;
}
$head = "<!doctype html>
	<html>
    <head> 
	<meta charset='UTF-8'>
	<base href='http://cim.ctmediasolutions.com'>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
    <script src='http://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>";

//-----------------------------------------------------------------------------------------------------
//-----------------------Gallery Code------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------
	//----------Slideshow Iframe Code--------------
	if(isset($_GET['gallery']) && $_GET['type'] == 0){
		echo $head;
		require_once('gallery/gallery.php');
	}
	//----------Gallery List Insert Code-----------
	if(isset($_GET['gallery']) && $_GET['type'] == 1){
		echo !$embed ? $head : "";
		require_once('gallery/list.php');
	}
	//----------Integrated Slideshow Code----------
	if(isset($_GET['gallery']) &&  $_GET['type'] == 2){
		require_once('gallery/slideshow.php');
	}
?>
<?php 
//-----------------------------------------------------------------------------------------------------
//-----------------------Form Code------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------

	if(isset($_GET['form'])){
		echo $head;
		require_once('form/form.php');
	}
?>
<?php 
//-----------------------------------------------------------------------------------------------------
//-----------------------News Code------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------

	if(isset($_GET['news'])){
		echo !$embed ? $head : "";
		require_once('news/news.php');
	}
?>