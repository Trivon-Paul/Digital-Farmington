<?php

function getCategoryArray(){
	global $DBConnect;
	//Changed cats to category 
	$query = "SELECT * FROM category"; 
	// CHANGED $result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
	confirmQuery($result);
	
	$category = array();
	//CHANGED was originally mysql w/o i
	while($cat = mysqli_fetch_assoc($result)){
		$category[] = $cat;
	}
	$cat=array();
	foreach($category as $key => $data){
		$cat[$data['id']] = $data;
	}
	
	return $cat;
}

function buildCategoryList($poiCat = array(),$frontEnd=false){
   
	$category = getCategoryArray();
	$catList = "";
		foreach($category as $cat){
			if(is_array($poiCat)) $active = in_array($cat['id'], $poiCat);
			else  $active = $cat['id'] == $poiCat;
			
			if($frontEnd)
				$catList .= "<button class='historical-category' name='category' action='/data/poiGet.php' value='".$cat[0]."'><img src='/img/poiIcon".$cat['dot'].".png' class='poiBtnDot' />".$cat['category']."</button>";
			else
				$catList .= "<li class='clickable ".$cat['category']. ($active ? " active" : "") ."'>".$cat['category']."</li>";
		}
	
	return $catList;
}



function getPoiID($poiID = ""){
	global $DBConnect;
	
	if($poiID == "") unset($poiID);
	
	$query = "
			SELECT 
				poi.id, 
				poi.title, poi.content, 
				poi.startDate, poi.endDate, 
				poi.hidden, 
				
				GROUP_CONCAT(b.category ORDER BY b.category ASC SEPARATOR '|},{|') AS category

			FROM 
				`poi` `poi`
				LEFT JOIN `catManager` `b` ON b.poiID = poi.id";
	if(isset($poiID)){
		$query .= " WHERE poi.id = ".$poiID." ";
	}
	$query .="
			GROUP BY poi.id
			ORDER BY 
				poi.startDate ASC, 
				poi.title ASC";

	// CHANGED was $result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
	confirmQuery($result);
	
	return $result;
}

function getPOIList(){
	global $DBConnect;

	$query = "
			SELECT 
				poi.id, 
				poi.title, poi.content, 
				poi.startDate, poi.endDate, 
				poi.hidden, 
				
				GROUP_CONCAT(b.category ORDER BY b.category ASC SEPARATOR '|},{|') AS category

			FROM 
				`poi` `poi`
				LEFT JOIN `catManager` `b` ON b.poiID = poi.id
			GROUP BY poi.id

			ORDER BY 
				poi.startDate ASC, 
				poi.title ASC";
    // CHANGED WAS  	$result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
	confirmQuery($result);
	
	return $result;
}

function buildPOIList(){
	
	$output = "";
	
	print "here";
	if($result = getPOIList()){
		$cat = getCategoryArray();
		$currentTime=0;
		$times = array(1610,1640,1680,1720,1760,1800,1840,1880,1920,1960,2000);
		
		$o .= 	"<h3 onclick=\"toggle('".$times[$currentTime]."')\" class='clickable eraHeader'>
							<span class='".$times[$currentTime]." hidden'>&rtrif; </span><span class='".$times[$currentTime]."'>&dtrif; </span>".
							$times[$currentTime]."</h3>
							<div class='timePeriod ".$times[$currentTime]."'>";
		//CHANGED was mysql w/o i
		while($poi = mysqli_fetch_array($result)){
		
			if($poi['startDate'] >= $times[$currentTime + 1]){
				while($poi['startDate'] >= $times[$currentTime + 1]) $currentTime++;
				
				$o .= 	"</div><h3 onclick=\"toggle('".$times[$currentTime]."')\" class='clickable eraHeader'>
							<span class='".$times[$currentTime]." hidden'>&rtrif; </span><span class='".$times[$currentTime]."'>&dtrif; </span>".
							$times[$currentTime]."</h3>
							<div class='timePeriod ".$times[$currentTime]."'>";
			}

			$o .= "
				<div class='poi'>
					<p><a href='/admin.php?poi=".$poi['id']."'>".$poi['title'] . "</a></p>
					<div class='dateRange'>".$poi['startDate']." &mdash; " .$poi['endDate']."</div>
					<div class='catList'>
						<span class='category'>";
						
						$c = explode('|},{|',$poi['category']);
						foreach($c as $cList){
							$o .= $cat[$cList]['category'].", ";
						}
						
						$o .="</span>
					</div>
				</div>";
				
		}
	}
	
	return $o;

}
