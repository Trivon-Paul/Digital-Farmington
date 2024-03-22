var geocoder = new google.maps.Geocoder();
var oldLatLng;
var oldAddress;
var readyForSubmit;
var form;
//Specific to update page
window.onload = function(){
    form = document.getElementById("poiForm");
    
    
    readyForSubmit = false;
    //Get old values (before any change)
    oldLatLng = {
        lat: getLat(),
        lng: getLong()
    };
    oldAddress = getAddress();
    
    //Attach validation
    var button = document.getElementById("updateButton");
    if(button){ 
        button.onclick = formCheck; //Update button
        document.getElementById("deleteButton").onclick = onDeleteAttempt; //Update button implies that there is a delete button
    }
    else{ document.getElementById("publishButton").onclick = formCheck;}
};

function getAddress(){ return document.getElementById("addressField").value;}
function getLat(){ return Number(document.getElementById("latField").value);}
function getLong(){ return Number(document.getElementById("longField").value);}

function setAddress(address){document.getElementById("addressField").value = address;}
function setLatLng(lat, lng){
    document.getElementById("latField").value = lat;
    document.getElementById("longField").value = lng;
}

function formCheck(){
    var addressField = getAddress();
    var lat = getLat();
    var long = getLong();
    
    var latUnchanged = (lat===oldLatLng.lat);
    var longUnchanged = (long===oldLatLng.lng);
    var addressUnchanged = (addressField === oldAddress);
    
    /** Empty fields aren't accepted (if one of the two [address or latlong] is empty, that's fine) **/
    //Title
     if(!document.getElementById("title").value){
        alert("Title cannot be empty");
        return;
    }
    
    //Categories (at least one must be selected)
    var noneSelected = true;
    $("#categoryList").children("label").each(function(){
        if(this.childNodes[0].checked){
            noneSelected = false;
            return false; //exit for each loop
        }
    });
    
    if(noneSelected){
        alert("You must select at least one category.");
        return;
    }
    
    //Address && LatLong Blank
    if(!addressField){
        if(!lat || !long){
            alert("Enter correct address or latitude&longitude (Note, only one of these is necessary");
            return;
        }
    }
    
   
    //Fields exist
    
    /** Improper values aren't accepted **/
    
    
    //Fields are correct form.
    
    
    //console.log(addressField + "lat " + lat + " long" + long);
    //To allow either input of address or lat long when updating
    
    
    //Is location completely unchanged and no sections are blank?
    //Blankness is checked so that POIs with only latlng or address
    //are updated and automatically given the missing info
    if(latUnchanged && longUnchanged && addressUnchanged
            && addressField && lat && long){
        //alert("No change to address/lat/lng");
        form.submit();
        return;
    }
    
    //alert("latUnchanged " + latUnchanged +
    //        " lngunchanged " + longUnchanged +
    //        " addressUnchanged " + addressUnchanged);
    
    /** Update the unaltered one. If both altered, update address. **/
    //Since values are not blank and have been changed..
    //If latlong unchanged (--> address changed), and the change to address wasn't making it blank, use address to create accurate latlong
    //Or is latlong changed to empty, use address to get latlong
    //If latlong changed, update address. Otherwise, try to update latlong
    if((latUnchanged && longUnchanged && addressField )|| (!lat || !long)){
        //alert("Lat/Long unchanged --> Address must have changed! --> Update lat long");
        addressToLatLng(addressField, checkFoundLatLng);
    }
    else{
        //alert("Lat/Long changed --> Address may have changed, but lat long have priority! --> Update address");
        latLngToAddress(lat,long, checkFoundAddress);
    }
    
}

//Converts the address to latlng and returns the value for update query
function addressToLatLng(address, callback){
    var latLng;
    geocoder.geocode( {'address': address}, 
        function(results, status){
            if(status === 'OK'){
                if(results[0] && results[0].geometry.location.lat()){
                    latLng = results[0].geometry.location;
                    //alert(latLng);
                    callback(latLng.lat(), latLng.lng());
                    return;
                }   
            }
            else{
                console.log("Geocode failed due to " + status);    
            }
            //End for fail cases
            alert("This address does not work. Please try to fix address."+
                            "If the issue is unknown, request for help.");
            return;
        });
      
}

function latLngToAddress(lat, long, callback){
    var address;
    var latLng = {lat: lat, lng: long};
    geocoder.geocode( {'location': latLng}, 
        function(results, status){
            if(status === 'OK'){
                if(results[0] && results[0].formatted_address){
                    //console.log(results[0]);
                    address = results[0].formatted_address;
                    //alert(address);
                    callback(address);
                    return;
                }
            }
            else{
                 console.log("Geocode failed due to " + status);
            }
            alert("The latitude and/or longitude do not work. Please try to fix coordinates."+
                    "If the issue is unknown, request for help.");
            return;
        });
}

function checkFoundAddress(address){
    setAddress(address);
    form.submit();
}

function checkFoundLatLng(lat, lng){
    setLatLng(lat, lng);
    form.submit();
}

//Delete button fix
function onDeleteAttempt(){
    var confirmation = confirm('Are you sure?\nThis cannot be undone.');
    if(confirmation){ 
        var importantElem = document.getElementById("noname"); //Name & val of this elem vital to deletion
        importantElem.setAttribute("name", "deletePOI");
        importantElem.setAttribute("value","Delete POI");
        form.submit();
    }
}