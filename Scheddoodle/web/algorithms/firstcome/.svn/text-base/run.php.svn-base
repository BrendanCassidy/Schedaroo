<?php

include_once '../../includes/config.inc'; // add a wrapper so we do not have to use relative path
include_once 'functions.php';

checkPermissions();

include_once PATH . '/includes/header.inc';

if (!isset($_GET['problem'])) { die("no problem specified"); }
$problem = getProblemById($_GET['problem']);
checkAllowedEdit($problem);

// close the problem if it is open
$status = getProblemStatus($problem['id']);
//if ($status == "open" || $status == "timed") { setProblemStatus($problem['id'], "closed"); $status = "closed"; }

?>

<script type="text/javascript" src="<?php echo URL ?>/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo URL ?>/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="run.js"></script>
<link rel="stylesheet" type="text/css" href="runStyle.css">



<?php include_once '../../includes/body.inc' ?>

<h1>Assignments: <?php echo $problem['name'] ?></h1>
<div style="text-align:center"><?php echo $problem['description'] ?></div>

<div class="outputdiv">

<h3 style="margin-top:0; border-bottom:1px solid black;">Finalize Assignments</h3>

<div style="text-align:center;">
  <span style="margin-top:1em; margin-bottom:1em;">The current user-resource assignments are listed below. You may swap assignments and unassign users if you like, but remember, these assignments were first-come first-serve, so swapping them might make some people angry.</span>
</div>

<table id="assignmentTable">

<thead><tr><th>Assignment</th><th>Participant</th></tr></thead>

<tbody>
<?php

list($assignments, $unassignedUsers) = getAssignments($problem['id']);

foreach ($assignments as $assignment) {

    $participant = getUserById($assignment['participant']);

   echo '<tr><td><span class="nameCell">' . $assignment['assignment'] . '</span><span class="idCell">' . $assignment['id'] . '</span></td><td><span class="nameCell">' . getNameString($participant) . '</span><span class="idCell">' . $assignment['participant'] . '</span></td></tr>' . "\n";
}
?>

</tbody>
</table>

<table id="unassignedTable" >
<thead><tr><th>Unassigned</th></tr>
</thead>
<tbody>
<?php

foreach ($unassignedUsers as $unassignedUser) {
     $user = getUserById($unassignedUser);
     echo '<tr><td style="display:none;"><span class="nameCell"></span><span class="idCell">0</span></td><td><span class="nameCell">' . getNameString($user) . '</span><span class="idCell">' . $user['id'] . '</span></td></tr>' . "\n";
}
?>
</tbody></table>

<div style="clear: both; text-align:center;"><input type="button" id="swapButton" value="Swap/Assign" onclick="swap(<?php echo $problem['id'] ?>);" disabled><input type="button" id="unassignButton" value="Unassign" onclick="unassign(<?php echo $problem['id'] ?>);" disabled></div>

</div>

<div class="outputdiv">

<h3 style = "margin-top:0; border-bottom:1px solid black;">Notify Respondents</h3>

<div style="text-align:center;"><?php drawPostButtons($status, $problem['id']) ?></div>

<?php drawCommentsField($problem['id'], $problem['comment']) ?>

</div>

<?php include_once '../../includes/footer.inc'; ?>
