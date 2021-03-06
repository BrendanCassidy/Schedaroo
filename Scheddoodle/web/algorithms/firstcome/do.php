<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case "respond":
            $reply = updatePreferences($_POST['problem'], $_POST['user'], $_POST['resources']);
            if ($reply == 0) {
                markResponded($_POST['problem'], $_POST['user']);
                echo '{"out":0}';
            }
            else if ($reply == 1) { echo '{"out":1}'; } // the case where another user already selected the slot
            break;

        case "update_resources":
            addData($_POST['problem'], 0, 'resources', $_POST['resources'], 1);
            echo '{"out":1}';
            break;

       case "swap_assignments":
            swapAssignmentsFCFS($_POST['problem'], $_POST['firstUser'], $_POST['firstResource'], $_POST['secondUser'], $_POST['secondResource']);
            echo '{"out":0}';
            break;
            
       case "unassignParticipant":
           unassignParticipantFCFS($_POST['problem'], $_POST['participant']);
           echo '{"out":0}';
           break;
 
       default:
           echo '{"out":1}';
           break;
    }
}

else { echo '{"out":2}'; }

?>


