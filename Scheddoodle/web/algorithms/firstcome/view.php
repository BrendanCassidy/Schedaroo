<?php include_once '../../includes/config.inc' ?>
<?php include_once 'functions.php' ?>

<?php

checkPermissions();

if (!isset($_GET['problem'])) { die("no problem specified"); }
$problem = getProblemById($_GET['problem']);

checkAllowedView($problem);

include_once PATH . '/includes/header.inc';
include_once PATH . '/includes/body.inc';

?>
<link rel="stylesheet" href="style.css">
<h1><?php echo $problem['name'] ?></h1>

<table id="outputTable">
<tr><th>User</th><th>Assignment</th></tr>

<?php

list($assignments, $unassigned) = getAssignments($problem['id']);
foreach ($assignments as $assignment) {
    if ($assignment['participant']) { $participant = getUserById($assignment['participant']); }
    else { $participant = NULL; }
    
    if (!$assignment['assignment']) { $assignment['assignment'] = "--"; }

    if ($participant['id'] == $current_user) {
      echo '<tr style="background-color:#738AE1;"><td><b>' . getNameString($participant) . '</td><td><b>' . $assignment['assignment'] . "</td></tr>\n";
    }
    else {
      echo '<tr><td>' . getNameString($participant) . '</td><td>' . $assignment['assignment'] . "</td></tr>";
    }
}

foreach ($unassigned as $assignment) {
  echo '<tr><td>' . getNameString(getUserById($assignment)) . '</td><td>--</td></tr>'; 
}

echo '</table>';

if ($problem['comment']) {
    echo '<h2>Comments</h2>';
    echo '<p>' . $problem['comment'] . '</p>';
}

?>

<?php include_once PATH . '/includes/footer.inc' ?>