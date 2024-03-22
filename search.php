<?php require_once("i/DB/DBConnect.php"); ?>
<?php

global $DBConnect;
$input = isset($_POST['search']) ? $_POST['search'] : ""; //Default input is ''

//Incomplete query
$query = "SELECT title, id "
        . "FROM poi "
        . "WHERE (title LIKE ? OR content LIKE ?) AND poi.hidden = 0";

//init stmt
$stmt = mysqli_stmt_init($DBConnect);

//Make prepared statement. If successful, run query
if (mysqli_stmt_prepare($stmt, $query)) {
    
    //Bind params to statement
    $title = ((strlen($input)>2)? "%". $input."%":"% ". $input."%");
    $content= ((strlen($input)>2)? "% ". $input."%":"% ". $input." %");
    mysqli_stmt_bind_param($stmt, "ss", $title, $content);

    //Execute query
    $result = mysqli_stmt_execute($stmt);

    //Bind variables to result
    mysqli_stmt_bind_result($stmt, $title, $id);

    //Create JSON containing data of all results
    $json = '{"pois": [';
    while (mysqli_stmt_fetch($stmt)) {
        $json.= ' {"poiId": "' . $id . '", '
                . '"title": "' . $title . '"},';
    }
    $json.= '{}]}';

    //Close statement
    mysqli_stmt_close($stmt);

    echo $json; //Return JSON
} else {
    echo "{error: \"could not search\"}"; //mysqli_stmt_error($stmt);
}
?>
