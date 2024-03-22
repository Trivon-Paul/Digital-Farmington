<?php 
	include('i/functions/poiModuleFunctions.php');
	if(!empty($poi)){
		if($poi != "*")
		// Changed to sqli
			$poiData = mysqli_fetch_array(getPoiID($poi));
		else
		$newPoi = true;
	}
	if(isset($_GET['new'])){
		$newPoi = true;
		$poi = true;
		$poiData['startDate'] = 1900;
		$poiData['endDate'] = 2000;
	}
?>
<div id="moduleContainer">
<div id="moduleNav"><a href="/admin.php?poi&new" class="button bluebutton">New POI</a></div>
  <p class="message"><?php echo $message; ?></p>
  <h2>POI List</h2>
  <?php echo buildPOIList();?> </div>
