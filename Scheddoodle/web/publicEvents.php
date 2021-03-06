<?php
include_once 'includes/config.inc';
checkPermissions();
include_once 'includes/header.inc';
$dates = getPublicProblems();
?>

<script src="js/publicEvents.js"></script>
<script src="js/jquery-ui-1.8.10.custom.min.js"></script>
<link rel="stylesheet" href="css/jquery.ui.css">

<?php include_once 'includes/body.inc' ?>
<?php if (count($dates)) { ?>

    <div style="float:right;">Search: <input type="text" name="filterBox" <?php if (isset($_GET['q'])) { echo ' value="' . $_GET['q'] . '"'; } ?>></div>

    <div id="emptyEventsTable" class="emptyItemTable" style="display: none;"><p>There are no events that matched your search.</p></div>
    <table class="itemTable" id="publicEventsTable">

    <?php
    foreach ($dates as $dateText => $date) {

      $dateTextArray = explode("-", $dateText);

      echo '<tr id="' . $dateText . '"><th colspan="2">' . date("l F j, Y", mktime(0,0,0,$dateTextArray[1],$dateTextArray[2],$dateTextArray[0])) . '</th></tr>';

        foreach ($date as $problem) {
            if ($problem['name'] == '') { $problem['name'] = "[untitled]"; }
            $algorithm = getAlgorithmById($problem['algorithm']);
            $problemStatus = getProblemStatus($problem['id']);
            $userResponded = hasResponded($problem['id'], $current_user);

            $adminString = '';
            $admins = getAdminsForProblem($problem['id']);

            foreach ($admins as $admin) {
              $adminString .= getNameString($admin) . ', ';
            }

            $adminString = substr($adminString, 0, -2);

            if (!$userResponded) {
                $link = '<a href="respond.php?problem=' . $problem['id'] . '">Join this Event</a>';
                $class = " notresponded";
            }
            else {
                $link = '<a href="respond.php?problem=' . $problem['id'] . '">Change Response</a>';
                $class = "";
            }

            if ($problemStatus == "open") { $status = "Open"; }
            else if ($problemStatus == "timed") { $status = expirationTime($problem['end_time']); } ?>
            <tr id="<?php echo $problem['id'] ?>" class="row <?php echo $dateText ?><?php echo $class ?>">
            <td class="descriptionColumn">
                <span class="keywords"><?php echo $problem['name'] ?> <?php echo $adminString ?></span>
                <?php echo $problem['name'] ?> - posted by <?php echo $adminString ?><br>
                <span><?php echo $link ?></span>
            </td>
            <td class="statusColumn"><?php echo $status ?></td>
            </tr><?php
        }

    }
    echo '</table>';
}

else { echo '<div class="emptyItemTable"><p>There are no public events right now.</p></div>'; } ?>

<div id="dialog" title="Help - Public Events">
    <p>This is the <strong>Public Events page</strong>, where you can see and respond to events that are open to everyone at Carleton.</p>
    <p><strong>To join a public event</strong>, click on "Join this Event." You will be redirected to a page where you can mark your availability and preferences.</p>
    <p><strong>To filter events</strong>, enter text in the "Search" box. Sched-A-Roo will only display the events whose title or creator contains the text you entered.
    <p><strong>To create a public event</strong>, click "New Event" on the <a href="problems.php">home page</a> and select "Public Event" in the options.</p>
    <p><strong>For more help</strong>, please see the <a href="help.php">help page</a>.</p>
</div>

<?php include_once 'includes/footer.inc' ?>
