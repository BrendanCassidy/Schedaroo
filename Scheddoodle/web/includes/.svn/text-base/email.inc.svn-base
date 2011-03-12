<?php

########################################################################
## EMAIL
########################################################################

function sendAllRespondedEmail($problem) {

    $problem = getProblemById($problem);
    if ($problem['type'] == "public") { return 2; }

    $admins = getAdminsForProblem($problem['id']);

    $to = '';
    foreach($admins as $admin) {
      $to .= $admin['name'] . ',';
    }
    $to = substr($to, 0, -1);

    if ($to == "") { return 0; }
   
    $headers = "From: Schedaroo <schedaroo@carleton.edu>";
    $subject = "Schedaroo Notice: " . $problem['name'];
   
    $body = "All Participants have responded to " . strtoupper($problem['name']) . "\n\n"
       . "GO TO SCHEDAROO TO SCHEDULE THIS EVENT\n"
       . URL . "/run.php?problem=" . $problem['id'];

    if (mail($to, $subject, $body, $headers)) { return 0; }
    else { return 1; }

}

function sendGroupRequestEmail($user, $group) {
    
    $group = getGroupByID($group);
    $user = getUserById($user);
    
    $admins = getAdminsForGroup($group['id']);
    
    $to = '';
    foreach ($admins as $admin) {
        $to .= $admin['name'] . "@carleton.edu,";
    }
    $to = substr($to, 0, -1);
    
    $headers = "From: Schedaroo Groups <schedaroo@carleton.edu>";
    $subject = "Schedaroo Group Request";
    
    $body = strtoupper($user['name']) . " has requested to be in the group: " . strtoupper($group['name']) . "\n\n\nFollow this link to add " . $user['name'] . " to the group\n\n"
    . URL . "/group.php?group=" . $group['id'];
    
    if (mail($to, $subject, $body, $headers)) { return 0; }
    else { return 1; }
}

function sendAddedNotificationEmail($problem) {

    $problem = getProblemById($problem);

    $participants = getParticipantsForProblem($problem['id'], 0); // the 0 means that we are getting users who have not responded
    
    $to = '';
    foreach ($participants as $participant) {
        $to .= $participant['name'] . "@carleton.edu,";
    }
    $to = substr($to, 0, -1);
    
    if ($to == "") { return 0; }

    $adminText = '';
    $admins = getAdminsForProblem($problem['id']);
    foreach ($admins as $admin) {
      $adminText .= $admin['name'] . ', ';
    }
    $adminText = substr($adminText, 0, -2);

    $headers = "From: Schedaroo <schedaroo@carleton.edu>";
    $subject = "Schedaroo Event Request from " . $admin['name'];
    
    $body = strtoupper($adminText) . " HAS ADDED YOU TO AN EVENT\n\n"
    . "NAME\n--------------------\n" . strtoupper($problem['name']) . ".\n\n"
    . "DESCRIPTION\n--------------------\n" .  $problem['description'] . "\n\n"
    . "GO TO SCHEDAROO TO RESPOND\n"
    . URL . "/respond.php?problem=" . $problem['id'];
    
    if (mail($to, $subject, $body, $headers)) { return 0; }
    else { return 1; }
}

function sendPostedNotificationEmail($problem) {

    $problem = getProblemById($problem);
    $users = getParticipantsForProblem($problem['id']);
    
    $to = '';
    foreach ($users as $user) {
        $to .= $user['name'] . "@carleton.edu,";
    }
    $to = substr($to, 0, -1);

    if ($to == "") { return 0; }

    $adminText = '';
    $admins = getAdminsForProblem($problem['id']);
    foreach ($admins as $admin) {
      $adminText .= $admin['name'] . ', ';
    }
    $adminText = substr($adminText, 0, -2);
    
    $headers = "From: Schedaroo <schedaroo@carleton.edu>";
    $subject = "Schedaroo Event Notification from " . $admin['name'];
    
    $body = strtoupper($adminText) . " HAS POSTED THE DATE OF AN EVENT\n\n"
    . "NAME\n--------------------\n" . strtoupper($problem['name']) . ".\n\n"
    . "COMMENTS FROM ADMINISTRATOR\n--------------------\n" .  $problem['comment'] . "\n\n"
    . "GO TO SCHEDAROO TO VIEW THE EVENT DETAILS\n"
    . URL . "/view.php?problem=" . $problem['id'];
    
    if (mail($to, $subject, $body, $headers)) { return 0; }
    else { return 1; }

}

?>