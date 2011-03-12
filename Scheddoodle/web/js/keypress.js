/*
* Original Author:      Marco Kuiper
* Edited 2/2011 by Brendan Cassidy 
*/

var currentSelection = 0;
var currentUrl = '';
/*
google.load("jquery", "1.3.1");
google.setOnLoadCallback(function()
*/

$(document).ready(function()
{
    // Register keypress events on the whole document
    //$('#participantBox').keypress(function(e) {
    $('#participantBox').live('keydown',function(e) {
        //alert('This code was read, at least!');
        switch(e.keyCode) { 
            // User pressed "up" arrow
            case 38:
                navigate('up');
            break;
            // User pressed "down" arrow
            case 40:
                navigate('down');
            break;
            // User pressed "enter"
            case 13:
                if(currentUrl != '') {
                    window.location = currentUrl;
                }
            break;
        }
    });
    
    // Add data to let the hover know which index they have
    for(var i = 0; i < $("#suggestions ul li a").size(); i++) {
        $("#suggestions ul li a").eq(i).data("number", i);
    }
    
    // Simulote the "hover" effect with the mouse
    $("#suggestions ul li a").hover(
        function () {
            currentSelection = $(this).data("number");
            setSelected(currentSelection);
        }, function() {
            $("#suggestions ul li a").removeClass("itemhover");
            currentUrl = '';
        }
    );
});

function navigate(direction) {
    // Check if any of the suggestions items is selected
    /*
    if($("#suggestions ul li .itemhover").size() == 0) {
        currentSelection = -1;
    }
    
    if(direction == 'up' && currentSelection != -1) {
    alert('Look, I got called!');
        if(currentSelection != 0) {
            currentSelection--;
        }
    } else if (direction == 'down') {
        if(currentSelection != $("#suggestions ul li").size() -1) {
            currentSelection++;
        }
    }
    */
    var currentSelection = 0;
    
    if(direction == 'up' && currentSelection != -1) {
    alert('Someone pressed the up button!' + currentSelection);
        if(currentSelection != 0) {
            currentSelection--;
        }
    } else if (direction == 'down') {
    alert('Someone pressed the down button!' + currentSelection);
        if(currentSelection != $("#suggestions ul li").size() -1) {
            currentSelection++;
        }
    }
    setSelected(currentSelection);
}

function setSelected(menuitem) {
    $("#suggestions ul li a").removeClass("itemhover");
    $("#suggestions ul li a").eq(menuitem).addClass("itemhover");
    currentUrl = $("#suggestions ul li a").eq(menuitem).attr("href");
}
