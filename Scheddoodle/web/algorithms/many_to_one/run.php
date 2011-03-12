<?php
    include_once '../../includes/config.inc';
    include_once 'functions.php';
    checkPermissions();
    if (!isset($_GET['problem'])) { die("no problem specified"); }
    $problem = getProblemById($_GET['problem']); // check to see if we find the problem

    checkAllowedEdit($problem);
    
    include_once '../../includes/header.inc';

    $preferences = getAllPreferences($problem['id']);

    $resources = getAllResources($problem['id']); // fix this
    $num_resources = count($resources);

    $max_col_index = getData($problem['id'], 0, 'max_col_index');

    // close the problem if it is open
    $status = getProblemStatus($problem['id']);
    //if ($status == "open" || $status == "timed") { setProblemStatus($problem['id'], "closed"); $status = "closed"; }

?>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript">
    <?php
        if ($max_col_index['v']) {
            echo 'max_col = [' . $max_col_index['v'] . "];\n";
            echo "max_col_index = 0;\n";
        }
	else {
            echo 'var max_col = [];'; // stores the columns that have the max totals
	    echo 'var max_col_index = 0;'; // contains the index of the column we are highlighting
	}
    ?>
    var totals = new Array(<?php for ($i=0; $i<$num_resources-1; $i++) { echo '0,'; } ?>0);
</script>
<script type="text/javascript" src="run.js"></script>
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.8.6.custom.css" rel="stylesheet" />  
<link type="text/css" href="runStyle.css" rel="stylesheet" />  

<?php include_once '../../includes/body.inc' ?>

<h1><?php echo $problem['name'] ?></h1>

<div>
<div style="float:left;"><input type="button" id="saveButton" value="Save" onclick="save(<?php echo $problem['id'] ?>);"><input type="button" value="Discard Changes" onclick="window.location='../../problems.php'"></div>
<div style="float:right;"><?php drawPostButtons($status, $problem['id']) ?></div>
</div>

<div style="overflow: auto; width: 100%">
<table id="outputTable">
<tr><th>user</th><th class="priorityCell">- priority +</th><th class="valueCells" style="border-left:0;"></th>

<?php

foreach ($resources as $resource) { // printing the head
    echo '<th class="slotCell"><span class="nameField">' . $resource['name'] . '</span><span class="idField">' . $resource['id'] . '</span></th>' . "\n";
}

echo "</tr>";

// printing the part with the checkboxes

foreach ($preferences as $preference) {

    $importance = getImportanceForParticipant($problem['id'], $preference['id']); // we should include this in preferences
    if (!$importance) { $importance = 25; }

    if (!$preference["hasResponded"]) { $notresponded = " notresponded"; }
    else { $notresponded = ""; }

    echo '<tr class="row' . $notresponded . '">';
    echo '<td class="userCell"><span class="nameField">' . $preference['name'] . '</span><span class="idField">' . $preference['id'] . '</span></td><td class="sliderCell priorityCell"><div class="slider"></div></td>' . "\n";
    echo '<td class="valueCell valueCells">' . $importance . '</td>' . "\n";
    foreach ($resources as $resource) {
        if (in_array($resource['id'], $preference['preference'])) { $checked = " checked"; }
        else { $checked = ""; }
        echo '<td class="slotCell"><span class="idField">' . $resource['id'] . '</span><input type="checkbox" class="slot"' . $checked . ' onclick="return false;"></td>' . "\n";
    }
    echo "</tr>\n\n";
}

// printing the totals

echo '<tr class="totals valueCells"><td style="border-right:0;">Totals:</td><td style="border-left:0; border-right:0;" class="priorityCell"></td><td style="border-left:0;"></td>';

foreach ($resources as $resource) { echo '<td class="total"><span class="idField">' . $resource['id'] . '</span><span class="valueField">25</span></td>'; }

?>
</tr>
</table>
</div>

<div>

<div style="float:left;"><p id="options" style="display:none;"><a href="javascript:void()" onclick="showPrevious()">previous</a> | <span id="optimal"></span> | <a href="javascript:void()" onclick="showNext()">next</a></p></div>
<div style="float:right;">
<input type="checkbox" id="priorityCheckbox" value="hide" onclick="togglePriority();" checked>Display Priority
<input type="checkbox" id="valuesCheckbox" value="show" onclick="toggleValues();">Display Values
</div>
</div>

<br style="clear: both;">
<div class="comment">
<h2>Comments for Participants:</h2>
<textarea id="comment" cols="80" rows="10"><?php echo $problem['comment']; ?></textarea>
</div>

<?php include_once PATH. '/includes/footer.inc';?>
