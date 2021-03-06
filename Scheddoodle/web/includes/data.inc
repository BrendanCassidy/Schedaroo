<?php

########################################################################
## DATA FUNCTIONS 
########################################################################

/*
 * addData function:
 * update = 0: just insert the data without checking to see if it already exists
 * update = 1: if we find the data, update it and return; otherwise, add it
 * update = 2: if we find the data, do not update it and return; otherwise add it
 */

function addData($problem, $user, $key, $value, $update = 0) {
    $value = sanitize($value);
    switch ($update) {
        case 1:
            $result = mysql_query("SELECT * FROM data WHERE problem = $problem AND user = $user AND k = '$key'");
            if (mysql_num_rows($result) == 1) {
                $query = sprintf("UPDATE `data` SET v='%s' WHERE problem=$problem AND user=$user AND k='%s'", $value, $key);
                mysql_query($query);
                return 1;
            }
            break; //Just in case.
            
        case 2:
            $result = mysql_query("SELECT * FROM data WHERE problem = $problem AND user = $user AND k = '$key'");
            if (mysql_num_rows($result) == 1) {
                return 2;
            }
            break;
    }
    
    $query = sprintf("INSERT INTO `data` (`problem`, `user`, `k`, `v`) VALUES ('$problem', '$user', '%s', '%s')", $key, $value);
    mysql_query($query);
    return 0;
}

function updateData($problem, $user, $key, $value) { // maybe get rid of this function? delete this for sure. we are migrating to addData
    echo "do not user this function!!! update data";
    $query = sprintf("UPDATE `data` SET v='%s' WHERE problem=$problem AND user=$user AND k='%s'", $value, $key);
    mysql_query($query);
}

function getData($problem, $user, $key) {
    $query = sprintf("SELECT * FROM `data` WHERE problem=%s AND user=%s AND k='%s'", $problem, $user, $key);
    $result = mysql_query($query);
    return mysql_fetch_array($result);
}

function getRawData($problem, $user, $key) {
  $query = sprintf("SELECT * FROM `data` WHERE problem =%s AND user=%s AND k='%s'", $problem, $user, $key);
  $result = mysql_query($query);
  return $result;
}

?>