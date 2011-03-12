<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

if (isset($_POST['action'])) {
  switch ($_POST['action']) {

  case "saveContractedHours":
    addData($_POST['problem'], $_POST['participant'], 'contractedHours', $_POST['hours'], 1);
    echo '{"out":0}';
    break;

  default:
    echo '{"out":1}';
    break;
  }
 }

 else { echo '{"out":2}'; }

?>