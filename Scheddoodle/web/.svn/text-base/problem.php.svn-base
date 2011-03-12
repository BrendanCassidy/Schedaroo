<?php
include_once 'includes/config.inc';
checkPermissions();

if (isset($_GET['problem'])) { // if we are updating an existing problem
    $problem = getProblemById($_GET['problem']);

    checkAllowedEdit($problem);

    $algorithm = getAlgorithmFromProblem($problem['id']);
    $action = "update_problem";
    $users = getParticipantsForProblem($problem['id']); 
    $theUsers = '';
    foreach ($users as $user) {
        if (!hasResponded($problem['id'], $user['id'])) { $respondText = ' <img src="images/alert.png" title="has not responded">'; }
        else { $respondText = ""; }
        $theUsers .= '<li><input type="checkbox" name="existing_participants[]" value="' . $user['id'] . '" checked>' . getNameString($user) . $respondText . "</li>\n";
    }
}

else {
    $action = "add_problem";
    $problem['id'] = 0;
    $algorithm = getAlgorithmById($_GET['type']);
} // if we are starting a new problem

include_once "includes/header.inc";
?>

<link type="text/css" href="css/jquery.ui/cupertino/jquery-ui-1.8.9.custom.css" rel="stylesheet">
<script src="js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
<script src="js/problem.js"></script>
<script src="js/autoComplete.js"></script>

<script>
var algorithm = "<?php echo $algorithm['slug'] ?>";
</script>

<?php include_once "includes/body.inc" ?>

<div id="output"></div>

<form id="form">
    <input type="hidden" name="action" value="<?php echo $action ?>">
    <input type="hidden" name="algorithm" value="<?php echo $algorithm['id'] ?>">
    <input type="hidden" name="problem" value="<?php echo $problem['id'] ?>">
    
    <div class="block">
    
        <h2>Event Name:</h2>
        <input type="text" name="name"<?php if ($action == "update_problem") { echo ' value="' . $problem['name'] . '"'; } ?> size="40">

        <h2>Event Type:</h2>
        <?php echo $algorithm['name'] ?>
        
        <h2>Event Description:</h2>
        <textarea name="description" rows="5" cols="50"><?php if ($action == "update_problem") { echo $problem['description']; } ?></textarea>
        
        <h2>Event Type:</h2>
        <p class="radioBlock">
        <?php
        $privateChecked = '';
        $publicChecked = '';
        
        if (isset($problem['type']) && $problem['type'] == "public") { $publicChecked = " checked"; }
        else { $privateChecked = " checked"; }
        
        ?>
        <input type="radio" name="type" value="private"<?php echo $privateChecked ?>>Private (Only Specified Participants Can Respond)<br>
        <input type="radio" name="type" value="public"<?php echo $publicChecked ?>>Public (Anyone Can Respond)
        </p>
        
        <h2>Event Status:</h2>
        <p class="radioBlock">
        <?php
			$openChecked = '';
			$closedChecked = '';
			$timedChecked = '';
			
			if ($problem['id'] && $problem['end_time']) { $timedExpiration = $problem['end_time']; }
			else { $timedExpiration = '0000-00-00 00:00'; }
			
			$timedDisabled = ' disabled';
			$postedChecked = '';
			
			$status = getProblemStatus($problem['id']);
			
			if (!strcmp($status,"closed")) { $closedChecked = " checked"; }
			else if (!strcmp($status,"timed")) {
			  $timedChecked = " checked";
			$timedDisabled = '';
			}
			else if (!strcmp($status,"posted")) { $postedChecked = " checked"; }
			else { $openChecked = " checked"; } // else, we set the status to open
        ?>
		<input type="radio" name="status" value="open"<?php echo $openChecked ?>>Open (People Can Respond)<br>
		<?php if ($problem['id'] != 0): ?><input type="radio" name="status" value="closed"<?php echo $closedChecked ?>>Closed (People Cannot Respond)<br><?php endif; ?>
		<input type="radio" name="status" value="timed"<?php echo $timedChecked ?>>Close at:
		<input type="date" name="expiration_time" value="<?php echo $timedExpiration ?>"<?php echo $timedDisabled ?>><br>
		<?php if ($problem['id'] != 0): ?><input type="radio" name="status" value="posted"<?php echo $postedChecked ?>>Posted (People Can See the Results)<?php endif; ?>
        
        </p>
        
        <h2>Event Participants:</h2>
        <input type="text" name="username" value="Search for Participants" onfocus="this.value=''" onblur="this.value='Search for Participants'">
        <br>
        <textarea name="participants" rows="5" cols="26"></textarea>
        <ul id="existing_participants" class="participants"><?php if ($action == "update_problem") { echo $theUsers; } ?></ul> 

    </div>
    <div style="text-align:center;">
        <?php if ($problem['id'] == 0): ?>
    	<input type="button" value="Save and Continue" onclick="save(1);" class="button"><input type="button" onclick="window.location='problems.php'" class="button" value="Discard">
        <?php else: ?>
	<input type="button" id="saveButton3" onclick="save(1);" class="button" value="Save and Continue">
	<input type="button" onclick="window.location='problems.php'" class="button" value="Discard Changes">
        <input type="button" id="saveButton2" onclick="save(3);" class="button" value="Finish Editing">
        <?php endif; ?>
    </div>
 
</form>

<?php include_once 'includes/footer.inc' ?>
