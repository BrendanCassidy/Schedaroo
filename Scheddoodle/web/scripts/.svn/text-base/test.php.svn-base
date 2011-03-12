<?php
include_once "/Accounts/scheddoodle/sched-doodle/web/includes/config.inc";
include_once "/Accounts/scheddoodle/sched-doodle/web/includes/functions.php";
$problems = getClosingProblems();

foreach ($problems as $problem) {
$algorithm = getAlgorithmById($problem['algorithm']);

$participants = getParticipantsForProblem($problem['id']);
$to = "elfmanw@carleton.edu";
}

$headers = 'From: emailtest';
$body = 'this is a test';
$subject = 'test';
mail($to, $subject, $body, $headers);

?>


