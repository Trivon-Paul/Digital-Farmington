(function (window, $) {
    var historyMap = $('#map-canvas').mapster(Mapster.MAP_OPTIONS);
    var pois;

    getIntialData('data/intialSetting.json');



    //getIntialData('data/intialSetting.json');

    function getIntialData(url) {

        $.ajax({
            url: url

        }).done(function (jsonData) {
            
            $.getJSON(url, function (json) {
                jsonData = json;
                
                var opts = {};
                opts.defaultTimeLineValue = jsonData.defaultTimeLineValue;
                opts.categories = jsonData.categories;
                opts.timelineRange = jsonData.timelineRange;
                historyMap.mapster('getData', 'data/poiGet.php');
                historyMap.mapster('addTimeSlider', '#slider', opts);
                historyMap.mapster('addCategories', '#categories', opts);
            }); //new code
        });
    };

}(window, jQuery))





	