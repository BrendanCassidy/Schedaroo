<?php
include_once 'includes/config.inc';
include_once 'includes/header.inc';
checkPermissions();
$groups = getAllGroups();
$groups = sortGroupsByRelevance($groups, $current_user);
?>

<script src="js/jquery-1.4.2.min.js"></script>
<script src="js/groups.js"></script>
<script src="js/jquery-ui-1.8.10.custom.min.js"></script>
<link rel="stylesheet" href="css/jquery.ui.css">

<?php include_once PATH . '/includes/body.inc' ?>

<div>
<div style="position:relative;float:left;"><input type="button" value="New Group" onclick="window.location='group.php'"></div>
<div style="position:relative;float:right;">
Filter:
<select onChange="view(this.value);">
  <option value="row">View All</option>
  <option value="participant">Groups You Are A Part Of</option>
  <option value="admin">Groups You Created</option>
</select>
</div>
</div>

<div id="emptyGroupsTable" class="emptyItemTable" style="<?php if (!empty($groups)) { echo " display: none;"; } ?>"><p>There are no groups in this category</p></div>

<?php

$notAnAdmin = 1; // if the current user is not an admin of any groups, then we will align the description all the way to the right

if (!empty($groups)) { echo '<table id="groupsTable" class="itemTable">'; }

foreach ($groups as $group) {
    $class = 'row';
    $isParticipantInGroup = isParticipantInGroup($current_user, $group['id']);
    $isAdminInGroup = isAdminInGroup($current_user, $group['id']);
    if (!$isParticipantInGroup) { $class .= " notParticipant"; }

    $go = 0; // if go = 1, then we will display the group ** maybe do this in the getAllGroups function
    if ($group['type'] == "admin" && $isAdminInGroup) { $go = 1;  }
    else if (($group['type'] == "private" && $isParticipantInGroup) || $isAdminInGroup) { $go = 1; }
    else if ($group['type'] == "public" ) { $go = 1; }

    if ($go) {
	if ($isAdminInGroup) {
            $class .= ' admin';
            $badges = ' <img src="images/admin.png" title="You are the admin of this group.">';
            $deleteLink = '<a href="javascript:void(0);" onclick="deleteGroup(' . $group['id'] . ', \'' . $group['name'] . '\');"><img src="images/delete.png" title="Delete Group"></a>';
            $notAnAdmin = 0;
        }
        else {
	  $badges = '';
	  $deleteLink = '<span style="margin-left:16px;"></span>';
	}

	if ($isParticipantInGroup == 2) { $class .= ' participant'; } ?>
        <tr id="<?php echo $group['id'] ?>" class="<?php echo $class ?>">
            <td class="nameColumn"><a href="group.php?group=<?php echo $group['id'] ?> "><?php echo $group['name'] ?></a><?php echo $badges ?></td>
            <td class="descriptionColumn"><?php echo $group['description'] ?><span class="buttonSet"><?php echo $deleteLink ?></span></td>
       </tr><?php
    }
}
if (!empty($groups)) { echo '</table>'; }
if ($notAnAdmin) { echo '<style>.buttonSet { display: none; } </style>'; }
?>
 
<div id="dialog" title="Help - Groups">
    <p>This is the Groups page, where you can manage groups for more efficient schedule creation.</p>
    <p><strong>The groups you are a part of</strong> are highlighted in blue.</p>
    <p><strong>To view the participants in a group</strong>, click on the name of the group.</p> 
    <p><strong>To create a new group</strong>, click on the "New Group" button on the upper left corner.</p>
    <p><strong>To add a group to an event you have created</strong>, type in the name of the group in the "Add Participants" line of the "Create Event" page.
</div>

<?php include_once 'includes/footer.inc' ?>
