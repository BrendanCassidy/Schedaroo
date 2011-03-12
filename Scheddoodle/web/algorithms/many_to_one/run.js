$(document).ready(function() {
        
    // fix the next three blocks to make the code nicer

    $('.slider').slider({ // maybe make it with snap where values is the number of users
        min: -50,
        max: 100
    });

    $("#outputTable th.slotCell").click(function() { // when you select a column, maybe we should just highligh columns of the same quality.
        var id = $(this).find(".idField").text();
        for (i=0;i<max_col.length;i++) { if (max_col[i] == id) { max_col_index = i; } }
        if (max_col[max_col_index] != id) { max_col = [id]; max_col_index = 0; $("#options").hide("slow"); }
        highlight(max_col[max_col_index]);
    });

    $("#comment").keyup(function() {
        $('#saveButton').attr('value','Save');
        $('#saveButton').attr('disabled', false);
    });

    var go = 0;
    if (max_col != []) { go = max_col[0]; }

    initializeSlots();           
 
    $('.slider').slider({
        change: refreshSlots,
        slide: refreshSlots
    });

    refreshSlots();

    if (go) { highlight(go); }

});

    function initializeSlots() {
        $('table .row').each(function() {
           $(this).find('.slider').slider("value", $(this).find('.valueCell').text()); // change this to valueField
        });
    }
    
    function refreshSlots() {
        for (i=0;i<totals.length;i++) { totals[i] = 0; }
        $('#outputTable .row').each(function() {
            var i = 0;
            var value = $(this).find('.slider').slider('value');
            $(this).find('.valueCell').text(value);
            $(this).find('.slotCell').each(function () { // maybe consider changing the name of slot cell
                if ($(this).find('.slot').attr('checked') == true) {
                    totals[i] = totals[i] + value;
                }
                i++;
            });
        });
        
        i = 0;
        var max = -100000; // have a better starting value than this since this is not a perfect solution
        max_col = [];
        $('#outputTable .totals .total').each(function() { // loop through all the columns and find the one(s) with the largest values
            var total = totals[i];
            var x = $(this).find('.idField').text();
            if (total > max) {
                max = total;
                max_col = [x];
            }
            else if (total == max) {
                max_col.push(x);
            }
            $(this).find('.valueField').text(total); // update the total value at the bottom of the colum
            i++;
        });
        if (max_col.length < 2) { // hide the menu if less than 1 column with a max value
            $('#options').hide('slow');
        }
        else {
      $('#optimal').text(max_col.length + ' optimal times'); // show the menu
            $('#options').show('slow')
        }
        
        highlight(max_col[max_col_index]); 
    }

    function showNext() {
        max_col_index++;
        if (max_col.length <= max_col_index) { max_col_index = 0; } // loop around if needed
        highlight(max_col[max_col_index]);
    }
    
    function showPrevious() {
        max_col_index--;
        if (max_col_index < 0) { max_col_index = (max_col.length - 1); } // loop around if needed
        highlight(max_col[max_col_index]);
    }
    
    function highlight(id) {
        $("#outputTable").find('tr, th, td').removeClass('top');
        $("#outputTable .row").find('.slotCell .idField').filter(function() { return $(this).text() == id  }).parent().each(function() {
            $(this).addClass("top"); // highlight the the next row in the column (maybe change this to avoid highlighting the cell twice in the case that they can attend
            if ($(this).find('.slot').attr('checked') == true) {
                $(this).parent().addClass("top"); // if the user can attend, then highlight the row
             }
        });
        $("#outputTable .totals").find('td .idField').filter(function() { return $(this).text() == id  }).parent().addClass("top"); // highlight total, can make this not use filter/find?
        $("#outputTable").find('th .idField').filter(function() { return $(this).text() == id  }).parent().addClass("top"); // highlight header, can make this not use filter/find?
        
        // when the user makes changes, re-enable the save button
        $('#saveButton').attr('value','Save');
        $('#saveButton').attr('disabled', false);
    }

    function save(problem) {

        // change the save button
        $('#saveButton').attr('value','Saving');
        $('#saveButton').attr('disabled', true);

        $.post('do.php', { "action": "saveMaxCol", "problem": problem, "max_col_index": max_col[max_col_index] } );
        $.post("../../do.php", { "action": "update_problem_comment", "problem": problem, "comment": $("#comment").val() } );

        $('table .row').each(function() { // for each row in the table, save that user's importance
            var user = $(this).find('.userCell .idField').text();
            var importance = $(this).find('.valueCell').text(); // change to priortyValueCell
            $.post('do.php', { "action": "saveUser", "problem": problem, "user": user, "importance": importance });
            // check success
        });

        //window.location='../../problems.php'; // fix this. when this line is in, it executes before other code is done running -- problem
	$('#saveButton').attr('value','Saved');
        
    }

    function togglePriority() {
        if ($("#priorityCheckbox").val() == "show") {
            $(".priorityCell").show();
            $("#priorityCheckbox").attr("value", "hide");
        }
        else {
      	    $(".priorityCell").hide();
      	    $("#priorityCheckbox").attr("value", "show");
        }   

    }

    function toggleValues() {
        if ($("#valuesCheckbox").val() == "show") {
            $(".valueCells").show();
            $("#valuesCheckbox").attr("value", "hide");
	}
        else {
            $(".valueCells").hide();
            $("#valuesCheckbox").attr("value", "show");
        }
    }

    function reset() {
        alert("resetting coming soon");
    }
