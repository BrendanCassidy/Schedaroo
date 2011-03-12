/* autocomplete jquery script */

$(document).ready(function() {
    $("input[name='username']").autocomplete({
        source: "auto.php",
        minLength: 1,
        select: function(event, ui) {
            var participants = $("textarea[name='participants']").val();
            if (participants != "") { participants = participants + "\n"; }
            $("textarea[name='participants']").val(participants + ui.item.uid);
	    $(this).val(""); // sets the username field to empty
            return false; // tells autocomplete not to update the field with the selected value
        }
    });
});