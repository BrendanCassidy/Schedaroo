$(document).ready(function() {
    $("input[name='expiration_time']").datetimepicker({ dateFormat: 'yy-mm-dd', minDate: 0, minTime: 0 });
    
    $("input[name='status']").change(function() {
        if ($("input[name='status']:checked").val() != "timed") { $("input[name='expiration_time']").attr('disabled', true); }
        else { $("input[name='expiration_time']").attr('disabled', false); }
    });
    
    $('#form').change(function() {
        $('#saveButton').attr('value','Save');
        $('#saveButton').attr('disabled', false);
    });
    
    $("input[name='name'], textarea[name='description'], textarea[name='participants']").keyup(function() { 
        $('#saveButton').attr('value','Save');
        $('#saveButton').attr('disabled', false);
    });

});

function save(next) {
    $('#saveButton').attr('value','Saving');
    $('#saveButton').attr('disabled',true);
    
    var removeParticipants = '';
    $("input[name='existing_participants[]']:not(:checked)").each(function() {
        removeParticipants = removeParticipants + $(this).val() + " ";
    });
    removeParticipants = removeParticipants.slice(0, -1);

    $.post("do.php",
        {
            "action": $("input[name='action']").val(),
            "problem": $("input[name='problem']").val(),
            "admin": $("input[name='admin']").val(),
            "algorithm" :$("input[name='algorithm']").val(),
            "name": $("input[name='name']").val(),
            "description": $("textarea[name='description']").val(),
            "status": $("input[name='status']:checked").val(),
            "type": $("input[name='type']:checked").val(),
            "expiration_time": $("input[name='expiration_time']").val(),
            "removeParticipants": removeParticipants,
            "newParticipants": $("textarea[name='participants']").val()
        },
        function(data) {
            if (data.id) {
                $("input[name='action']").val('update_problem');
                $("input[name='problem']").val(data.id);
                $("textarea[name='participants']").val(''); // clear the participants
                $('#saveButton').attr('value','Saved'); // change the save button to say saved
            }

            else {
                alert("An error has occured while saving this problem. Please try saving again.");
                $('#saveButton').attr('disabled',false);
                $('#saveButton').attr('value','Save');
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
            
            if ($('#output').html()) { $('#output').show(); $("#tabs").tabs("select", 2); } // show the output field
            else { $('#output').hide(); }

            if (!(data.duplicate || data.failed)) {
                if (next == 1 && !(data.duplicate || data.failed)) { window.location='algorithms/' + algorithm + '/problem.php?problem=' + $("input[name='problem']").val(); }
                else if (next == 2 && !(data.duplicate || data.failed)) { return; }
                else if (next == 3 && !(data.duplicate || data.failed)) { window.location = 'problems.php'; }
            }
            else {
                $('#saveButton').attr('disabled',false);
                $('#saveButton').attr('value','Save');
            }
        }, "json");
}
