<?php require_once($_SERVER['DOCUMENT_ROOT'].'/i/DB/DBConnect.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/data/poiFunctions.php');?>
<?php
//error_reporting(0);

global $DBConnect;
$poiId = isset($_POST['poiId']) ? $_POST['poiId'] : ""; //Default input is ''

//Incomplete query
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
				poi.id = ?";

//init stmt
$stmt = mysqli_stmt_init($DBConnect);

//Make prepared statement. If successful, run query
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $poiId);
    
    //Execute query
    $result = mysqli_stmt_execute($stmt);
    
    if($result){
        
        //Get result
        $resultSet = mysqli_stmt_get_result($stmt); 
        $poiData = mysqli_fetch_array($resultSet, MYSQLI_ASSOC);
        
        //Close statement
        mysqli_stmt_close($stmt);
        
        //Use results
        if($poiData){     
            //Create JSON containing data of all results
             $json = '{"pois": [' . getPOIJSON($poiData).']}';
             echo $json; //Return JSON
        }
        else{
            //Couldn't get POI data
            echo '{"error": "failed to get point"}';
        }
    }
    else{
        //Query failed
        echo '{"error": "query failed"}';
    }
    
} else {
    echo '{"error": "could not search"}'; //mysqli_stmt_error($stmt);
}
//echo "hi";
error_reporting(E_ALL);
?>
