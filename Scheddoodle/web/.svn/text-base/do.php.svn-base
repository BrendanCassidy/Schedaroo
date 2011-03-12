<?php

include_once 'includes/config.inc';
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case "add_problem": // combine this with update_problem

            // check to make sure user is allowed to do this

            $addedUsers = array();
            $failedUsers = array();
            $duplicateUsers = array();
            $newParticipants = splitOnNewLines($_POST['newParticipants']);

            if (!$_POST['name']) { $name = "[untitled event]"; }
	    else { $name = $_POST['name']; }

            // add the problem
            $problem = addProblem($name, $_POST['algorithm'], $_POST['description'], $_POST['expiration_time'], $_POST['status'], $_POST['type']);

            // set the admin
            addAdminToProblem($problem, $current_user);

            // add the new participants
            foreach ($newParticipants as $newParticipant) {
                $user = getUserByName($newParticipant);
                if ($user) {
                    if (addParticipantToProblem($problem, $user['id'])) { $duplicateUsers[] = $newParticipant; }
                    else { $addedUsers[] = array($user['id'], getNameString($user)); } 
                }
                else { // add a group
                    $group = getGroupByName($newParticipant);
                    if ($group != 0 && canUseGroup($group['id'], $current_user)) {
                        $usersForGroup = getParticipantsForGroup($group['id']);
                        foreach ($usersForGroup as $userForGroup) {
                            if ($userForGroup['isParticipant'] != 2) { continue; }
                            if (addParticipantToProblem($problem, $userForGroup['id'])) { $duplicateUsers[] = $userForGroup['name']; }
                            else { $addedUsers[] = array($userForGroup['id'], getNameString($userForGroup)); }
                        }
                    }
                    else { $failedUsers[] = $newParticipant; }
                }
            }
            
            // construct the JSON output
            $string = '{"id":' . $problem . ',';

            if (!empty($addedUsers)) { // report the added users
                $string .= '"added":[';
                foreach ($addedUsers as $addedUser) {
                    $string .= '[' . $addedUser[0] . ',"' . $addedUser[1] . '"],';
                }
                $string = substr($string,0,-1) . '],';
            }
            
            if (!empty($duplicateUsers)) { // report the duplicate users
                $string .=  '"duplicate":[';
                foreach ($duplicateUsers as $duplicateUser) {
                    $string .= '"' . $duplicateUser . '",';
                }
                $string = substr($string,0,-1) . '],';
            }
            
            if (!empty($failedUsers)) { // report the failed users
                $string .= '"failed":[';
                foreach($failedUsers as $failedUser) {
                    $string .= '"' . $failedUser . '",';
                }
                $string = substr($string,0,-1) . '],';
            }
            
            $string = substr($string,0,-1) . '}';
            echo $string;
            break;
            
        case "update_problem":
           
            // check to make sure user is the admin

            $problem = $_POST['problem'];
            $newParticipants = splitOnNewLines($_POST['newParticipants']);
	    if ($_POST['removeParticipants']) { $removeParticipants = explode(" ", $_POST['removeParticipants']); }
            else { $removeParticipants = array(); }

            $removedUsers = array();  
            $addedUsers = array();
            $failedUsers = array();
            $duplicateUsers = array();

            // remove the unchecked participants
            foreach ($removeParticipants as $removeParticipant) {
                removeParticipantFromProblem($problem, $removeParticipant);
            }
        
            // add the new participants
            foreach ($newParticipants as $newParticipant) {
                $user = getUserByName($newParticipant);
                if ($user) {
                    if (addParticipantToProblem($problem, $user['id'])) { $duplicateUsers[] = $newParticipant; }
                    else { $addedUsers[] = array($user['id'], getNameString($user)); } 
                }
                else { // add a group
                    $group = getGroupByName($newParticipant);
                    if ($group != 0 && canUseGroup($group['id'], $current_user)) {
                        $usersForGroup = getParticipantsForGroup($group['id']);
                        foreach ($usersForGroup as $userForGroup) {
                            if ($userForGroup['isParticipant'] != 2) { continue; }
                            if (addParticipantToProblem($problem, $userForGroup['id'])) { $duplicateUsers[] = $userForGroup['name']; }
                            else { $addedUsers[] = array($userForGroup['id'], getNameString($userForGroup)); }
                        }
                    }
                    else { $failedUsers[] = $newParticipant; }
                }
            }

	    if (!$_POST['name']) { $name= "[untitled event]";}
            else { $name = $_POST['name']; }
        
            // update the problem
            updateProblem($problem, $name, $_POST['description'], $_POST['expiration_time'], $_POST['status'], $_POST['type']);
            
            // construct the JSON output
            $string = '{"id":' . $problem . ',';
            
            if (!empty($addedUsers)) { // report the added users
                $string .= '"added":[';
                foreach ($addedUsers as $addedUser) {
                    $string .= '[' . $addedUser[0] . ',"' . $addedUser[1] . '"],';
                }
                $string = substr($string,0,-1) . '],';
            }
            
            if (!empty($duplicateUsers)) { // report the duplicate users
                $string .= '"duplicate":[';
                foreach ($duplicateUsers as $duplicateUser) {
                    $string .= '"' . $duplicateUser . '",';
                }
                $string = substr($string,0,-1) . '],';
            }
            
            if (!empty($failedUsers)) { // report the failed users
                $string .= '"failed":[';
                foreach($failedUsers as $failedUser) {
                    $string .= '"' . $failedUser . '",';
                }
                $string = substr($string,0,-1) . '],';
            }
            
            $string = substr($string,0,-1) . '}';
            echo $string;
            break;

        case "update_problem_comment":
            updateProblemComment($_POST['problem'], $_POST['comment']);
            echo '{"out":0}';
            break;
        
        case "delete_problem":
            
            // check to make sure the user is allowed to do this

            deleteProblem($_POST['problem']); 
	    echo '{"out":0}';
            break;
            
        case "archive_problem":         
            archiveProblem($_POST['problem'], $_POST['user']);
            echo '{"out":0}';
            break;

        case "unArchive_problem":         
            unArchiveProblem($_POST['problem'], $_POST['user']);
            echo '{"out":0}';
            break;

        case "update_group":

            // check to see if user is logged in and if they are the admin of the group that they are updating

            $JSON_output = '';
            $updateResponse = updateGroup($_POST['group'], $_POST['name'], $_POST['description'], $_POST['type']); // maybe add group id as a parameter

            if ($_POST['group'] && !$updateResponse) { // a name error, the existing group has the same name as another group or user
                $group = $_POST['group'];
                $groupSearch = getGroupByID($group);
                $JSON_output .= '"nameError":1, "name":"' . $groupSearch['name'] .'",';
            }
            else if (!$_POST['group'] && $updateResponse == 0) { // a name error, the new group has the same name as another group or user
                echo '{"nameError":1, "name":""}';
                return;
	    }
            else { // otherwise, just set the group to the returned id
                $group = $updateResponse;
                $JSON_output .= '"nameError":0,';
            }

            // set the admin
            addAdminToGroup($current_user, $group);

            $JSON_output .= '"id":' . $group . ','; 

            $newParticipants = splitOnNewLines($_POST['newParticipants']);
            if ($_POST['removeParticipants']) { $removeParticipants = explode(" ", $_POST['removeParticipants']); }
            else { $removeParticipants = array(); }

            $removedUsers = array();  
            $addedUsers = array();
            $failedUsers = array();
            $duplicateUsers = array();

            // remove the unchecked participants
            foreach ($removeParticipants as $removeParticipant) {
                removeParticipantFromGroup($removeParticipant, $group);
            }

            // add the new participants
            foreach ($newParticipants as $newParticipant) {
                $user = getUserByName($newParticipant);
                if ($user) {
                    if (addParticipantToGroup($user['id'], $group) == 1) { $duplicateUsers[] = $newParticipant; }
                    else { $addedUsers[] = array($user['id'], getNameString($user)); }
                }
                else { // add a group
                    $groupToAdd = getGroupByName($newParticipant);
                    if ($groupToAdd != 0 && canUseGroup($groupToAdd['id'], $current_user)) {
                        $usersForGroup = getParticipantsForGroup($groupToAdd['id']);
                        foreach ($usersForGroup as $userForGroup) {
                            if ($userForGroup['isParticipant'] != 2) { continue; }
                            if (addParticipantToGroup($userForGroup['id'], $group) == 1) { $duplicateUsers[] = $userForGroup['name']; }
                            else { $addedUsers[] = array($userForGroup['id'], getNameString($userForGroup)); }
                        }
                    }
                    else { $failedUsers[] = $newParticipant; }
                }
            }

            if (!empty($addedUsers)) { // report the added users
                $JSON_output .= '"added":[';
                foreach ($addedUsers as $addedUser) {
                    $JSON_output .= '[' . $addedUser[0] . ',"' . $addedUser[1] . '"],';
                }
                $JSON_output = substr($JSON_output,0,-1) . '],';
            }

            if (!empty($duplicateUsers)) { // report the duplicate users
                $JSON_output .= '"duplicate":[';
                foreach ($duplicateUsers as $duplicateUser) {
                    $JSON_output .= '"' . $duplicateUser . '",';
                }
                $JSON_output = substr($JSON_output,0,-1) . '],';
            }
            
            if (!empty($failedUsers)) { // report the failed users
                $JSON_output .= '"failed":[';
                foreach($failedUsers as $failedUser) {
                    $JSON_output .= '"' . $failedUser . '",';
                }
                $JSON_output = substr($JSON_output,0,-1) . '],';
            }
            
            $JSON_output = '{' . substr($JSON_output,0,-1) . '}';

            echo $JSON_output;
            break;

        case "delete_group":
            if (deleteGroup($_POST['group']) == 0) { echo '{"out":0}'; }
            else { echo '{"out":1}'; }
            break;

        case "group_request":
            addParticipantToGroup($_POST['user'], $_POST['group'], 1);
            $out = sendGroupRequestEmail($_POST['user'], $_POST['group']);
            echo '{"out":' . $out . '}';
            break;
               
        case "group_approve":
            addParticipantToGroup($_POST['user'], $_POST['group']);
            echo '{"out":0}';
            break;
   
        case "group_ignore":
            removeParticipantFromGroup($_POST['user'], $_POST['group']);
	    echo '{"out":0}';
            break;
   
        case "notify_participants":
            $out = sendAddedNotificationEmail($_POST['problem']);
            echo '{"out":' . $out . '}';
            break;

        case "notify_participants_posted":
            $out = sendPostedNotificationEmail($_POST['problem']);
            echo '{"out":' . $out . '}';
            break;

        case "status":
            // if ($current_user == $admin) then we can do this action
            setProblemStatus($_POST['problem'], $_POST['status']);
            break;

        case "login": // make it so if you are an active user, the cookie will not expire
            $user = getUserByName($_POST['user']);
	    if ($user['activated'] == 1) {
	      $pw = encryptPassword($_POST['password']);
	      if (!(empty($user))) {
                if ($user['password'] == $pw) {
		  setcookie("user", $user['id'], time()+100000);
		  echo '{"out":0}';
                }
                else {
		  echo '{"out":1}';
                }
	      }
	      else { echo '{"out":1}'; }
	    }
	    else {echo '{"out":2}';}
	    break;

        case "update_password":
            $user=$_COOKIE['user'];
            $oldPass=encryptPassword($_POST['oldpass']);
            $newPass=encryptPassword($_POST['newpass']);
            $rnewPass=encryptPassword($_POST['rnewpass']);
            if (checkPassword($oldPass, $user)) {
                if (confirmPassword($newPass, $rnewPass)) {
                    setPassword($newPass,$user);
                    echo'{"out":0}';
                }
                else {
                    echo'{"out":2}';
                }
            
            }
            else { echo '{"out":1}'; }
            break;
	    
        case "authenticate":
	  $user=$_POST['user'];
	  $activated = getActivatedByName($user);
	  if ($activated == 1) {
	    echo '{"out":1}';
	  }
	  else if ($activated == 0) {
	    activateUser($user);
	    echo '{"out":0}';
	  }
	  else if ($activated == -1) {
	    echo '{"out":-1}';
	  }
	  break;
        case "reset_password":
	  $user =$_POST['user'];
	  $activated = getActivatedByName($user);
	  if ($activated == 1) {
	    emailNewPasswordByName($user);
	    echo '{"out":1}';
	  }
	  else {
	    echo '{"out":0}';
	  }
	  break;
        

        default:
            echo '{"error":1}';
            break;
    }


}
else { echo '{"error":1}'; }
?>
