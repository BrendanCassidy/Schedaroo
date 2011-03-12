/*
 * interface.js
 * contains all of the javascript needed to make droppable interface elements work
 */

$(document).ready(function() {
    $("#output").click(function() { $(this).fadeOut('slow'); });

    $("#comment").keyup(function() {
        $('#saveCommentsButton').attr('value','Save Comments');
        $('#saveCommentsButton').attr('disabled', false);
    });

    if ($("#dialog").length) {
        $("#dialog").dialog({
            modal: true,
            minWidth: 800,
            autoOpen: false,
            buttons: {
                Close: function() { $(this).dialog("close"); }
            }
        });
    }

    $("#opener").click(function() {
        if ($("#dialog").length) {
            $("#dialog").dialog("open");
            return false;
        }
        else {
            alert("There is no help information for this page");
        }
    });

});

function saveComments(problem) {
    // change the save button
    $('#saveCommentsButton').attr('value','Saving Comments');
    $('#saveCommentsButton').attr('disabled', true);

    $.post("../../do.php", { "action": "update_problem_comment", "problem": problem, "comment": $("#comment").val() }, function(data) {
        if (data.out == 0) {
            $('#saveCommentsButton').attr('value','Comments Saved');
        }
        else {
            alert("an error occured while saving comments. try again");
            $('#saveCommentsButton').attr('value','Save Comments');
            $('#saveCommentsButton').attr('disabled', false);
        }
    }, "json");
}


function postMeeting(problem, notify) {
    if (notify == true || $('#postButton').attr('value') == "Post") {
	$('#postButton').attr('value','Posting');
    	$('#postButton').attr('disabled',true);
    	$.post("../../do.php", { "action": "status", "problem": problem, "status": "posted" } );
	$('#postMessage').html("Event is <b>Posted</b> (participants can view assignments)");
	$('#postButton').attr('value','Unpost');
	$('#postButton').attr('disabled',false);
     }
     else if ($('#postButton').attr('value') == "Unpost") {
 	$('#postButton').attr('value','Unposting');
    	$('#postButton').attr('disabled',true);
    	$.post("../../do.php", { "action": "status", "problem": problem, "status": "closed" } );
	$('#postMessage').html("Event is <b>Unposted</b> (participants cannot view assignments)");
	$('#postButton').attr('value', 'Post');
    	$('#postButton').attr('disabled',false);
    }
}

function notify(problem){
  if (confirm("Do you really want to send notification emails to the participants of this event?")) {
  $.post("../../do.php", { "action":"notify_participants", "problem":problem }, function(data) {
        if (data.out == 0) {
            $("#notify_email").html("Notifications Sent");
        }
        else { alert("An error has occurred when sending the request."); }
    }, "json");

  }
}

function notifyPosted(problem){
  if (confirm("Do you really want to send notification emails to the participants of this event?")) {
  $.post("../../do.php", { "action":"notify_participants_posted", "problem":problem }, function(data) {
	if (data.out == 0) {
            $("input[name='notify_posted_email']").val("Notifications Sent");
            $("input[name='notify_posted_email']").attr('disabled',true);
	}
        else { alert("An error has occurred when sending the request."); }
    }, "json");

  }
}

function logout() {
  var cookie_date = new Date();
  cookie_date.setTime(cookie_date.getTime() - 1);
  document.cookie = "user" + "=; expires=" + cookie_date.toGMTString();
  window.location = 'http://cs-research1.mathcs.carleton.edu/scheddoodle/sched-doodle/web/login.php';
}
