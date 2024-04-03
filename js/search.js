$(document).ready(function () {

    //Prevent page from reloading on hitting enter
    $("#searchInput").keypress(function (event) {
        if (event.keyCode == 13 || event.which == 13) {
            event.preventDefault();
        }
    });

    //When any key is pressed, return result of query using input
    $("#searchInput").keyup(function () {
        
        //No empty inputs
        var input = $("#searchInput").val();
        if(!input || !input.trim()){return;}
        
        $.ajax({
            type: "POST",
            url: "search.php",
            data: {search: input}, //Send user input
            success: function (result) { //If successful POST, create results list
                //Get array of POI objects
                var pois = JSON.parse(result).pois;

                //Get HTML list for results
                var list = document.getElementById("resultList");

                //Clear list of previous results
                while (list.firstChild) {
                    list.removeChild(list.firstChild);
                }

                //Create list of new results
                var item, title, span;
                $.each(pois, function (index, val) {
                    title = val.title;
                    if (title) {
                        //list item
                        item = document.createElement("li");
                        //item.className = "searchResult";
                        //TODO: If result background color depends on result, (categories)
                        //either add code or class that controls
                        //bgcolor here

                        //inner anchor
                        span = document.createElement("span");
                        //anchor.setAttribute("href", "#");
                        span.innerHTML = title;

                        span.setAttribute("onclick", "locatePOI(" + val.poiId + ")");

                        item.appendChild(span);
                        list.appendChild(item);
                    }
                });

            },
            fail: function () {
                alert("could not load pois");
            }
        });
    });
});


//Select a POI via search results
//--> Load POI data (query using poi id)
//--> Create marker on map
//-->Move to and load POI info
function locatePOI(id) {
    //console.log("Get POI " + id + "...");
    $.ajax({
        type: "post",
        url: "/data/poiSearch.php",
        data: {poiId: id},
        success: function(result){
            //JSON
            //result = fixJSON(result);
            var poi = JSON.parse(result).pois[0]; //POI json
            //console.log("POI:");
            //console.log(poi);
            
            //Send it to mapster to create marker
           // console.clear(); 
            var map = $('#map-canvas').mapster(Mapster.MAP_OPTIONS); //Get map 
            map.mapster("removeMapMarkers"); //Clear screen from POIs
            var marker = map.mapster("createMarker",poi);   //Get normal marker
            var gMarker = map.mapster("addMarker", marker); //Add marker to actual map, get gMarker
            
            //Load selected POI
            //console.log(gMarker);
            map.mapster("gotoMarker", gMarker); //Change map pos
            marker.events[0].callback(); //Create window
            
            //map.mapster("getMarker",id);
            //console.log("hello");
             //result.replace("\r","a");
            //result.replace("\n","a");
            //var charAscii = [];
            //for(var a =0; a < result.length; a++){
            //    charAscii.push(result.charCodeAt(a));
            //}
            //console.log(charAscii);
            //console.log(result);
            //console.log("get marker opts");
            //console.log(marker);
        },
        fail: function(){
            alert("could not find poi with ID" + id);
        }
    });
}