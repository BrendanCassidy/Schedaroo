<?php

# UPDATE PREFERENCES

function updatePreferences($problem, $user, $preference) {

    $problem = getProblemById($problem);

    if (!isUserInProblem($user, $problem['id']) && $problem['type'] == "public")  {
        addUserToProblem($problem['id'], $user);
    }

    // check to see if another user took the preference before the requesting user submitted the form
    $query = "SELECT * FROM `data` WHERE problem=" . $problem['id'] . " AND user!=$user AND k='preference' AND v='" . $preference[0] . "'"; // change this to use getData
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) { return 1; }
    else { addData($problem['id'], $user, 'preference', $preference[0], 1); return 0; }
}

# MISC

// returns an array of preferences for a participant
function getPreferencesForParticipant($problem, $user) {
  $result = mysql_query("SELECT * FROM data WHERE problem=$problem AND user=$user AND k='preference'");
  $row = mysql_fetch_array($result);
  return preg_split('[\r\n|\n|\r]', $row['v']);
}

// returns an array of every user's preferences to a particular problem.id
function getAllPreferences($problem) { // change this to get all preferences
  $rows = array();
  $participants = getParticipantsForProblem($problem);
  foreach ($participants as $participant) {
    $preference = getPreferencesForParticipant($problem, $participant['id']);
    if ($preference[0]) { $participant['preference'] = $preference; }
    else { $participant['preference'] = array(); }
    $rows[] = $participant;
  }
  return $rows;
}

function getPreference($problem, $user) {
    $result = mysql_query("SELECT * FROM data WHERE problem=$problem AND user=$user AND k='preference'");
    $row = mysql_fetch_array($result);
    return $row['v'];
}

// returns an array of every user's preferences to a particular problem.id
function getPreferences($problem) {
    $preferences = array();
    $query = "SELECT * FROM data WHERE problem=$problem AND k='preference'";
    $result = mysql_query($query);
    while ($preference = mysql_fetch_array($result)) { $preferences[] = $preference; }
    return $preferences;
}

// returns a resource object for a participant
function getPreferenceForParticipant($problem, $user) {
  $result = mysql_query("SELECT * FROM data WHERE problem=$problem AND user=$user AND k='preference'");
  $row = mysql_fetch_array($result);
  return getResourceById($problem, $row['v']);
}

// returns a list of all participants and resources and their matchings
function getAssignments($problem) {
  $assignments = array();
  $usedResources = array();
  $unassignedUsers = array();  

  $participants = getParticipantsForProblem($problem);
  foreach ($participants as $participant) {
      $assignment = getPreferenceForParticipant($problem, $participant['id']);
      if (!$assignment) { $unassignedUsers[] = $participant['id'];}
      else {
         $usedResources[$assignment['id']] = 1; 
         $assignments[] = array("participant" => $participant['id'], 'assignment' => $assignment['name'], 'id' => $assignment['id']);
     }
  }
  
  $resources = getAllResources($problem);

  foreach ($resources as $resource) {
      if (!isset($usedResources[$resource['id']])) {
	$assignments[] = array("participant" => 0, "assignment" => $resource['name'], "id" => $resource['id']);
      }
  }
  
  return array($assignments, $unassignedUsers);

}

// returns an array of all resources
function getAllResources($problem) {    
    $query = sprintf("SELECT * FROM data WHERE problem=%d AND user=0  AND k='resources'", $problem);
    $result = mysql_query($query);
    $resources = mysql_fetch_array($result);
    if (!$resources || $resources == "") { return array(); }
    else {
        $resources = preg_split('[\r\n|\n|\r]', $resources['v']);
        $rows = array();
    
        foreach ($resources as $resource) {
            if ($resource == "") { continue; }
            $resource = preg_split('[::]', $resource);
            $rows[] = array('id' => $resource[0], 'name' => $resource[1]);  
        }
        return $rows;
    }
}

/*
 * returns an array of user ids index by the resource id
 */
function getUsedResources($problem) {
    $resources = array();
    $preferences = getPreferences($problem);
    foreach ($preferences as $preference) {
        if ($preference['v'] != NULL || $preference['v'] != '') {
            $resources[$preference['v']] = $preference['user'];
        }
    }
    return $resources;
}

// returns a resource based on its ID
function getResourceById($problem, $resourceID) {
  $resources = getAllResources($problem);
  foreach ($resources as $resource) {
    if ($resource['id'] == $resourceID) { return array('id' => $resourceID, 'name' => $resource['name']); }
  }
  return null;
}

// swaps an assignment for first come first serve
function swapAssignmentsFCFS($problem, $user1, $resource1, $user2, $resource2) {
   if ($user1 && $user2) {
        addData($problem, $user1, 'preference', $resource2, 1);
        addData($problem, $user2, 'preference', $resource1, 1);
    }

  else if (($user1 && !$user2) || !$resource1) {
      addData($problem, $user1, 'preference', $resource2 , 1);
    }

  else if ((!$user1 && $user2) || !$resource2) {
      addData($problem, $user2, 'preference', $resource1, 1);
    }
}  

// unassigns a participant
function unassignParticipantFCFS($problem, $user) {
  addData($problem, $user, 'preference', 0, 1);
}


?>