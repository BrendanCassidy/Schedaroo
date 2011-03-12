<?php

// returns an array of every user's preferences to a particular problem.id
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

?>