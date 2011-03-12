<?php
include_once '../../includes/config.inc';
include_once 'functions.php';
include_once PATH . '/includes/header.inc';

checkPermissions();

if (!(isset($_GET['problem']))) { die("no problem specified"); }

$problem = getProblemById($_GET['problem']);

checkAllowedRespond($problem);

$participants = getParticipantsForProblem($problem['id']);

?>

<style>
.ldapImg { opacity:0.4; filter:alpha(opacity=40); }
</style>

<script>

var selected = [];

$(document).ready(function () {
    $(".ldapImg").click(function() {
        var i = jQuery.inArray($(this).attr("id"), selected);
        if (i != -1) {
            $(this).animate({ opacity: 0.4 }, 100);
            selected.splice(i, 1);
        }
        else {
            $(this).animate({ opacity: 1.0 }, 100);
            selected.push($(this).attr("id"));
	}
    });
});

function savePrefs() {
		   alert("Selected ids " + selected);
}

</script>

<?php include_once '../../includes/body.inc' ?>
<h1><?php echo $problem['name'] ?></h1>

<p style="width:70%;"><?php echo $problem['description'] ?></p>

<form onSubmit="savePrefs(); return false;">
<table>
<?php
$perRow = 5;
$x = 0;

foreach ($participants as $participant) {
  if ($x == 0) { echo '<tr>'; }

  echo '<td><img class="ldapImg" id="' . $participant['id'] . '" src="http://apps.carleton.edu/stock/ldapimage.php?id=' . $participant['name'] . '" width="100" height="100"><br>' . getNameString($participant) . "</td>\n";

  if ($x == $perRow) { echo '</tr>'; $x = 0; }
  $x++;
}
?>
</table>
<input type="submit" value="Submit">
</form>

<?php include_once '../../includes/footer.inc' ?>
