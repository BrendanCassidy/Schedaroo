<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

if (isset($_POST['action'])) {

    switch ($_POST['action']) {
        case "swap_assignments":
            swapAssignments($_POST['problem'], $_POST['firstUser'], $_POST['firstResource'], $_POST['secondUser'], $_POST['secondResource']);
	    
	    $first = 0;
	    $second = 0;
	    
	    if ($_POST['firstResource'] == 0) {
	      if (!hasResponded($_POST['problem'], $_POST['secondUser'])) {
		$second = 1;
	      }
	    }
	    if ($_POST['secondResource'] == 0) {
	      if (!hasResponded($_POST['problem'], $_POST['firstUser'])) {
		$first = 1;
	      }
	    }
	    echo '{"out":0, "first":' . $first . ', "second":' . $second . '}';

	    break;

        case "unassignParticipant":
	  unassignParticipant($_POST['problem'], $_POST['participant']);
	  echo '{"out":0}';
 	  break;

        case "update_resources":
            addData($_POST['problem'], 0, 'resources', $_POST['resources'], 1);
            echo '{"out":1}';
            break;

        case "calculate":
            calculate($_POST['problem']);
            echo '{"out":0}';
            break;

        case "get_preferences":
	    $prefOutput = '{"prefs": [';
	    $prefs = getPreferencesForParticipant($_POST['problem'], $_POST['user']);
	    $resources = getAllResources($_POST["problem"]);
	    foreach ($resources as $resource) {
	      if (!(in_array($resource['id'], $prefs))) {
		$strout = $resource['id'] . ',';
		$prefOutput .= $strout;
	      }
	    }
	    //	    $output = $output[0:-1];
	    $prefOutput .= '],';
	    $userOutput = '"users": [';
	    $users = getUsersForResource($_POST["problem"], $_POST["resource"]);
	    $allUsers = getParticipantsForProblem($_POST["problem"]);
	    foreach ($allUsers as $u) {
	      if (!(in_array($u['id'], $users))) {
		$strout = $u['id'] . ',';
		$userOutput .= $strout;
	      }
	    }
	    $output = $prefOutput . $userOutput;

	    $output .= ']}';
	    echo $output;
	    break;

        default:
            echo '{"out":1}';
            break;


    }
}

else { echo '{"out":2}'; }

?>