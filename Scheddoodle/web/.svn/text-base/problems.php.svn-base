<?php
include_once 'includes/config.inc';
include_once 'includes/header.inc';
checkPermissions();
$problems = getProblemsForUser($current_user);
$problems = sortProblemsByRelevance($problems, $current_user);
?>

<script src="js/problems.js"></script>
<script src="js/jquery-ui-1.8.10.custom.min.js"></script>
<!--<link rel="stylesheet" href="css/jquery.ui.css">-->
<link rel="stylesheet" href="css/help.css">

<?php include_once 'includes/body.inc' ?>

<div id="toolbar">
<div style="position:relative;float:left;"><input id="newEventButton" type="button" value="New Event" onclick="window.location='new_problem.php'"></div>
<div style="position:relative;float:right;">
<div id="basicSearchDiv">
View Events:
<select onChange="view(this.value);">
    <option value="current">Visible</option>
    <option value="notresponded">Not Yet Responded</option>
    <option value="participant">You Are A Part Of</option>
    <option value="admin">You Created</option>
    <option value="row">All</option>
</select>
<a href="javascript:void(0)" id="showAdvancedSearchButton" title="Click for advanced filtering options.">Advanced</a>

</div>
<div id="advancedSearchDiv">
<table>
<tr>
    <td>Visibility:</td>
    <td><select id="visibility">
    <option value="current">Visible</option>
    <option value="row:not(.current)">Hidden</option>
    <option value="row">All</option>
    </select></td>
    <td><a href="javascript:void(0)" id="hideAdvancedSearchButton" title="Click for basic filtering options.">Basic</a></td>
</tr>

<tr>
    <td>Admin/Participant:</td>
    <td><select id= "userStatus">
    <option value="row">All</option>
    <option value="admin">Administrator</option>
    <option value="participant">Participant</option>
    <option value="admin.participant">Admin/Participant</option>
    </select></td><td></td>
</tr>

<tr>
    <td>Response Status:</td>
    <td>
    <select id="responseStatus">
    <option value="row">All</option>
    <option value="notresponded">Not Yet Responded</option>
    <option value="responded">Already Responded</option>
    </select></td><td></td>
</tr>

<tr>
    <td>Problem Status:</td>
    <td><select id="problemStatus">
    <option value="row">All</option>
    <option value="open">Open</option>
    <option value="closed">Closed</option>
    <option value="posted">Posted</option>
    </select></td><td></td>
</tr>

<tr>
    <td></td><td colspan="2"><input id="advancedFilterButton" type="button" value="Filter" onclick='advancedView($("#visibility").val(), $("#userStatus").val(), $("#responseStatus").val(), $("#problemStatus").val());'></td>
</tr>

</table>

</div>
</div>
</div>

<div id="emptyEventsTable" class="emptyItemTable" style="display: none;"><p>There are no events in this category.</p></div>

<?php
if (!empty($problems)) { echo '<table id="eventsTable" class="itemTable"><tr><th>Event</th><th>Status</th><th>Action</th></tr>'; }

// we assume there are no current problems at the start
$showNone = 1;

foreach ($problems as $problem) {
    if ($problem['name'] == '') { $problem['name'] = "[untitled]"; }
    $algorithm = getAlgorithmById($problem['algorithm']);

    $openSelected = '';
    $closedSelected = '';
    $timedSelected = '';
    $postedSelected = '';

    // deal with the status of a problem
    $status = '';
    switch ($problem['status']) {         // status                                                              // select checker               // the response link
    case "open":                          $status .= "Open";                                $class = "open";     $openSelected = " selected";    $respondLink = '[<a href="respond.php?problem=' . $problem['id'] . '">Respond</a>]';         break;
    case "closed":                        $status .= "Closed";                              $class = "closed";   $closedSelected = " selected";  $respondLink = '';                                                                           break;
        case "timed":
          if (isExpired($problem['id'])): $status .= "Expired";                             $class = "closed";   $timedSelected = " selected";   $respondLink = '';
          else:                           $status .= expirationTime($problem['end_time']);  $class = "";         $timedSelected = " selected";   $respondLink = '[<a href="respond.php?problem=' . $problem['id'] . '">Respond</a>]'; endif;  break;
    case "posted":              	  $status .= "Posted";                              $class = "posted";   $postedSelected = " selected";  $respondLink = '[<a href="view.php?problem=' . $problem['id'] . '">View</a>]';               break;
    default:                              $status .= "No Status";                            $class = "nostatus";                                $respondLink = "No Status";                                                                  break;
    }

    // deal with user's role in a problem
    if ($problem['isAdmin'] && $problem['isParticipant']) { // if the user is an admin and participant to the problem
        $class .= " row admin participant";
        $badges = ' <img id="admin" src="images/admin.png" title="You are the admin of this event.">';
        $editLink = '<img src="images/edit.png" title="Edit Event" class="editLink">';
        $deleteLink = '<a href="javascript:void(0);" onclick="javascript:deleteProblem(' . $problem['id'] . ',\'' .  addslashes($problem['name']) . '\');"><img src="images/delete.png" title="Delete Event"></a>';
        
        if (!hasResponded($problem['id'], $current_user)) { $class .= " notresponded"; }
	else { $class .= " responded"; }        

        $more = '<strong>Type: </strong>' . $algorithm['name'] . '<br><strong>Description: </strong>';
        if ($problem['description']) { $more .= $problem['description'] . '<br>'; }
        else { $more .= "[no description]"; }
                
        $respondLink .= ' [<a href="run.php?problem=' . $problem['id'] . '">Finalize Event</a>]';
        list($respondedCount, $totalCount) = getResponseCount($problem['id']);
        $status .= '<br><a href="responses.php?problem=' . $problem['id'] . '">' . "{$respondedCount}/{$totalCount}" . ' Responded</a>';
    }
    
    else if ($problem['isAdmin']) { // if the user is only an admin to the problem
        $class .= " row admin";
        $badges = ' <img id="admin" src="images/admin.png" title="You are the admin of this event.">';
        $editLink = '<img src="images/edit.png" title="Edit Event" class="editLink">';
        $deleteLink = '<a href="javascript:void(0);" onclick="javascript:deleteProblem(' . $problem['id'] . ',\'' .  addslashes($problem['name']) . '\');"><img src="images/delete.png" title="Delete Event"></a>';
    
        $more = '<strong>Type: </strong>' . $algorithm['name'] . '<br><strong>Description: </strong>';
        if ($problem['description']) { $more .= $problem['description'] . '<br>'; }
        else { $more .= "[no description]"; }
        
        $respondLink = '[<a href="run.php?problem=' . $problem['id'] . '">Finalize Event</a>]';
        list($respondedCount, $totalCount) = getResponseCount($problem['id']);
        $status .= '<br><a href="responses.php?problem=' . $problem['id'] . '">' . "{$respondedCount}/{$totalCount}" . ' Responded</a>';
    }
    
    else if ($problem['isParticipant']) { // if the user is only a participant
        $class .= " row participant";
        $badges = "";
        $editLink = '<span style="margin-left:16px;"></span>';
        $deleteLink = '<span style="margin-left:16px;"></span>';
        
        if (!hasResponded($problem['id'], $current_user)) { $class .= " notresponded"; }
	else { $class .= " responded"; }

        $adminString = '';
        $admins = getAdminsForProblem($problem['id']);

        foreach ($admins as $admin) {
	  $adminString .= getNameString($admin) . ', ';
        }

        $adminString = substr($adminString, 0, -2);

        $more = '<strong>Type: </strong>' . $algorithm['name'] . '<br><strong>From:</strong> ' . $adminString;
        if ($problem['description']) { $more .= '<br><strong>Description:</strong> ' . $problem['description']; }
    }

    // deal with archiving
    if ($problem['isArchived']) {
        $archiveLink = '<a href="javascript:void(0);" onclick="unArchiveProblem(' . $problem['id'] . ', ' . $current_user . ');"><img src="images/unarchive.png" title="Unhide Event"></a>';
    }
    else {
        $archiveLink = '<a href="javascript:void(0);" onclick="archiveProblem(' . $problem['id'] . ', ' . $current_user . ');"><img src="images/archive.png" title="Hide Event"></a>';
        $class .= " current";
        $showNone = 0;
    } ?>

    <tr class="<?php echo $class ?>" id="<?php echo $problem['id'] ?>">
    <td>
        <img class="infoButton" src="images/downarrow.png" title="Click for the event description.">
        <span class="title"><?php echo $problem['name'] ?><?php echo $badges ?></span>
        <div style="position:relative;float:right;"><?php echo $respondLink ?></div>
        <div class="more"><?php echo $more ?></div>
    </td>
    <td class="statusColumn"><?php echo $status ?></td>
    <td class="actionColumn"><?php echo $editLink ?><span class="archiveLink"><?php echo $archiveLink ?></span><?php echo $deleteLink ?></td>
    </tr><?php

}
    
if (!empty($problems)) { echo '</table>'; }

if ($showNone) { echo '<script>view(".current");</script>'; }

?>
<div id="dialog" title="Help - Main Page">
    <p>This is the Main Page of <strong>Sched-A-Roo</strong>, where you can organize, create, edit, and respond to schedules.</p>
    <p><strong>To repond to a schedule</strong>, click on the blue "Respond" link next to the title of a schedule. If you have not yet responded to a schedule, that schedule will be highlighted in blue. Once a schedule is closed by its creator, you can no longer respond, but you may be able to view the results.</p>
    <p><strong>To create a new schedule</strong>, click on the "New Event" button on the upper left side of the page.</p>
    <p><strong>To hide a schedule</strong>, click on the eye icon in the last column. You can view hidden schedules, as well as <strong>sort schedules</strong> by your role, by using the "View Events" drop-down menu.</p>
    <p><strong>Advanced filtering</strong> is accessed by pressing the double arrows next to the "View Events" menu.</p>
    <p><strong>Creator options</strong> include:
    <ul> 
        <li> <img src="images/archive.png"><strong> Delete an event</strong></li> 
        <li> <img src="images/edit.png"><strong> Edit an event</strong></li>
        <li> [<span style="color:blue">Finalize Event</span>] <strong>Finalize an event</strong>.</li></ul>
    <p>Event creators will see a <img src="images/admin.png"> by events they have created.</p>
    <p><strong>For more help</strong>, please see the <a href="help.php">help page</a>.</p>
</div>

<?php include_once 'includes/footer.inc' ?>
