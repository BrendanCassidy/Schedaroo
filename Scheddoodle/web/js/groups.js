function view(type) {
    $("#groupsTable").show();
    var numShowing = $("#groupsTable tr:visible").length;
    $("#emptyGroupsTable, #groupsTable tr").hide();
    if ($("#groupsTable ." + type).length == 0) {
        $("#groupsTable").hide();
        $("#emptyGroupsTable").fadeIn("fast");
    }
    else if (numShowing == 0) { $("#groupsTable ." + type).fadeIn("fast"); }
    else { $("#groupsTable ." + type).show(); }
}

function deleteGroup(groupID, groupName) {
    $("#" + groupID).addClass("todelete");
    if (confirm("Are you sure you want to delete the group:\n\n" + groupName)) {
        $.post("do.php", { "action":"delete_group", "group":groupID }, function(data) {
            if (data.out == 0) {
                if ($("#groupsTable tr:visible").length == 1) {
                    $("#groupsTable").hide();
                    $("#emptyGroupsTable").fadeIn("fast");
                    $("#" + groupID).remove();
                }
                else { $("#" + groupID).fadeOut("fast", function() { $("#" + groupID).remove(); }); }
            }
            else { alert("an error has occured while deleting the group"); }
        }, "json");
    }
    else { $("#" + groupID).removeClass("todelete"); }
}