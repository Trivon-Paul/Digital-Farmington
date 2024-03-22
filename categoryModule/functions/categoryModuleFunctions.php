<?php

function buildCategories(){
	global $DBConnect;
	$query = "
		SELECT *
		FROM 
			category 
		ORDER BY 
			name ASC";
	// $result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);

	$catList = "";
	    // Updated to sqli
		while($cat = mysqli_fetch_array($result)){
			$catList .= "
			<li class='category ".$cat['id']."'>
				<div class='dotColor'>
					<input type='hidden' id='dot".$cat['id']."' name='dot[".$cat['id']."]' value='".$cat['dot']."' />
					<div onclick=\"toggle('groupSelector".$cat['id']."')\">
						<img src='/img/poiIcon".$cat['dot'].".png' class='poiDot' />
						<ul id='groupSelector".$cat['id']."' class='groupSelector".$cat['id']." groupSelector hidden' style='position:absolute;'>";
							for($i = 0; $i < 12; $i++){
								$currentDot = ($cat['dot'] == $i) ? "selected" : "";
								$catList .= "
									<li data-id='".$i."' data-name='".$cat['id']."' class='".$currentDot."'>
										<img src='/img/poiIcon".$i.".png' class='poiDot' />
									</li>";
							}
			$catList .= "
						</ul>
					</div>
				</div>";
			$catList .= "
				<span class='categoryName'>".$cat['name'].":</span>
				<input class='changeTo' type='text' name='category[".$cat['id']."]' value='".$cat['name']."' />
				<a onclick='deleteCategory(".$cat['id'].")' class='clickable' style='color:#c44; font-size:12px;'>Delete Category</a>
			</li>";
	}
	
	return $catList;
}

?>

