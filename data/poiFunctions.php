<?php

function getPOIJSON($poiData) {
    $images = str_replace("|","",explode("|,|",$poiData['gallery']));
    $preparedContent = preg_replace('/"/','\"',$poiData['content']);
    
    $json = '{"location":"' . $poiData["address"] . '",
		"title":"' . $poiData["title"] . '",
		"id":"' . $poiData["id"] . '","content":
		"' . $preparedContent . '",
		"icon":"img/poiIcon' . $poiData['dot'] . '.png",
		"lat":"' . $poiData['latPos'] . '",
		"lng":"' . $poiData['longPos'] . '",
		"images":[';
                        for ($i = 0; $i < count($image); $i++) {
                            $data .= '{"medium":"9036958611_fa1bb7f827_m.jpg","big":"9036958611_fa1bb7f827_b.jpg"}';
                            if ($i != count($image) - 1)
                                $data .= ", ";
                        }

    $json .= ']}';
    
    $json = preg_replace("/\n|\r/","",$json);
    
    
    return $json;
}
?>

