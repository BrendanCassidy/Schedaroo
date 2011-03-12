<?php
include_once 'includes/config.inc';
checkPermissions();
if (isset($_GET['group'])) { // if we are updating an existing group
    $group = getGroupByID($_GET['group']);
    $admins = getAdminsForGroup($group['id']);
    $type = $group['type'];

    $theAdmins = '<ul>';
    foreach ($admins as $admin) { $theAdmins .= "<li>" . $admin['name'] . "</li>"; }
    $theAdmins .= '</ul>';

    $participants = getParticipantsForGroup($group['id']);
    $theParticipants = '';
    if (isAdminInGroup($current_user, $group['id'])) {
        foreach ($participants as $participant) {
            if ($participant['isParticipant'] == 1) {
                $pending = '<span class="request" id="' . $participant['id'] . '"> -- requesting <a href="javascript:void(0)" onclick="approve(' . $participant['id'] . ',' . $group['id'] . ')">approve</a> <a href="javascript:void(0)" onclick="ignore(' . $participant['id'] . ',' . $group['id'] . ')">ignore</a></span>';
            }
            else { $pending = ""; }
            $theParticipants .= '<li><input type="checkbox" name="existing_participants[]" value="' . $participant['id'] . '" checked>' . getNameString($participant) . $pending . "</li>\n";
        }
    }
    else {
        foreach ($participants as $participant) {
            if ($participant['isParticipant'] != 2) { continue; }
            $theParticipants .= '<li>' . getNameString($participant) . "</li>\n";
        }
    }
}
else {
    $group['id'] = 0;
    $group['name'] = '';
    $admin = getUserById($current_user);

    $theAdmins = '<ul><li>' . $admin['name'] . '</li></ul>';

    $group['description'] = '';
    $type = "private";
    $theParticipants = '';
} // if we are starting a new group

include_once "includes/header.inc";
?>

<link type="text/css" href="css/jquery.ui/cupertino/jquery-ui-1.8.9.custom.css" rel="stylesheet">
<script src="js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="js/group.js"></script>
<script src="js/autoComplete.js"></script>


<?php include_once "includes/body.inc" ?>

<div id="output"></div>

<?php if ($group['id'] == 0 || isAdminInGroup($current_user, $group['id'])): ?>

<form id="form">
	<input type="hidden" name="admin" value="<?php echo $current_user ?>">
	<input type="hidden" name="group" value="<?php echo $group['id'] ?>">
	
	<div class="block">
	
		<h2>Group Name:</h2>
		<p style="margin-top:0;margin-bottom:0;">(no spaces please)</p>
		<input type="text" name="name" value="<?php echo $group['name'] ?>" size="40">
		<div class="error" id="nameError"></div>
		
		<h2>Group Description:</h2>
		<textarea name="description" rows="3" cols="40"><?php echo $group['description'] ?></textarea>
		
                <h2>Group Type:</h2>
		<p style="margin-left:175px;text-align:left;">
		<?php
			$publicChecked = '';
			$privateChecked = '';
			$adminChecked = '';
			
			if (!strcmp($type,"public")) { $publicChecked = " checked"; }
			else if (!strcmp($type,"admin")) { $adminChecked = " checked"; }
			else { $privateChecked = " checked"; } // else, we set the type to private
		?>
		<input type="radio" name="type" value="private"<?php echo $privateChecked ?>>Private (only you and the participants can see this group)<br>
		<input type="radio" name="type" value="public"<?php echo $publicChecked ?>>Public (anyone can see this group)<br>
		<input type="radio" name="type" value="admin"<?php echo $adminChecked ?>>Admin (only you can view this group)<br>
		</p>
		
		<h2>Group Members:</h2>
                <input type="text" name="username" value="Search for Participants" onfocus="this.value=''" onblur="this.value='Search for Participants'">
                <br>
                <textarea name="participants" rows="5" cols="26"></textarea>
		<ul id="existing_participants" class="participants"><?php echo $theParticipants ?></ul>
	
	</div>
	
	<div style="text-align:center;"><input type="button" id="saveButton" onclick="save()" class="button" value="Save"><input type="button" onclick="window.location='groups.php'" class="button" value="Discard Changes"></div>

</form>

<?php else: ?>

<div id="groupTable">

<table>
    <tr class="groupTable"><td bgcolor="#738AE1"><b>Group Name:</b></td><td><?php echo $group['name'] ?></td></tr>
    <tr class="groupTable"><td bgcolor="#738AE1"><b>Group Admin:</b></td><td><?php echo $theAdmins ?></td></tr>
    <tr class="groupTable"><td bgcolor="#738AE1"><b>Group Description:</b></td><td><?php echo $group['description'] ?></td></tr>
    <tr class="groupTable"><td bgcolor="#738AE1"><b>Group Members:</b></td><td><ul><?php echo $theParticipants ?></ul></td></tr>
</table>

</div>

<?php $i = isParticipantInGroup($current_user, $group['id']) ?>

<?php if ($i == 0): ?>
<input type="button" name="requestButton" value="Request to Be In this Group" onclick="request(<?php echo $current_user ?>, <?php echo $group['id'] ?>);">

<?php elseif ($i == 1): ?>
<input type="button" name="requestButton" value="Group Request Sent" disabled>

<?php endif; ?>


<?php endif; ?>

<?php include_once 'includes/footer.inc' ?>
