<?php

define("URL", "http://cs-research1.mathcs.carleton.edu/scheddoodle/sched-doodle/web"); // it takes a bit longer to load data from urls, but it is okay
define("PATH", "/Accounts/scheddoodle/sched-doodle/web");

date_default_timezone_set("GMT");

if (isset($_COOKIE['user'])) { $current_user = $_COOKIE['user']; }

include_once '/usr/apache/files-with-passwords/scheddoodle.inc';
include_once PATH . '/includes/functions.php';
include_once PATH . '/includes/interface.inc';

// fix file paths, create a variable that has a path to the testing directory



if (isset($_GET['problem'])) { // if a problem is specified, get its specific functions
        $algorithm = getAlgorithmFromProblem($_GET['problem']);
	//        include_once '/Accounts/scheddoodle/sched-doodle/web/algorithms/' . $algorithm['slug'] . '/functions.php';
}

else if (isset($_POST['problem'])) { // if a problem is specified, get its specific functions
        $algorithm = getAlgorithmFromProblem($_POST['problem']);
	//        include_once '/Accounts/scheddoodle/sched-doodle/web/algorithms/' . $algorithm['slug'] . '/functions.php';
}


?>
