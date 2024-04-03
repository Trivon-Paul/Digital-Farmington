( function(window, google, mapster) {
		var roadAtlasStyles = [{
			featureType : 'road.highway',
			elementType : 'geometry',
			stylers : [{
				hue : '#000000'
			}, {
				saturation : 20
			}, {
				visibility : 'simplified'
			}, {
				lightness : 80
			}, {
				weight : 1
			}]
		}, {
			featureType : 'road.arterial',
			elementType : 'all',
			stylers : [{
				hue : '#220055'
			}, {
				lightness : -30
			}, {
				visibility : 'simplified'
			}, {
				saturation : 30
			}, {
				gamma : 1
			}, {
				weight : 1
			}]
		}, {
			featureType : 'road.local',
			elementType : 'all',
			stylers : [{
				hue : '#333'
			}, {
				lightness : 0
			}, {
				saturation : 10
			}, {
				gamma : 0.4
			}, {
				visibility : 'on'
			}]
		}, {
			featureType : 'water',
			elementType : 'geometry',
			stylers : [{
				saturation : 40
			}, {
				lightness : 40
			}]
		}, {
			featureType : 'road.highway',
			elementType : 'labels',
			stylers : [{
				hue : '#666'
			},{
				visibility : 'simplified'
			}, {
				saturation : 98
			}]
		}, {
			featureType : 'administrative.locality',
			elementType : 'labels',
			stylers : [{
				hue : '#0022ff'
			}, {
				saturation : 50
			}, {
				lightness : -10
			}, {
				gamma : 0.90
			}]
		}, {
			featureType : 'transit.line',
			elementType : 'geometry',
			stylers : [{
				hue : '#ff0000'
			}, {
				visibility : 'on'
			}, {
				lightness : -70
			}]
		}];

		var styles = [{
			featureType : 'all',

			stylers : []
		}, {
			featureType : 'water',
			featureElement : 'geometry',
			stylers : [{
				color : '#564444'
			}]
		}];
		mapster.MAP_OPTIONS = {
			center : {
				lat : 41.7280028,
				lng : -72.8286914
			},
			disableDefaultUI : false,
			scrollwheel : true,
			draggable : true,
			mapTypeId : google.maps.MapTypeId.HYBRID,
			zoom : 12,
			minZoom:10,
			maxZoom : 20,
                        gestureHandling: 'greedy',
			//draggable:false,
			zoomControlOptions : {
				position : google.maps.ControlPosition.RIGHT_BOTTOM,
				style : google.maps.ZoomControlStyle.LARGE
			},
			panControlOptions : {
				position : google.maps.ControlPosition.LEFT_BOTTOM
			},
			clusters : {
				options : {}
			},
			panControl : true,
			streetViewControl : true,
                        fullscreenControl: false,
			zoomControl: true,
			geocoder : true,
			styles : styles,
			borderOptions : {
				strokeColor : '#FF0000',
				strokeOpacity : 0.6,
				strokeWeight : 2,
				fillColor : '#FF0000',
				fillOpacity : 0.35
			},
			mapTypeControlOptions : {
				mapTypeIds : [google.maps.MapTypeId.ROADMAP, 'farmingtonRoadMap']
			},
			roadAtlasStyles:roadAtlasStyles
			
		}

	}(window, google, window.Mapster || (window.Mapster = {})))
