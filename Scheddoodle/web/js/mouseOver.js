    var onDiv = false;
    var onLink = false;
    var bubbleExists = false;
    var timeoutID;

    function addBubbleMouseovers(mouseoverClass) {
        $("." + mouseoverClass).mouseover(function(event) {
            if (onDiv || onLink) {
                return false;
            }

            onLink = true;
            onDiv = true;

            showBubble.call(this, event);
            clearTimeout(timeoutID);
        });

        $("." + mouseoverClass).mouseout(function() {
            onLink = false;
            timeoutID = setTimeout(hideBubble, 150);
        });

    }

    function hideBubble() {
        clearTimeout(timeoutID);
        if (bubbleExists && !onDiv) {
             $("#bubbleID").remove();

             bubbleExists = false;
        }
    }

    function showBubble(event) {
        if (bubbleExists) {
            hideBubble();
        }

        var tPosX = event.pageX - 50;
        var tPosY = event.pageY + 10;
        var text = "users who have not respodsfsdnded";
        $.post("get.php", { "action":"get" }, function(data) { text = "sdfds"; });
        $('<div id="bubbleID" style="top: ' + tPosY + 'px; left: ' + tPosX + 'px;">' + text + '</div>').appendTo('body');
        $("#bubbleID").mouseover(keepBubbleOpen).mouseout(letBubbleClose);
        bubbleExists = true;
    }

    function keepBubbleOpen() {
        onDiv = true;
    }

    function letBubbleClose() {
        onDiv = false;
        hideBubble();
    }

    $("document").ready(function() {
        addBubbleMouseovers("adminLink");
    });
