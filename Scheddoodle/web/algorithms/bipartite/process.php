<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

if (!(isset($_POST['action']))) {
  die("no action specified");
}

switch ($_POST['action']) {
 case "respond":
   updatePreferences($_POST['problem'], $_POST['user'], $_POST['resources']);
   markResponded($_POST['problem'], $_POST['user']);
   if (allHaveResponded($_POST['problem'])) {
      sendAllRespondedEmail($_POST['problem']); // do some error checking
   }
   header('Location: ' . URL . '/problems.php'); // display a message as to which problem was updated
   break;

 case "edit_problem_structure":
   addData($_POST['problem'], 0, 'resources', $_POST['data'], 1);
   header('Location: ' . URL . '/problems.php');
   break; // need to make sure if we remove a slot, we also get rid of user's preference for it

 default:
   echo "not a valid aciton";
   break;
 }

?>