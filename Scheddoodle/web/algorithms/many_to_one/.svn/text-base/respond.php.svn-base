<?php
include_once '../../includes/config.inc'; // add a wrapper so we do not have to use relative path
include_once 'functions.php';
include_once PATH . '/includes/header.inc';

checkPermissions();

if (!(isset($_GET['problem']))) { die("no problem specified"); }

$problem = getProblemById($_GET['problem']);
$resources = getAllResources($problem['id']);
$preferences = getAllPreferences($problem['id']);
$user = getUserById($current_user);

checkAllowedRespond($problem);

?>

<link rel="stylesheet" type="text/css" href="style.css">

<?php include_once PATH . '/includes/body.inc' ?>

<h1><?php echo $problem['name'] ?></h1>
<p><?php echo $problem['description'] ?></p>

<form action="process.php" method="post">
    <input type="hidden" name="action" value="respond">
    <input type="hidden" name="user" value="<?php echo $user['id'] ?>">
    <input type="hidden" name="problem" value="<?php echo $problem['id'] ?>">

    <div style="width:100%;margin-left:auto;margin-right:auto;overflow:auto;">
    <table id="responseTable">

    <?php
        echo '<tr style="font-weight: bold;"><th>Name</th>';
        foreach ($resources as $resource) { echo '<th>' . $resource['name'] . '</th>'; }
        echo "</tr>";

        foreach ($preferences as $preference) { // maybe loop through users instead?
            if ($preference['id'] == $user['id']) { continue; }
	    if (!hasResponded($problem['id'], $preference['id'])) { $class = ' class="participantnotresponded"'; }
            else { $class = ''; }
            echo '<tr' . $class . '><td>' . $preference['name'] . '</td>';
            foreach ($resources as $resource) {
                echo '<td>';
                if (in_array($resource['id'], $preference['preference'])) { echo '<img src="' . URL . '/images/check.png">'; }
		echo '</td>';
            }
            echo "</tr>";
        }
        $preference = getPreferencesForParticipant($problem['id'], $user['id']);

        echo '</tr><tr style="background-color: #738AE1"><td><b>' . $user['name'] . '</b></td>';
        
        foreach ($resources as $resource) {
            $checked = "";
            if (in_array($resource['id'], $preference)) { $checked = " checked"; }
            echo '<td><input type="checkbox" name="resources[]" value="' . $resource['id'] . '"' . $checked . '></td>';
        }
    ?>
    </tr>
    </table>
    </div>
    <div style="text-align:center; margin-top: 5px;"><input style="font-size: 1.3em;" type="submit" value="Submit"></div>
</form>

<?php include_once '../../includes/footer.inc' ?>