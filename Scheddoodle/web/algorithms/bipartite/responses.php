<?php
include_once '../../includes/config.inc';
include_once PATH . '/includes/header.inc';
include_once 'functions.php';

checkPermissions();

if (!(isset($_GET['problem']))) { die("no problem specified"); }

$problem = getProblemById($_GET['problem']);
$resources = getAllResources($problem['id']);
$preferences = getAllPreferences($problem['id']);
$user = getUserById($current_user);

checkAllowedViewResponses($problem);

?>

<link rel="stylesheet" type="text/css" href="style.css">

<?php include_once PATH . '/includes/body.inc' ?>

<h1><?php echo $problem['name'] ?></h1>
<p><?php echo $problem['description'] ?></p>

<h2>Responses So Far:</h2>
<div style="width:100%;margin-left:auto;margin-right:auto;overflow:auto;">

<table id="responseTable">
<?php
    echo '<tr><th>Name</th>';
    foreach ($resources as $resource) { echo '<th>' . $resource['name'] . '</th>'; }
    echo "</tr>";

    foreach ($preferences as $preference) {
        if (!hasResponded($problem['id'], $preference['id'])) { $class = ' class="participantnotresponded"'; }
        else { $class = ''; }
        echo '<tr' . $class . '><td>' . $preference['name'] . '</td>';
        foreach ($resources as $resource) {
            echo '<td>';
            if (in_array($resource['id'], $preference['preference'])) { echo '<img src="' . URL . '/images/check.png">'; }
            else { echo '<span style="margin-left: 16px;"></span>'; }
            echo '</td>';
        }
        echo "</tr>";
    }
?>
</tr>
</table>
</div>
<div id="back button" style="text-align:center"><br><input type="button" value="Back to My Events" onclick="window.location='../../problems.php'"></div>
<?php include_once '../../includes/footer.inc' ?>