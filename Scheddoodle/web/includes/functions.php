<?php

########################################################################
## FUNCTIONS.PHP
########################################################################

include_once 'algorithms.inc';  // functions related to algorithms table
include_once 'problems.inc';    // functions related to problems and user2problem tables
include_once 'data.inc';        // functions related to data table
include_once 'users.inc';       // functions related to the users table
include_once 'groups.inc';      // functions related to the groups table
include_once 'email.inc';       // functions related to email
include_once 'permissions.inc'; // functions related to permissions


########################################################################
## ASSIGNMENT FUNCTIONS -- move all this into BPM
########################################################################

//Checks to see if the problem has been run previously.
function checkForAssignment($problem) {
  $query = sprintf("SELECT * FROM `data` WHERE problem=%s AND k='assignment'", $problem);
  $result = mysql_query($query);
  //return mysql_fetch_array($result);
  if (mysql_num_rows($result)) {
    return true;
  }
  return false;
}

function isAssigned($problem, $user) {
  $query = sprintf("SELECT * FROM `data` WHERE problem = %s AND k='assignment' AND user=%s", $problem, $user);
  $result = mysql_query($query);
  if (mysql_num_rows($result)) { return true;}
  else {return false;}
}

function unassignParticipant($problem, $user) {
  addData($problem, $user, 'assignment', 0 , 1);
}

function swapAssignments($problem, $user1, $resource1, $user2, $resource2) {
   if ($user1 && $user2) {
        addData($problem, $user1, 'assignment', $resource2, 1);
        addData($problem, $user2, 'assignment', $resource1, 1);
    }

  else if (($user1 && !$user2) || !$resource1) {
      addData($problem, $user1, 'assignment', $resource2 , 1);
    }

  else if ((!$user1 && $user2) || !$resource2) {
      addData($problem, $user2, 'assignment', $resource1, 1);
    }
}  


########################################################################
## SANTITIZATION FUNCTIONS
########################################################################

function sanitize($data) {
    // remove whitespaces (not a must though)
    $data = trim($data);
    
    // convert special html characters
    $data = htmlspecialchars($data);

    // apply stripslashes if magic_quotes_gpc is enabled
    if (get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }
    
    // a mySQL connection is required before using this function
    $data = mysql_real_escape_string($data);
    
    return $data;
}

########################################################################
## MISCELLANEOUS FUNCTIONS
########################################################################

function splitOnNewLines($text) {
    $new = preg_split('[\r\n|\n|\r]', $text);
    if ($new[0] == "") { return array(); } // we used to return NULL, but that is not an array
    else { return $new; }
}



?>
