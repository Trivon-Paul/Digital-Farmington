<?php

define("DB_SERVER", "localhost");
define("DB_NAME", "digitalf_dfarming_mapper");
define("DB_USER", "digitalf_dfarm");
define("DB_PASS", "p,bx2,%kzB8^");
$DBConnect = mysqli_connect(DB_SERVER,DB_USER,DB_PASS, DB_NAME); //Connect to db server using constants

	
	$cat_query = "SELECT id, name FROM category"; 
	//$result = mysql_query($query, $DBConnect);
	$cat_result = mysqli_query($DBConnect, $cat_query);
	
	$category = array();
	//Changed to sqli 
	while($cat = mysqli_fetch_assoc($cat_result)){
		$category[] = $cat;
	}
	$cat=array();
	foreach($category as $key => $data){
		$cat[$data['id']] = $data;
	}


	//global $DBConnect;

	$query = "
			SELECT 
				poi.id, 
				poi.title, 
				poi.startDate, poi.endDate, 
				poi.hidden, 
				
				GROUP_CONCAT(b.category ORDER BY b.category ASC SEPARATOR ',') AS category

			FROM 
				`poi` `poi`
				LEFT JOIN `z_poi_cat` `b` ON b.poiID = poi.id
			GROUP BY poi.id

			ORDER BY 
				poi.startDate ASC, 
				poi.title ";
	// $result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
	
	//return $result;
    // Create array from result
    $data = array();

        // Fetch rows from the result set and store them in the array
        //while ($row = $result->fetch_assoc()) {
        //    $data[] = $row;
        //}

		// Fetch rows from the result set and store them in the array
		while ($row = $result->fetch_assoc()) {
			$cat_str = "";
			$cat_ints = explode(',', $row['category']);
			foreach($cat_ints as $cList) {
				$cat_str .= $cat[$cList]['name'];
				if (next($cat_ints)) {
					$cat_str .= ", ";
				}
			}
			$row['category'] = $cat_str;
			$data[] = $row;
		}

        // Return data as JSON
        echo json_encode(array("data" => $data));