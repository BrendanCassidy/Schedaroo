<?php

include_once "/Accounts/scheddoodle/sched-doodle/web/includes/config.inc";

    $problems = getClosingProblems();

    foreach ($problems as $problem) {

    $algorithm = getAlgorithmById($problem['algorithm']);

    $to = ''; 
    $participants = getParticipantsForProblem($problem['id']);
    foreach ($participants as $participant) {
        $to .= $participant['name'] . "@carleton.edu,";
    }
    $to = substr($to, 0, -1);

    $headers = "From: Scheddoodle <scheddoodle@carleton.edu>";
    $subject = "Scheddoodle Notice: " . $problem['name'];

    $body = "You have less than 24 hours to input your preferences for the event: " . strtoupper($problem['name']) . "\n\n"
       . "GO TO SCHED-DOODLE TO INPUT YOUR PREFERENCES\n"
       . URL . "/algorithms/" . $algorithm['slug'] . "/respond.php?problem=" . $problem['id'];

    if (mail($to, $subject, $body, $headers)) { return 0; }
    else { return 1; }
}
?>



