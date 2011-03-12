<?php

include_once "includes/config.inc";

$algorithm = getAlgorithmFromProblem($_GET['problem']);

header("Location: algorithms/" . $algorithm['slug'] . "/respond.php?problem=" . $_GET['problem']);

?>