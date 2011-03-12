<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

if(isset($_POST['action'])) {

    switch ($_POST['action']) {
        case "saveUser":
            addData($_POST['problem'], $_POST['user'], 'importance', $_POST['importance'], 1); // do this as an array
            echo '{"out":0}';
            break;

        case "saveMaxCol":
            addData($_POST['problem'], 0, 'max_col_index', $_POST['max_col_index'], 1);
            break;

        case "update_resources":
            addData($_POST['problem'], 0, 'resources', $_POST['resources'], 1);
            echo '{"out":1}';
            break;
        
        default:
            echo '{"error":1}';
            break;
    }
}

else { echo '{"error":1}'; }
?>

