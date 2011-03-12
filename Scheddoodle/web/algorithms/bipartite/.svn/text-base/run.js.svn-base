var first = 0;
var second = 0;

$(document).ready(function() {

//	$(".tablesorted").tablesorter({ sortList: [[0,0]] });

	$('#swapButton').attr('disabled', true);
	
	//showAvailable(568, 5,1);

	tableClick($("#assignmentTable tbody tr, #unassignedTable tbody tr"));
});

function tableClick(row) {
	row.click(function() {
		$(this).addClass("select");
                $('#swapButton').attr('disabled', true);
                $('#unassignButton').attr('disabled', true);
		if (first == this) {
			$(first).removeClass("select");
			first = second;
			showAll();
			if (first) {
				//alert($('#problemID').html());
				showAvailable($('#problemID').html(), $(second).find(".idCell").last().html(), $(second).find(".idCell").first().html());
			}
			second = 0;
		}
		else if (second == this) {
			$(second).removeClass("select");
			second = 0;
		}
	 	else if (!first) {

			first = this;
			showAvailable($('#problemID').html(),$(this).find(".idCell").last().html(),$(first).find(".idCell").first().html());

		}

		else if (!second) {
                        if ($(this).parent().parent().attr("id") == "unassignedTable" && $(first).parent().parent().attr("id") == "unassignedTable") {
                             $(this).removeClass("select");
                        }
	                else {    second = this; }
		}
		else {
                        if ($(this).parent().parent().attr("id") == "unassignedTable" && $(second).parent().parent().attr("id") == "unassignedTable") {
                       $(this).removeClass("select");
                        }

else {			$(first).removeClass("select");
			first = second;
			second = this;
}
		}	
		if (first && second) {
			$('#swapButton').attr('disabled', false);
$('#unassignButton').attr('disabled', true);
		}
                if (first && !second && $(first).parent().parent().attr("id") != "unassignedTable" && $(first).find("td:last .idCell").html() != 0) {
                    $('#unassignButton').attr('disabled', false);
                }
	});
};

function showAvailable(problem, user, resource) {
	$.post("do.php", {"action": "get_preferences", "problem": problem, "user": user, "resource":resource}, function(data){
		for (var i = 0; i < data.prefs.length; i++) {
			$("#assignmentTable tbody tr").each(function () {
				if (data.prefs[i] == $(this).find(".idCell").first().html() && data.prefs[i] != 0) {
					$(this).addClass("notAvailable");
				}
			});
		}
		if (resource != 0) {
			for (var i = 0; i < data.users.length; i++) {
				$("#assignmentTable tbody tr, #unassignedTable tbody tr").each(function () {
					if (data.users[i] == $(this).find(".idCell").last().html()) {
//						alert($(this).html());
						$(this).addClass("notAvailable");
					}
 				});
			}
		}
		//alert(data.prefs[i]);
		
		
	}, "json");
}

function showAll(problem) {
	$("#assignmentTable tbody tr, #unassignedTable tbody tr").each(function() {
		$(this).removeClass("notAvailable");
	});
}
function swap(problem) {
    var firstResource = $(first).find("td:first .idCell").html();
    var firstUser = $(first).find("td:last .idCell").html();
    var secondResource = $(second).find("td:first .idCell").html();
    var secondUser = $(second).find("td:last .idCell").html();

//alert(firstUser + "--" + firstResource + "\n" + secondUser + "--" + secondResource);

    $.post("do.php", {"action": "swap_assignments", "problem": problem, "firstUser": firstUser, "firstResource": firstResource, "secondUser": secondUser, "secondResource": secondResource }, function(data) {

	if (data.out == 0) {

            if (firstResource==0 && secondUser==0) {
                var firstCell = $(first).find("td:last").html();
                $(second).find("td:last").html(firstCell); 
                $(second).removeClass("select");
                $(first).removeClass("select");
                $(first).remove();
            }

            else if (secondResource==0 && firstUser==0) {
                var secondCell = $(second).find("td:last").html();
                 $(first).find("td:last").html(secondCell); 

                 $(first).removeClass("select");

                $(second).remove();
             }
            else {
            var firstCell = $(first).find("td:last").html();
            var secondCell = $(second).find("td:last").html();
            $(first).find("td:last").html(secondCell);
            $(second).find("td:last").html(firstCell);

            $(first).removeClass("select");
            $(second).removeClass("select");
            } 
	
	    $(first).removeClass("notresponded");
	    $(second).removeClass("notresponded");

	    if (data.first == 1) {
		$(second).addClass("notresponded");
	    }

	    if (data.second == 1) {
	        $(first).addClass("notresponded");
	    }

            first = 0;
            second = 0;

	    showAll();

        }

        else { alert("error while swapping"); }
    }, "json");

}

function unassign(problem) {

   $.post("do.php", { "action":"unassignParticipant", "problem": problem, "participant": $(first).find("td:last .idCell").text() }, function(data) {
      if (data.out == 0) {
          $(first).removeClass("select");
          $("#unassignedTable tr:last").after('<tr><td style="display: none;"><span class="nameCell"></span><span class="idCell">0</span></td><td>' + $(first).find("td:last").html() + '</td></tr>');
          $(first).find("td:last").html('<span class="nameCell">--</span><span class="idCell">0</span>');
	  tableClick($("#unassignedTable tr:last"));
	  first = 0;
	  showAll();

       }
       else { alert("error"); }

     }, "json");

}

function calculate(problem) {
	$.post("do.php", {"action": "calculate", "problem": problem }, function(data) {
            if (data.out == 0) {
              location.reload(true);
            }
            else { alert("error in recalculating assignments"); }
	}, "json");
}