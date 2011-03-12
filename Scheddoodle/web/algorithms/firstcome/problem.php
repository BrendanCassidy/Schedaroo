<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

checkPermissions();

if (!isset($_GET['problem'])) { die ("no problem specified"); }

$problem = getProblemById($_GET['problem']);

checkAllowedEdit($problem);

$theHTML = '';

$resources = getAllResources($problem['id']);

if (empty($resources)) {
    $theHTML .= '<li id="1">';
    $theHTML .= '<input type="text" value="e.g. Monday 10:15 AM" onclick="if(this.value==\'e.g. Monday 10:15 AM\'){this.value=\'\';}">';
    $theHTML .= '<a href="javascript:void(0);" onclick="addField(1);"><img src="../../images/add.png"></a>';
    $theHTML .= '<a href="javascript:void(0);" onclick="deleteField(1);"><img src="../../images/delete.png"></a>';
    $theHTML .= '<img src="../../images/drag.png">';
    $theHTML .= '</li>';
    $theHTML .= '<li id="2">';
    $theHTML .= '<input type="text" value="e.g. Monday 10:15 AM" onclick="if(this.value==\'e.g. Monday 10:15 AM\'){this.value=\'\';}">';
    $theHTML .= '<a href="javascript:void(0);" onclick="addField(2);"><img src="../../images/add.png"></a>';
    $theHTML .= '<a href="javascript:void(0);" onclick="deleteField(2);"><img src="../../images/delete.png"></a>';
    $theHTML .= '<img src="../../images/drag.png">';
    $theHTML .= '</li>';
    $theHTML .= '<li id="3">';
    $theHTML .= '<input type="text" value="e.g. Monday 10:15 AM" onclick="if(this.value==\'e.g. Monday 10:15 AM\'){this.value=\'\';}">';
    $theHTML .= '<a href="javascript:void(0);" onclick="addField(3);"><img src="../../images/add.png"></a>';
    $theHTML .= '<a href="javascript:void(0);" onclick="deleteField(3);"><img src="../../images/delete.png"></a>';
    $theHTML .= '<img src="../../images/drag.png">';
    $theHTML .= '</li>';
  
    $max_id = 3;
}

else {
    $max_id = 0;
    $theHTML = '';

    foreach ($resources as $resource) {
        if ($resource['id'] > $max_id) { $max_id = $resource['id']; }
        $theHTML .= '<li id="' . $resource['id'] . '">';
        $theHTML .= '<input type="text" value="' . $resource['name'] . '">';
        $theHTML .= '<a href="javascript:void(0);" onclick="addField(' . $resource['id'] . ');"><img src="../../images/add.png"></a>';
        $theHTML .= '<a href="javascript:void(0);" onclick="deleteField(' . $resource['id'] . ');"><img src="../../images/delete.png"></a>';
	$theHTML .= '<img src="../../images/drag.png">'; 
        $theHTML .= '</li>';
    }
}  

include_once PATH . '/includes/header.inc';

?>

<script src="<?php echo URL ?>/js/jquery-1.4.4.min.js"></script>
<script src="<?php echo URL ?>/js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="problem.js"></script>
<link type="text/css" href="../../css/jquery.ui/cupertino/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
<link type="text/css" href="style.css" rel="stylesheet" />

<script>
var max_id = <?php echo $max_id + 1; ?>;
</script>

<?php include_once PATH . '/includes/body.inc' ?>

<h1><?php echo $problem['name']; ?></h1>

<h3 style="text-align:center;">Add Resources</h3>
<div id="dragbuttons"><ul id="sortable"><?php echo $theHTML ;?></ul></div>
<div style="text-align: center;"><?php drawNotifyButton($problem['id']) ?></div>
<div style="text-align:center;"><input type="button" id="saveButton" onclick="saveTimeSlots(<?php echo $problem['id'] ?>);" value="Save"><input type="button" onclick="window.location='../../problems.php'" value="Discard Changes"></div>

<?php include_once PATH . '/includes/footer.inc' ?>