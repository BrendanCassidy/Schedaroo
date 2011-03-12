$(document).ready(function() {

	$('#form').change(function() {
		$('#saveButton').attr('value','Save');
		$('#saveButton').attr('disabled', false);
	});
	
	$("input[name='name'], textarea[name='description'], textarea[name='participants']").keyup(function() { 
		$('#saveButton').attr('value','Save');
		$('#saveButton').attr('disabled', false);
	});
});

$(function() { // replaces spaces with underscores
    var txt = $("input[name='name']");
    txt.change(function(event) { replaceText(event, txt); }).blur(function(event) { replaceText(event, txt); });
});

function replaceText(event, txt) { // replaces spaces with underscores ** need to fix to maintain cursor position
    txt.val(txt.val().replace(/\s/g, '_'));
}

function save() {
        $('#nameError').hide();
        if ($("input[name='name']").val() == "") { alert("Group must have a name"); $("input[name='name']").focus(); return; }

	$('#saveButton').attr('value','Saving');
	$('#saveButton').attr('disabled',true);
	
	var removeParticipants = "";
	$("input[name='existing_participants[]']:not(:checked)").each(function() {
		removeParticipants = removeParticipants + $(this).val() + " ";
	});
	removeParticipants = removeParticipants.slice(0, -1);
        
	$.post('do.php',
		{
			'action': 'update_group',
			'group': $("input[name='group']").val(),
			'admin': $("input[name='admin']").val(),
			'name': $("input[name='name']").val(),
			'description': $("textarea[name='description']").val(),
			'type': $("input[name='type']:checked").val(),
			'removeParticipants': removeParticipants,
			'newParticipants': $("textarea[name='participants']").val()
		},
		function(data) {
			if (data.id) { $("input[name='group']").val(data.id); }

			if (data.nameError) {
			    $("#nameError").text($("input[name='name']").val() + ' already exists as a user or group. choose a different name.').show();
                            $("input[name='name']").val(data.name).focus();
			}
			
			if (data.added) {
				$.each(data.added, function(i, user) { $('#existing_participants').append('<li><input type="checkbox" name="existing_participants[]" value="' + user[0] + '" checked>' + user[1] + '</li>'); });
			}

                        $("input[name='existing_participants[]']:not(:checked)").each(function() { $(this).parent().remove(); });
			
			$('#output').html('');
			
			if (data.duplicate) {
				$('#output').append('<h2>These Users were Already Participants:</h2>');
				$.each(data.duplicate, function(i, user) { $('#output').append(user + '<br>'); });
			}
			if (data.failed) {
				$('#output').append('<h2>Failed to Add These Participants:</h2>');
				$.each(data.failed, function(i, user) { $('#output').append(user + '<br>'); });
			}
			
			if ($('#output').html()) { $('#output').show(); } // show the output field
			
			if (!(data.nameError || data.duplicate || data.failed)) { window.location = 'groups.php'; }
                        else {
                            $("textarea[name='participants']").val(''); // clear the participants
                            $('#saveButton').attr('value','Save'); // change the save button to say saved
                            $('#saveButton').attr('disabled',false);
                        }
		}, "json");
}

function request(user, group) {
    $.post("do.php", { "action": "group_request", "group": group, "user": user }, function(data) {
        if (data.out == 0) {
            $("input[name='requestButton']").val("Request Pending");
            $("input[name='requestButton']").attr('disabled', true);
        }
        else { alert("an error has occured when sending the request"); }
     }, "json");
}

function approve(user, group) {
  $.post("do.php", { "action": "group_approve", "group": group, "user": user }, function(data) {
	   if (data.out == 0) { $("#" + user).remove(); }
	   else { alert("an error has occured when approving this participant's group request"); }
	 }, "json");
}

function ignore(user, group) {
  $.post("do.php", { "action": "group_ignore", "group": group, "user": user }, function(data) {
	   if (data.out == 0) { $("#" + user).parent().remove(); }
	   else { alert("an error has occured when ignoring this participant's group request"); }
	 }, "json");
}