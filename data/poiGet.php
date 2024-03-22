<?php require_once($_SERVER['DOCUMENT_ROOT'].'/i/DB/DBConnect.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/data/poiFunctions.php');?>
<?php
error_reporting(0);

//https://www.youtube.com/watch?v=Qq8ZTMfs18k

$timePeriod = $_GET['year'];
$category = $_GET['category'];
/*************************************************
 * NOTE: Be sure to check that names of tables in 
 * this query match names of table on server after
 * we migrate this to Reclaim!
 * *********************************************** */
$cats = explode(',',$_GET['category']);
$cats= implode("','",$cats);
$query = "
			SELECT 
				poi.id, 
				poi.title, poi.content, 
				poi.startDate, poi.endDate, 
				poi.address, poi.latPos, poi.longPos,
				
				b.category,
				
				c.name, c.dot

			FROM 
				`poi` `poi`
				LEFT JOIN `z_poi_cat` `b` ON b.poiID = poi.id
				LEFT JOIN `category` `c` ON b.category = c.id
	
			WHERE 
				poi.id = b.poiID 
				AND b.category IN ('{$cats}')
				AND '{$timePeriod}' BETWEEN startDate AND endDate
				AND hidden = '0'
			ORDER BY 
				poi.startDate ASC, 
				poi.title ASC";
//  $result = mysql_query($query, $DBConnect);
$result = mysqli_query($DBConnect, $query);

$data = '{"pois":[ {"location":"25 rocky ledge Dr Clinton CT 06413","icon":"img/null.gif"} ';
// $poiData = mysql_fetch_assoc($result)
while($poiData = mysqli_fetch_assoc($result)){
//	if($data['useAddress'])
	$images = str_replace("|","",explode("|,|",$poiData['gallery']));
	
	$data .= ','.getPOIJSON($poiData);
        /*
	$data .= ',{"location":"'.$poiData["address"].'",
		"title":"'.$poiData["title"].'",
		"id":"'.$poiData["id"].'","content":
		"'.$poiData["content"].'",
		"icon":"img/poiIcon'.$poiData['dot'].'.png",
		"lat":"'.$poiData['latPos'].'",
		"lng":"'.$poiData['longPos'].'",
		"images":[';
			for($i = 0; $i < count($image); $i++){
				$data .= '{"medium":"9036958611_fa1bb7f827_m.jpg","big":"9036958611_fa1bb7f827_b.jpg"}';
				if($i != count($image)-1)
					$data .= ", ";
			}
		
		$data .= ']}';
         *
         */
	/*
	else
	$data .= ',{"location":"@'.$poiData["latPos"].'","title":"'.$poiData["title"].'","content":"'.$poiData["content"].'","icon":"img/poiIcon.png","images":[{"medium":"9036958611_fa1bb7f827_m.jpg","big":"9036958611_fa1bb7f827_b.jpg"}]}';
	*/
}

$data .= "]}";
header('Content-Type: application/json');
echo $data;
?>