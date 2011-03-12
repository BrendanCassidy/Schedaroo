<?php

########################################################################
## GROUPS
########################################################################

/*
 * inputs: groupID, groupName, groupDescription, groupType
 * returns the groupID on success
 * returns 0 on failure
 */
function updateGroup($group, $name, $description, $type) {
    $name = sanitize($name);
    $description = sanitize($description);
    
    if (getUserByName($name)) { return 0; } // we cannot have a group with the same name as a user

    $groupSearch = getGroupByName($name);
    if (!$group && $groupSearch) { return 0; } // cannot name a group the same name as another group
    else if ($group && $groupSearch && $groupSearch['id'] != $group) {  // we cannot rename a group to the name of another group so update the other stuff
        $query = sprintf("UPDATE `groups` SET description='%s', type='%s' WHERE id=%d", $description, $type, $group);
        mysql_query($query);
        return 0;
    }

    if ($group != 0) { // if we have a groupID, update the group
        $query = sprintf("UPDATE `groups` SET name='%s', description='%s', type='%s' WHERE id=%d", $name, $description, $type, $group);
        mysql_query($query);
        return $group;
    }
    else { // otherwise add the group
        $query = sprintf("INSERT INTO `groups` (`name`, `description`, `type`) VALUES ('%s', '%s', '%s')", $name, $description, $type);
        mysql_query($query);
        return mysql_insert_id();
    }
}

// returns a group object as identified by its id
function getGroupByID($id) {
    $result = mysql_query("SELECT * FROM `groups` WHERE id=$id");
    return mysql_fetch_array($result);
}

// returns a group object as identified by its name
function getGroupByName($name) {
    $name = sanitize($name);
    $query = sprintf("SELECT * FROM `groups` WHERE name='%s'", $name);
    $result = mysql_query($query);
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 1) {
        return mysql_fetch_array($result);
    }
    else if ($num_rows == 0) { // return 0 if we cannot find the group
        return 0;
    }
    else {
        echo "error: getGroupByName(): more than one group have the same name";
        return 0;
    }
}

// deletes a group
function deleteGroup($group) {
    mysql_query("DELETE FROM `groups` WHERE id=$group");
    mysql_query("DELETE FROM `user2group` WHERE groupID=$group");
    return 0;
}

// returns an array of all groups
function getAllGroups() {
    $rows = array();

    $result = mysql_query("SELECT * FROM `groups`");
    while ($row = mysql_fetch_array($result)) {
        $rows[] = $row;
    }
    return $rows;
}

########################################################################
## GROUP PARTICIPATION
########################################################################

// returns 0 on success, 1 if there is an error like the user already being a part of the group
function addParticipantToGroup($user, $group, $pending=0) {
    $query = sprintf("SELECT * FROM `user2group` WHERE userID=%d AND groupID=%d", $user, $group);
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    if (!$pending) { $value = 2; } // if we have not set an isParticipant value, set it to 2, which means they are in the group (1 means they are pending)
    else { $value = 1; }

    if (!$row) {
        $insertQuery = sprintf("INSERT INTO `user2group` (`userID`, `groupID`, `isParticipant`) VALUES (%d, %d, %d)", $user, $group, $value);
        mysql_query($insertQuery);
        return 0;
    }
    else if ($row['isParticipant'] == 2) { return 1; }
    else {
        $updateQuery = sprintf("UPDATE `user2group` SET isParticipant=%d WHERE userID=%d AND groupID=%d", $value, $user, $group);
        mysql_query($updateQuery);
        return 0;
    }
}

// returns 0 on success, 1 if there is an error like the user already being a part of the group
function addAdminToGroup($user, $group) {
    $query = sprintf("SELECT * FROM `user2group` WHERE userID=%d AND groupID=%d", $user, $group);
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    if (!$row) {
        $insertQuery = sprintf("INSERT INTO `user2group` (`userID`, `groupID`, `isAdmin`) VALUES (%d, %d, 1)", $user, $group);
        mysql_query($insertQuery);
        return 0;
    }
    else if ($row['isAdmin']) { return 1; }
    else {
        $updateQuery = sprintf("UPDATE `user2group` SET isAdmin=1 WHERE userID=%d AND groupID=%d", $user, $group);
        mysql_query($updateQuery);
        return 0;
    }
}

// removes a participant from a group
function removeParticipantFromGroup($user, $group) {
    $query = "SELECT * FROM `user2group` WHERE userID=$user AND groupID=$group";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    if ($row && $row['isAdmin']) { // if the participant is an admin, we do not want to delete them
        mysql_query("UPDATE `user2group` SET isParticipant=0 WHERE userID=$user AND groupID=$group");
        return 0;
    }
    else { // if the user is just a participant, we can remove their row entirely
        mysql_query("DELETE FROM `user2group` WHERE userID=$user AND groupID=$group");
        return 0;
    }
}

// removes an admin from a group
function removeAdminFromGroup($user, $group) {
    $query = "SELECT * FROM `user2group` WHERE userID=$user AND groupID=$group";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    if ($row && $row['isParticipant']) { // if the admin is a participant, we do not want to delete them
        mysql_query("UPDATE `user2group` SET isAdmin=0 WHERE userID=$user AND groupID=$group");
        return 0;
    }
    else { // if the user is just an admin, we can remove their row entirely
        mysql_query("DELETE FROM `user2group` WHERE userID=$user AND groupID=$group");
        return 0;
    }
}

// gets all users who are related to a group in some way
function getParticipantsForGroup($group) {
    $result = mysql_query("SELECT * FROM `user2group` WHERE groupID=$group AND isParticipant!=0");
    $participants = array();
    while ($row = mysql_fetch_array($result)) {
        $participant = getUserById($row['userID']);
        $participant['isParticipant'] = $row['isParticipant'];
        $participant['isAdmin'] = $row['isAdmin'];
        $participants[] = $participant;
    }
    return $participants;
}

// gets all users who are related to a group in some way
function getAdminsForGroup($group) {
    $result = mysql_query("SELECT * FROM `user2group` WHERE groupID=$group AND isAdmin=1");
    $admins = array();
    while ($row = mysql_fetch_array($result)) {
        $admin = getUserById($row['userID']);
        $admin['isParticipant'] = $row['isParticipant'];
        $admin['isAdmin'] = $row['isAdmin'];
        $admins[] = $admin;
    }
    return $admins;
}

function getGroupsForUser($user) {
    $result = mysql_query("SELECT * FROM `user2group` WHERE userID=$user");
    $groups = array();
    while ($row = mysql_fetch_array($result)) {
        $group = getGroupByID($row['groupID']);
        $group['isAdmin'] = $row['isAdmin'];
        $group['isParticipant'] = $row['isParticipant'];
        $groups[] = $group;
    }
    return $groups;
}

function isParticipantInGroup($user, $group) {
    $result = mysql_query("SELECT * FROM `user2group` WHERE groupID=$group AND userID=$user");
    $row = mysql_fetch_array($result);
    if ($row && $row['isParticipant']) { return $row['isParticipant']; }
    else { return 0; }
}

function isAdminInGroup($user, $group) {
    $result = mysql_query("SELECT * FROM `user2group` WHERE groupID=$group AND userID=$user");
    $row = mysql_fetch_array($result);
    if ($row && $row['isAdmin']) { return $row['isAdmin']; }
    else { return 0; }
}

//In order to speed up isUserInGroup we should create a table (or a column in the users table) listing all groups that user is in.
//Similarly, we could have a table with one row for each group, listing all users in that group.

########################################################################
## GROUP PERMISSIONS
########################################################################

// returns 1 if user has permission to use group
function canUseGroup($group, $user) {
    $group = getGroupByID($group);
    if ($group['type'] == "public") { return 1; }
    else if ($group['type'] == "admin" && isAdminInGroup($user, $group['id'])) { return 1; }
    else if ($group['type'] == "private" && isParticipantInGroup($user, $group['id'])) { return 1; }
    else { return 0; }
}

########################################################################
## SORT GROUPS FUNCTIONS
########################################################################

function sortGroupsByRelevance($groups, $user) {
    return sortGroupsByAdminParticipant($groups, $user);
}

function sortGroupsByAdminParticipant ($groups, $user) {
  $adminParticipant = array();
  $admin = array();
  $participant = array();
  $neither = array();
  $groups = array_reverse($groups); // reverse order so that appending later maintains order within categories
  foreach ($groups as $group) {
    if (isAdminInGroup($user, $group['id'])) {
      if (isParticipantInGroup($user, $group['id'])) {
	$adminParticipant[] = $group;
      }
      else {
	$admin[] = $group;
      }
    }
    else {
      if (isParticipantInGroup($user, $group['id'])) {
	$participant[] = $group;
      }
      else {
	$neither[] = $group;
      }
    }
  }
  return array_merge($adminParticipant, $admin, $participant, $neither);
}

?>