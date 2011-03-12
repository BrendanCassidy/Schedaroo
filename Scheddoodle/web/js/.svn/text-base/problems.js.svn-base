// problems.js -- javascript for problems.php

var currentView = "current";

var onLink = false;
var onDiv = false;
var timeoutID;

$(document).ready(function() {

    $(".editLink").mouseover(function() {
        var pos = $(this).offset();
        problem = $(this).parent().parent().attr("id");
        showBubble(pos, problem);
        onLink = true;
    });

    $(".editLink").mouseout(function() {
        onLink = false;
        timeoutID = setTimeout(letBubbleClose, 200);
    });

    $("#showAdvancedSearchButton").click(function() {
        $("#advancedSearchDiv").show();
        $("#basicSearchDiv").hide();
    });

    $("#hideAdvancedSearchButton").click(function() {
        $("#basicSearchDiv").show();
        $("#advancedSearchDiv").hide();
    });

    $(".infoButton").click(function() {
        $(this).parent().parent().find(".more").slideToggle();
        $(this).parent().parent().find(".title").toggleClass("expanded");
    });

    //$(".statusColumn").click(function() { alert($(this).parent().attr("id")); });

});

function showBubble(pos, problem) {

    hideBubble();

    iconPosX = pos.left;
    iconPosY = pos.top;
    var icon = '<div id="iconbubble" style="top: ' + iconPosY.toString() + 'px; left: ' + iconPosX.toString() + 'px;"><img src="images/edit.png"></div>';

    var posX = pos.left - 180;
    var posY = pos.top + 23;

    var html = '<div id="bubble" style="top: ' + posY.toString() + 'px; left: ' + posX.toString() + 'px;">';
    html = html + '<a href="problem.php?problem=' + problem + '">Edit Description</a>, <a href="timeslots.php?problem=' + problem + '">Edit Resources</a></div>';
    $(icon).appendTo('body');
    $(html).appendTo('body');


    $("#iconbubble").mouseover(function() { onLink = true; });
    $("#bubble").mouseover(function() { onDiv = true; });

    $("#iconbubble").mouseout(function() {
        onLink = false;
        timeoutID = setTimeout(letBubbleClose, 200);
    });

    $("#bubble").mouseout(function() {
      	onDiv = false;
      	timeoutID = setTimeout(letBubbleClose, 200);
    });

}

function letBubbleClose() {
    clearTimeout(timeoutID);
    if (!onLink && !onDiv) { hideBubble(); }
}

function hideBubble() {
    $("#iconbubble").remove();
    $("#bubble").remove();
}

function archiveProblem(problemID, userID) {
        $.post("do.php", { "action": "archive_problem", "problem": problemID, "user": userID }, function(data) {
            if (data.out == 0) {
                var unArchiveText = '<a href="javascript:void(0);" onclick="unArchiveProblem(' + problemID + ', ' + userID + ');"><img src="images/unarchive.png" title="Unhide Event"></a>';

                if (($("#eventsTable .row:visible").length == 1) && (currentView != "row")) {
                    $("#eventsTable, #eventsTable #head").hide();
                    $("#emptyEventsTable").fadeIn("fast");
                    $("#" + problemID).removeClass("current");
                    $("#" + problemID + " .archiveLink").html(unArchiveText);
                }
                else {
                    if (currentView == "row") {
                        $("#" + problemID).removeClass("current");
                        $("#" + problemID + " .archiveLink").html(unArchiveText);
                    }
                    else {
                        $("#" + problemID).fadeOut("fast", function() {
                            $("#" + problemID).removeClass("current");
                            $("#" + problemID + " .archiveLink").html(unArchiveText);
                        });
                    }
                }
            }
            else { alert("an error has occured while archiving this event"); }
         }, "json");
}

function unArchiveProblem(problemID, userID) {
        $.post("do.php", { "action": "unArchive_problem", "problem": problemID, "user": userID }, function(data) {
            if (data.out == 0) {
                $("#" + problemID + " .archiveLink").html('<a href="javascript:void(0);" onclick="archiveProblem(' + problemID + ', ' + userID + ');"><img src="images/archive.png" title="Hide Event"></a>');
                $("#" + problemID).addClass("current");
            }
            else { alert("an error has occured while unarchiving this event"); }
         }, "json");
}

function deleteProblem(problemID, problemName) {
    $("#" + problemID).addClass("todelete");
    if (confirm("Are you sure you want to delete the event:\n\n" + problemName)) {
        $.post("do.php", { "action": "delete_problem", "problem": problemID }, function(data) {
            if (data.out == 0) {
                if ($("#eventsTable .row:visible").length == 1) {
                    $("#eventsTable, #eventsTable #head").hide();
                    $("#emptyEventsTable").fadeIn("fast");
                    $("#" + problemID).remove();
                }
                else { $("#" + problemID).fadeOut("fast", function() { $("#" + problemID).remove(); }); }
            }
            else { alert("an error has occured while deleting this event"); }
         }, "json");
    }
    else { $("#" + problemID).removeClass("todelete"); }
}

function view(type) {
    $("#eventsTable, #eventsTable #head").show();
    var numShowing = $("#eventsTable .row:visible").length;
    $("#emptyEventsTable, #eventsTable .row").hide();
    if ($("#eventsTable ." + type).length == 0) {
        $("#eventsTable, #eventsTable #head").hide();
        $("#emptyEventsTable").fadeIn("fast");
    }
    else if (numShowing == 0) { $("#eventsTable ." + type).fadeIn("fast"); }
    else { $("#eventsTable ." + type).show(); }
    currentView = type;
}

function advancedView(visibility, userStatus, responseStatus, problemStatus) {
    //alert("entering advanced view");
    var filters = new Array();
    filters[0] = visibility;
    filters[1] = userStatus;
    filters[2] = responseStatus;
    filters[3] = problemStatus;
    $("#eventsTable, #eventsTable #head").show();
    var numShowing = $("#eventsTable .row:visible").length;
    $("#emptyEventsTable, #eventsTable .row").hide();
    if (($("#eventsTable ." + visibility + "." + userStatus + "." + responseStatus + "." + problemStatus).length == 0)) {
        $("#eventsTable, #eventsTable #head").hide();
        $("#emptyEventsTable").fadeIn("fast");
    }
    else {
        for (var key in filters) {
	    if (numShowing == 0) {
		$("#eventsTable ." + filters[key]).fadeIn("fast");
		numShowing = $("#eventsTable .row:visible").length;
	    }
	    else if (key == 0) {
		$("#eventsTable ." + filters[key]).show();
	    }
	    else if (filters[key] != 'row') {
		$("#eventsTable .row:not(." + filters[key] + ")").hide();
	    }
	}
    }
    currentView = visibility;
}