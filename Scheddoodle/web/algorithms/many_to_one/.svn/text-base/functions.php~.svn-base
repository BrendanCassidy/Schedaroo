<?php

# MAX COL INDEX / IMPORTANCE

// returns the max_col_index
function getMaxColIndex($problem) {
    $data = getData($problem, 0, 'max_col_index');
    return $data['v'];
}

// gets a user's priority
function getImportanceForParticipant($problem, $user) {
    $data = getData($problem, $user, 'importance');
    return $data['v'];
}

## PREFERENCES

// returns an array of user preferences
function getPreferencesForParticipant($problem, $user) {
    $result = mysql_query("SELECT * FROM data WHERE problem=$problem AND user=$user AND k='preference'");
    $preferences = mysql_fetch_array($result);
    $preferences = preg_split('[\r\n|\n|\r]', $preferences['v']);
    return $preferences;
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

// updates a user's preferences after proboems.php
function updatePreferencesForParticipant($problem, $user, $resources) {
    $problem = getProblemById($problem);
    if (!isUserInProblem($user, $problem['id']) && $problem['type'] == "public")  {
        addUserToProblem($problem['id'], $user);
    }
    $preferences = ''; // initialize preferences string
    foreach ($resources as $resource) {
        $preferences .= $resource . "\n"; // add the ids to the preference list for that user
    }
    $preferences = substr($preferences, 0, -1); // take off the last new line
    addData($problem['id'], $user, 'preference', $preferences, 1); // 1 means update or add
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

// returns a resource based on its ID
function getResourceById($problem, $resourceID) {
    $resources = getAllResources($problem);
    foreach ($resources as $resource) {
        if ($resource['id'] == $resourceID) { return $resource['name']; }
    }
    return 0;
}

?>