/* javascript file for publicEvents.php */

// add a case insensative version of the contains selector
jQuery.expr[':'].Contains = function(a,i,m){
     return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
};

$(document).ready(function() {
    filter();
    $("input[name='filterBox']").keydown(filter).keyup(filter);
});

function filter() {

    $("#emptyEventsTable").hide();
    $("th, .row").show();
    $(".row .keywords:not(:Contains('" + $("input[name='filterBox']").val() + "'))").parent().parent().hide();
        
    $("th").each(function() {
        if ($("." + $(this).parent().attr("id") + ":visible").length == 0) { $(this).hide(); }
    });
    if ($(".row:visible").length == 0) { $("#emptyEventsTable").fadeIn("fast"); }
}