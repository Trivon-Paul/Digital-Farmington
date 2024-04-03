/********************************************************
 * This document will controls important features of the 
 * map.  This page will need to be augmented to change
 * the functionality of the time slider and the boundary
 * of the map.
 * ***************************************************** */

$(function () {
    sliderHeaderSet();
});

(function (window, mapster, google) {
    $.widget("historyMap.mapster", {
        criteriaSelection: {
            "year": "",
            "categories": []
        },
        // default options
        options: {
        },
        // the constructor
        _create: function () {
            var element = this.element[0];
            options = this.options;
            if (this.map === undefined) {
                this.map = mapster.create(element, options);
            }

        },
        // called when created, and later when changing options
        _refresh: function () {

        },
        addBoundery: function (borderLinePoints) {
            this.map.addBoundery(borderLinePoints);
        },
        cleanUp: function () {
            this.map.removeMarkers();
            this.map.deleteFarmingtonBorderLine();
        },
        getData: function (url) {
            self = this;
            $.ajax({
                url: url
            }).done(function (jsonData) {
                //console.log(jsonData);
                if(typeof(jsonData)==="string"){   
                    jsonData = JSON.parse(jsonData);
                }
                pois = jsonData.pois;
                
                var borderLinePoints = jsonData.borderLinePoints;
                var borderLine = [];

                self.addBoundery(borderLinePoints);

                pois.forEach(function (poi) {

                    var item = self.addMarker(self.createMarker(poi));

                });
            }).fail(function(response){
                console.log("A significant error has occurred");
            });

        },
        addCategories: function (element, opts) {

            //				opts.categories.forEach(function(item, index) {
            //					$(element).append("<button class='historical-category' name='category'" + index + " value='" + item.value + "'  type='button'> " + item.name + "</button>");
            //				});
            self = this;
            $('[name^="category"]').click(function () {
                self.cleanUp();
                $(this).toggleClass('category_selected');
                if ($(this).hasClass('category_selected')) {
                    self.criteriaSelection.categories.push(this.value);
                } else {
                    var indexOf = self.criteriaSelection.categories.indexOf(this.value);
                    if (indexOf !== -1) {
                        self.criteriaSelection.categories.splice(indexOf, 1);
                    }
                }
                self.getData(self.prepareUrlRequest('data/poiGet.php'));
            });

        },
        prepareUrlRequest: function (baseUrl) {
            var year = this.criteriaSelection.year;
            window.currentYear = year; // kino touched this
            var categories = this.criteriaSelection.categories;
            var url = baseUrl + '?year=' + year;
            url += '&category=';
            categories.forEach(function (item) {
                url += item + ",";
            })
            return url;
        },
        /********************************************
         * This Code will need to be modified for our to
         * implement a new version of the time slider
         * *******************************************/
        addTimeSlider: function (element, opts) {
            self = this;
            var timelineRange = opts.timelineRange;
            this.criteriaSelection.year = opts.defaultTimeLineValue;
            
            $(element).slider({
                value: opts.defaultTimeLineValue, 
                min: parseInt(timelineRange[0]), 
                max: parseInt(timelineRange[timelineRange.length - 1]),
                step: 1,
                slide: function (event, ui) {
                    var selectedYear = ui.value;
                    var val = "<div id='startDateDisplay' class='sliderDisplay'>" + selectedYear + "</div>";// + " " + timelineRange[ui.value]+
                    $('#slider span').html(val);
                },
                
                change: function (event, ui) {
                    var startYear = parseInt(timelineRange[0]); //First year on time line
                    var selectedYear = ui.value;//startYear + additive;
                    var correspondingFileNumber = timelineRange[Math.floor((ui.value - startYear) / 40)]; //Each 'major' year has a corresponding map-image. To allow these 'minor' years to grab the appropriate images, we must get the 'major' year that it is closest to (round up
                   
                    $('#mapThumbnail').html(' <a href="/u/maps/' + correspondingFileNumber + '.jpg" class="popup"  ><img src="/u/maps/' + correspondingFileNumber + '.jpg" id="mapThumbImg"/></a>');

                    self.cleanUp();
                    self.criteriaSelection.year = selectedYear; 
                    
                    window.apiF(selectedYear); //Load borders
                    self.getData(self.prepareUrlRequest('data/poiGet.php'));
                },
                create: function (event, ui) {
                    sliderHeaderSet();
                }

            }).each(function () {
                var opt = $(this).slider("option");
                var vals = timelineRange.length - 1;
                var startYear = timelineRange[0];
                var totalYears = timelineRange[vals] - startYear; //Total number of years covered by time slider
                for (var i = 0; i <= vals; i++) {
                    window.currentYear = timelineRange[i];
                    var yearsSinceStart =window. currentYear - startYear;
                    var percentFromLeft = yearsSinceStart / totalYears * 100;
                    
                    var el = $('<label >' + (window.currentYear) + '</label>').css('left', percentFromLeft + '%');
                    $("#slider").append(el);
                }
            });

        },
        addPano: function (selector, opts) {
            var elements = $(selector);
            var self = this;

            $.each(elements, function (key, element) {

                self.map.addPano(element, opts);
            });
        },
        infoWindows: function () {
            return this.map.infoWindows.items;
        },
        addMarker: function (opts) {
            //Removed all Geocoder code. This is not required, since POIs should
            //always have address or coords
            return this.map.addMarker(opts);
        },
        createMarker: function (poi) {

            return {
                id: poi.id,
                location: poi.location,
                lat: parseFloat(poi.lat),
                lng: parseFloat(poi.lng),
                content: poi.content,
                icon: poi.icon,
                events: [{
                        name: 'click',
                        callback: function (e, target) {
                            obj = poi;
                            var thumbnails = $('#thumbnails').empty();
                            var contentdiv = $('#descArea').empty();
                            var editTarget = $('#editPOI');
                            var deleteTarget = $('#poiIDDeleter');
                            infoAppear();
                            
                            //Quick html fix for POIs affected
                            //Decode
                            var newContent = decodeHTML(poi.content);
                            
                            contentdiv.append('<h3>' + poi.title + '</h3> <h5>'+poi.location+'</h5> <p>' + newContent + '</p></br></br></br>');

                            //Get the Gallery Images
                            $.post("/data/gallery.php", {
                                poiID: poi.id
                            }, function (data) {
                                thumbnails.append(data);
                                runGallery();
                                resizeImage();
                            });

                            editTarget.attr('href', 'admin.php?poi=' + poi.id);
                            deleteTarget.val(poi.id);
                        }
                    }]
            }

        },
        gotoMarker: function(gMarker){
          this.map.gotoMarker(gMarker);  
        },
        getMarker: function(poiId){
          this.map.getMarker(poiId);
        },
        addMarkerByAddress: function (opts) {

        },
        findMarkers: function (callback) {
            return this.map.findBy(callback);
        },
        getCurrentPosition: function (callback) {
            this.map.getCurrentPosition(callback);
        },
        removeMarkers: function (callback) {
            return this.map.removeBy(callback);
        },
        removeMapMarkers: function(){
            this.map.removeMarkers();
        },
        markers: function () {
            return this.map.markers.items;
        },
        // events bound via _on are removed automatically
        // revert other modifications here
        _destroy: function () {

        },
        // _setOptions is called with a hash of all options that are changing
        // always refresh when changing options
        _setOptions: function () {
            // _super and _superApply handle keeping the right this-context
            this._superApply(arguments);
            this._refresh();
        },
        // _setOption is called for each individual option that is changing
        _setOption: function (key, value) {

        }
    })






}(window, window.Mapster, google)
        )
function sliderHeaderSet() {
    var sliderDisplay = "<div id='startDateDisplay' class='sliderDisplay'>1800</div>";

    $('#slider span').html(sliderDisplay);

}