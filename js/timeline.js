/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var urlParams;
(window.onpopstate = function() {
    var match,
            pl = /\+/g, // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function(s) {
                return decodeURIComponent(s.replace(pl, " "));
            },
            query = window.location.search.substring(1);

    urlParams = {};
    while (match = search.exec(query))
        urlParams[decode(match[1])] = decode(match[2]);
})();

var tl;
function onLoad() {
    var eventSource = new Timeline.DefaultEventSource(0);
    var bandInfos = [
        Timeline.createBandInfo({
            eventSource: eventSource,
            width: "70%",
            intervalUnit: Timeline.DateTime.MONTH,
            intervalPixels: 100
        }),
        Timeline.createBandInfo({
            eventSource: eventSource,
            overview: true,
            trackHeight: 0.5,
            trackGap: 0.2,
            width: "30%",
            intervalUnit: Timeline.DateTime.YEAR,
            intervalPixels: 200
        })
    ];
    bandInfos[1].syncWith = 0;
    bandInfos[1].highlight = true;

    tl = Timeline.create(document.getElementById("tl"), bandInfos, Timeline.HORIZONTAL);
    // Adding the date to the url stops browser caching of data during testing or if
    // the data source is a dynamic query...
    $.ajax({
        url: "/functions.php?action=get_tasks",
        type: "POST",
        data: "&project_uid=" + urlParams['project'],
        success: function(response) {
            if (response != 0) {
                var json_data = jQuery.parseJSON(response);
                //alert(json_data);
                tl = Timeline.create(document.getElementById("tl"), bandInfos, Timeline.HORIZONTAL);
                eventSource.loadJSON(json_data, ".");
            } else {
                alert("There is no tasks assigned to you.");
            }
        }
    });
//    tl.loadJSON("test2.js?" + (new Date().getTime()), function(json, url) {
//        eventSource.loadJSON(json, url);        
//    });
}
var resizeTimerID = null;
function onResize() {
    $("#tl").height($(document).height() - 70);
    if (resizeTimerID == null) {
        resizeTimerID = window.setTimeout(function() {
            resizeTimerID = null;
            tl.layout();
        }, 500);
    }
}