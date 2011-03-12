<?php
include_once '../../includes/config.inc'; // add a wrapper so we do not have to use relative path
include_once 'functions.php';
include_once PATH . '/includes/header.inc';

checkPermissions();

if (!(isset($_GET['problem']))) { die("no problem specified"); }

$problem = getProblemById($_GET['problem']);

checkAllowedRespond($problem);

?>

<script src="<?php echo URL ?>/js/jquery-1.4.2.min.js"></script>
<script>
function save() {
  $.post("do.php", $("#respondForm").serialize(), function(data) {
	   if (data.out == 0) { window.location = '<?php echo URL ?>'; }
	   else if (data.out == 1) { alert("Someone has selected this slot before you.\n\nClick OK to reload the page."); location.reload(true); }
  }, "json");
}

</script>

<?php include_once PATH . '/includes/body.inc' ?>

<h1><?php echo $problem['name'] ?></h1>
<p><?php echo $problem['description'] ?></p>

<form id="respondForm">
    <input type="hidden" name="action" value="respond">
    <input type="hidden" name="user" value="<?php echo $current_user ?>">
    <input type="hidden" name="problem" value="<?php echo $problem['id'] ?>">
    <?php
        $resources = getAllResources($problem['id']);

        // add an indication next to slot that the responding user has chosen if they have consen a slot before
        $usedResources = getUsedResources($problem['id']);

        foreach ($resources as $resource) {
            if (isset($usedResources[$resource['id']])) {
                if ($current_user == $usedResources[$resource['id']]) { echo '<p><input type="radio" name="resources" value="' . $resource['id'] . '" checked>' . $resource['name'] . "<span style=\"color:green;\"> YOUR SAVED SELECTION</span></p>"; }
                else { echo '<p><input type="radio" name="resources" value="' . $resource['id'] . '" disabled>' . $resource['name'] . " <span style=\"color:red;\">TAKEN</span></p>"; }
            }
            else { echo '<p><input type="radio" name="resources" value="' . $resource['id'] . '">' . $resource['name'] . "</p>"; }
        }   
    ?>
    <input type="button" value="Submit" onclick="save();">
</form>

<?php include_once '../../includes/footer.inc' ?>
