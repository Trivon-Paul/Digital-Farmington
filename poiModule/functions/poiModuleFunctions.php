<?php
//UNCOMMENT confirmQuery() once it has been updated 
function getCategoryArray(){
	global $DBConnect;
	
	$query = "SELECT * FROM category"; 
	//$result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
	confirmQuery($result);
	
	$category = array();
	//Changed to sqli 
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
				$catList .= "<button class='historical-category' name='category' value='".$cat['id']."'><span class='inner-category'><img src='/img/poiIcon".$cat['dot'].".png' class='poiBtnDot' />".$cat['name']."</span></button>";
			else
				$catList .= "<li class='clickable ".$cat['name']. ($active ? " active" : "") ."'>".$cat['name']."</li>";
		}
	
	return $catList;
}

function buildCategoryListAdmin($poiCat = array()){

	$category = getCategoryArray();
	$catList = "";
		foreach($category as $cat){
			if(is_array($poiCat)) $active = in_array($cat['id'], $poiCat);
			else  $active = $cat['id'] == $poiCat;
			
				$catList .= "<label class='clickable'><input type='checkbox' name='category[]' value='".$cat['id']."' ".($active ? " checked='checked'" : "") ." />".$cat['name']."</label>";
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
				poi.latPos, poi.longPos,
				poi.hidden, poi.address,
				
				GROUP_CONCAT(b.category ORDER BY b.category ASC SEPARATOR '|},{|') AS category

			FROM 
				`poi` `poi`
				LEFT JOIN `z_poi_cat` `b` ON b.poiID = poi.id";
	if(isset($poiID)){
		$query .= " WHERE poi.id = ".$poiID." ";
	}
	$query .="
			GROUP BY poi.id
			ORDER BY 
				poi.startDate ASC, 
				poi.title ASC";

	//$result = mysql_query($query, $DBConnect);
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
				LEFT JOIN `z_poi_cat` `b` ON b.poiID = poi.id
			GROUP BY poi.id

			ORDER BY 
				poi.startDate ASC, 
				poi.title ";
	// $result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
    confirmQuery($result);
	
	return $result;
}

function buildPOIList(){
	
	$output = "";
	
	
	if($result = getPOIList()){
		$cat = getCategoryArray();
		$currentTime=0;
		$times = array(1610,1640,1680,1720,1760,1800,1840,1880,1920,1960,2000,2010,2020,2030,2050,2060,2070);
		
		$o .= 	"<h3 onclick=\"toggle('".$times[$currentTime]."')\" class='clickable eraHeader'>
							<span class='".$times[$currentTime]." hidden'>&rtrif; </span><span class='".$times[$currentTime]."'>&dtrif; </span>".
							$times[$currentTime]."</h3>
							<div class='timePeriod table ".$times[$currentTime]."'>";
        //$o .= "";
		//Changed to sqli
		while($poi = mysqli_fetch_assoc($result)){
			if($poi['startDate'] > $times[$currentTime + 1]){
			while($poi['startDate'] > $times[$currentTime + 1]){ $currentTime = $currentTime + 1; if($times[$currentTime]=="2060") break; }

					$o .= 	"</div><h3 onclick=\"toggle('".$times[$currentTime]."')\" class='clickable eraHeader'>
							<span class='".$times[$currentTime]."'>&rtrif; </span><span class='".$times[$currentTime]." hidden'>&dtrif; </span>".
							$times[$currentTime]."</h3>
							<div class='table timePeriod hidden ".$times[$currentTime]."'>";
			}

			$o .= "
				<div class='poi tr'>
					<div class='td' style='width:60%;'><a href='/admin.php?poi=".$poi['id']."'>".$poi['title'] . "</a></div>
					<div class='dateRange td' style='width:10%;'>".$poi['startDate']." &mdash; " .$poi['endDate']."</div>
					<div class='catList td' style='width:30%;'>
						<span class='category'>";
						
						$c = explode('|},{|',$poi['category']);
						foreach($c as $cList){
							$o .= "<span class='col'>".$cat[$cList]['name'].",</span> ";
						}
						
						$o .="</span>
					</div>
				</div>";
				
		}
	}
	
	return $o;

}
