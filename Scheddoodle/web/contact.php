<?php
include_once 'includes/config.inc';
include_once 'includes/header.inc';
include_once 'includes/body.inc';
?>

<?php
$to = "elfmanw@carleton.edu";
$subject = "Test";
$body = "This is a test";
$headers = 'From: scheddoodle <scheddoodle@carleton.edu>';
if (mail($to, $subject, $body, $headers)) {
  echo("<p>Message successfully sent!</p>");
} else {
  echo("<Message delivery failed...</p>");
  }
?>

<?php include_once 'includes/footer.inc' ?> 
