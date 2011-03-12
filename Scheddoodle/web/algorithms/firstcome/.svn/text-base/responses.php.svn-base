<?php
include_once '../../includes/config.inc';
include_once PATH . '/includes/header.inc';
include_once 'functions.php';

checkPermissions();

if (!(isset($_GET['problem']))) { die("no problem specified"); }

$problem = getProblemById($_GET['problem']);

checkAllowedViewResponses($problem);
list($assignments, $unassignedUsers) = getAssignments($problem['id']);

?>
<link rel="stylesheet" type="text/css" href="style.css">

<?php include_once PATH . '/includes/body.inc' ?>

<h1><?php echo $problem['name'] ?></h1>
<p><?php echo $problem['description'] ?></p>

<h2>Responses So Far:</h2>
<div style="width:100%;margin-left:auto;margin-right:auto;overflow:auto;">

<table id="responseTable">
<tr><td>User</td><td>Choice</td></tr>

<?php

foreach ($assignments as $assignment) {
    if ($assignment['participant']) { $participant = getUserById($assignment['participant']); }
    else { $participant['name'] = "--"; }
    
    if (!$assignment['assignment']) { $assignment['assignment'] = "[untitled]"; }

    if ($participant['id'] == $current_user) {
        echo '<tr style="background:#738AE1;"><td><b>' . $participant['name'] . '</td><td>' . $assignment['assignment'] . "</b></td></tr>\n";
    }
    else {
        echo '<tr><td>' . $participant['name'] . '</td><td>' . $assignment['assignment'] . "</td></tr>";
    }
}

foreach ($unassignedUsers as $unassignedUser) {
    $user = getUserById($unassignedUser);
    echo '<tr><td>' . $user['name'] . "</td><td>--</td></tr>";
}

echo '</table>';

?>

</div>
<div id="back button" style="text-align:center">
<br>
<input type="button" value="Back to My Events" onclick="window.location='../../problems.php'">
</div>
<?php include_once '../../includes/footer.inc' ?>
