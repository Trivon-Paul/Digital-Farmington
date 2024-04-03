/*******************************************************
* This file has functionality that manipulates POIs.
* We will need to study and modify this code to resolve
* The issue of multiple POIs stacked on top of one another.
* **************************************************** */
window.currentYear = 0;
( function(window, google, list) {
		var Mapster = ( function() {
				function Mapster(element, opts) {
					this.gMap = new google.maps.Map(element, opts);
					var usRoadMapType = new google.maps.StyledMapType([
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#523735"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "administrative",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#c9b2a6"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#dcd2be"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#ae9e90"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#93817c"
      }
    ]
  },
  {
    "featureType": "poi.attraction",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.business",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.medical",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#a5b076"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#447530"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#fdfcf8"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f8c967"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#e9bc62"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e98d58"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#db8555"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#806b63"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8f7d77"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#b9d3c2"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#92998d"
      }
    ]
  }
],
                                                                                              {name: '___ Map of Farmington'});

					this.gMap.mapTypes.set('farmingtonRoadMap', usRoadMapType);
					this.gMap.setMapTypeId('farmingtonRoadMap');
 // LOADING THE TOWN BORDERS 

// Initialize at default slider position, year 1800
this.gMap.data.loadGeoJson(
             'After1785to1806.json' );
     
  window.apiF = function(Year) {
      //console.log(window.currentYear);
      window.currentYear=Year;
      var that = this;
      this.gMap.data.forEach(function(feature){
          that.gMap.data.remove(feature);
      });
      
      if(window.currentYear < 1779) 
        this.gMap.data.loadGeoJson(
         'Before1779Farmington.json');
         else if(window.currentYear >= 1806 && window.currentYear < 1830)
         this.gMap.data.loadGeoJson(
         'After1806to1830.json' );
         else if(window.currentYear >= 1869)
         this.gMap.data.loadGeoJson(
         'After1869toPresent.json' );
        else if(window.currentYear >= 1785 && window.currentYear < 1806)
         this.gMap.data.loadGeoJson(
         'After1785to1806.json' );
         else if(window.currentYear >= 1779 && window.currentYear < 1785)
         this.gMap.data.loadGeoJson(
         'After1779to1785.json' );
        else if(window.currentYear >= 1830 && window.currentYear < 1850)
         this.gMap.data.loadGeoJson(
         ' After1830to1850.json' );
         else if(window.currentYear >= 1850 && window.currentYear < 1869)
         this.gMap.data.loadGeoJson(
         'After1850to1869.json' );
            }.bind(this);   // binds to function so wherever it is called, it refers to the gMap

  //below removes southington from map
        // 'After1779to1785.json',
 
 //below removes southington, berlin, bristol 
        //  'After1785to1806.json',
        
//below removes southington, berlin, bristol, burlington
        //  'After1806to1830.json',
        
//below removes southington, berlin, bristol, burlington, avon
        //  'After1830to1850.json',

//below removes southington, berlin, bristol, burlington, avon, new britain
        //  'After1850to1869.json',

//below removes ALL but Farmington itself
      //   'After1869toPresent.json',
       // );
        
        // This code affects the stroke and polygon fill color of the geoJson. this code
        // can also be edited to affect each polygon individually if we order them by ascii numbers.
        // google's datalayer docs explain this further. Currently I have them as distinct colors
        // so that coding and manipulating them will be much easier atm.  --Chelsea
    this.gMap.data.setStyle(function(feature) {
    var ascii = feature.getProperty('ascii');
    
    // More notes, sorry: It may be posible, instead of loading separate JSON files every time in accordance
    // to the time slider, to be able to set each ASCII representing the town to a boolean visibility. I read in this
    //  doc: https://developers.google.com/maps/documentation/javascript/datalayer that you can utilize 
    //  "visible:true" or 'false'. Something to keep in mind when we are cleaning up the code at the end. --Chelsea
    
    //Default = Farmington (2017)
    var color = "green";
    var stColor = "green";
   //Town of Berlin - NOTE: I had to physically remake this by eye so it is not entirely accurate. I just wanted a placeholder, bc 
   //I cannot currently find any source for Berlin's geoJson from the web. If you can find one, you're awesome. --Chels
    if (ascii == "112") {
    color = "purple";
    stColor="purple";
  }
     //Town of Southington
     if (ascii == "111") {
    color = "red";
    stColor="red";
  }
  //Town of Bristol
      if (ascii == "103") {
    color = "yellow";
    stColor="yellow";
  }
    //Town of Avon
      if (ascii == "108") {
    color = "orange";
    stColor="orange";
  }
      //Town of New Britain
      if (ascii == "101") {
    color = "#547cff";
    stColor="blue";
  }
      //Town of Burlington
      if (ascii == "100") {
    color = "#42f4f1"; //skyblue
    stColor="#42f4f1";
  }
       //Town of Plainville
      if (ascii == "99") {
    color = "#d6136a"; //pink
    stColor="#d6136a";
  }
    return {
      fillColor: color,
      strokeColor: stColor,
      strokeWeight: 1
    };
});
   // end of town border polygon code      
          
          
					this.markers = new List();
					this.infoWindows = new List();
					this.farmingtonBorderLine = new google.maps.Polygon({
						strokeColor : '#FF0000',
						strokeOpacity : 0.6,
						strokeWeight : 2,
						fillColor : '#FF0000',
						fillOpacity : 0.35
					});
					//if(opts.geocoder) {
					//	this.geocoder = new google.maps.Geocoder();
					//}

					if(opts.clusters) {
						this.markerCluster = new MarkerClusterer(this.gMap, [], opts.clusters.options);
					}

				}


				Mapster.prototype = {
					zoom : function(level) {
						if(level) {
							this.gMap.setZoom(level);
						} else {
							return this.gMap.getZoom();
						}
					},
					_on : function(opts) {
						var self = this;
						google.maps.event.addListener(opts.target, opts.event, function(e) {
							opts.callback.call(self, e, opts.target);
						});
					},
					addBoundery : function(borderLinePoints) {
						var borderLine = [];
						$(borderLinePoints).each(function(index, point) {
							borderLine.push(new google.maps.LatLng(point.lat, point.lng));
						});
						this.farmingtonBorderLine.setPath(borderLine);
						this.farmingtonBorderLine.setMap(this.gMap);
					},

					addPano : function(element, opts) {
						$(element).css({
							'background' : '#ccc'
						});
						//var panorama = new   google.maps.StreetViewPanorama(element, opts);
					},
					getFarmingtonBorderLine : function() {
						return this.farmingtonBorderLine;
					},
					deleteFarmingtonBorderLine : function() {
						this.farmingtonBorderLine.setMap(null);
					},
					getCurrentPosition : function(callback) {
						if(navigator.geolocation) {
							navigator.geolocation.getCurrentPosition(function(position) {
								callback.call(this, position);
							});
						}
					},
					addMarker : function(opts) {
                                            
						var marker, self = this;
						if(opts.location ==''){
							delete  opts.location ;
						}
						opts.position = {
							lat : opts.lat,
							lng : opts.lng
						}
						marker = this._createMarker(opts);
                                                //console.log(marker);
						if(opts.events) {
							opts.events.forEach(function(event) {
								self._on({
									target : marker,
									event : event.name,
									callback : event.callback
								});
							})
						}

						if(opts.content) {
							var self = this;
							this._on({
								target : marker,
								event : 'click',
								callback : function() {
									var infoWindow = new google.maps.InfoWindow({
										content : opts.content
									});
									//infoWindow.open(self.gMap, marker);
									self.infoWindows.add(infoWindow);
									this._on({
										target : self.gMap,
										event : 'click',
										callback : function() {
											infoWindow.close();
										}
									});
								}
							});
						}
                                                
                                                //var wrappedMarker = 
                                               //         {marker: marker,
                                                //         id: opts.id};
                                                //console.log(wrappedMarker);
                                                
						this.markers.add(marker);
						//if(this.markerCluster) {
						//	this.markerCluster.addMarker(marker);
						//}
                                                //console.log("a");
                                                //console.log(marker);
						return marker;
					},
                                        gotoMarker: function(marker){
                                            //this.removeMarkers()
                                            
                                            //console.log(marker);
                                            if(!marker.lat || !marker.lng){
                                                console.log("Marker does not have latlng");
                                                console.log(marker);
                                                return;
                                            }else{
                                                this.gMap.panTo(marker.getPosition());
                                                return;
                                            }
                                        },
					findBy : function(callback) {
						return this.markers.find(callback);

					},
                                        getMarker: function(poiId){
                                           var result;
                                                result = this.findBy( 
                                                   function(marker){ 
                                                       console.log(marker);
                                                       console.log(poiId + " " + marker.id);
                                                       return (poiId.toString() === marker.id);
                                                   });
                                                console.log("result: " + result);
                                            
                                            
                                        
                                        //}
                                        },
					//geocode : function(opts) {
						/*this.geocoder.geocode({
							address : opts.address
						}, function(results, status) {
							if(status === google.maps.GeocoderStatus.OK) {
								opts.success.call(this, results, status);
							} else {
								opts.error.call(this, status);
							}
						});*/
					//},
					removeMarkers : function() {
						if(this.markers.items) {
							this.markers.items.forEach(function(item) {
								item.setMap(null);
							});
							this.markers.removeAll();
							if(this.markerCluster){
								this.markerCluster.clearMarkers();
							}
						}

					},
					removeBy : function(callback) {
						self = this;
						this.markers.find(callback, function(markers) {
							markers.forEach(function(marker) {
								marker.setMap(null);
								self.markers.remove(marker);
							});
						});

					},
					_createMarker : function(opts) {
						opts.map = this.gMap;
						if(opts.lat != '' && opts.lng !=''){
							opts.location  = new google.maps.LatLng(opts.lat, opts.lng);
                                                        //opts.animation = google.maps.Animation.DROP;
                                                        //opts.label = "1";
						}
						return new google.maps.Marker(opts);
					}
				}

				return Mapster;
			}())
		Mapster.create = function(element, opts) {
			return new Mapster(element, opts);
		}
		window.Mapster = Mapster;
	}(window, google, window.List))

