<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

checkPermissions();

$problem = getProblemById($_GET['problem']);

include_once PATH . '/includes/header.inc';
?>
<link type="text/css" href="../../css/jquery.ui/cupertino/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
<script src="../../js/jquery-1.4.4.min.js"></script>
<script src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript">
	    var i = 0;
  $(function(){
      $('#tabs').tabs();

        
        $.getJSON('defaults.json', function(data) {
	
		    $.each(data.days, function(i, day) {
			     $.each(day.shifts, function(i, shift) {              
				      loadShift(day.day, shift);
				    });

			   });

    });

    });
function loadShift(day, name) {
  var startTimes = '<select><option>6:00am</option><option>6:15am</option><option>6:30am</option><option>6:45am</option><option>7:00am</option><option>7:15am</option><option>7:30am</option><option>7:45am</option><option>8:00am</option><option>8:15am</option><option>8:30am</option><option>8:45am</option><option>9:00am</option></select>';

  var endTimes = '<select><option>6:00am</option><option>6:15am</option><option>6:30am</option><option>6:45am</option><option>7:00am</option><option>7:15am</option><option>7:30am</option><option>7:45am</option><option>8:00am</option><option>8:15am</option><option>8:30am</option><option>8:45am</option><option>9:00am</option></select>';
 
 var radioButtons = '<div id="radio'+i+'"><input type="radio" id="radio1" name="radio'+i+'" /><label for="radio1">Breakfast</label><input type="radio" id="radio2" name="radio'+i+'" checked="checked" /><label for="radio2">Lunch</label><input type="radio" id="radio3" name="radio'+i+'" /><label for="radio3">Dinner</label><input type="radio" id="radio4" name="radio'+i+'" /><label for="radio3">Cleanup</label></div>';

  var shiftText = '<tr><td><input type="text" value="' + name + '"></td><td>Start Time: ' + startTimes + '</td><td>End Time: ' + endTimes + '</td><td>' + radioButtons + '</td><td><input type="button" value="add" onclick="loadShift(\'' + day + '\', \'\');"></td></tr>';
  
 $("#" + day + " table").append(shiftText);
 i++;
}


function saveHours() {
  $(".hours").each(function() {
		     $.post("do.php", { "action":"saveContractedHours", "problem": <?php echo $problem['id'] ?>, "participant": $(this).attr("id"), "hours": $(this).val() }, function(data) {
			      if (data.out != 0) {alert("error");}

			    }, "json");
		   });

}

</script>
<style>
.box {font-size:x-small; }
table { width: 100%; }
</style>

<?php include_once PATH . '/includes/body.inc' ?>

<h1>Dining Hall</h1>

<div class="box">

<div id="tabs">

<ul>
<li><a href="#start">Instructions</a></li>
<li><a href="#hours">Worker Hours</a></li>
<li><a href="#sun">Sun</a></li>
<li><a href="#mon">Mon</a></li>
<li><a href="#tues">Tues</a></li>
<li><a href="#wed">Wed</a></li>
<li><a href="#thurs">Thurs</a></li>
<li><a href="#fri">Fri</a></li>
<li><a href="#sat">Sat</a></li>
<li><a href="#finish">Finish</a></li>
</ul>


<div id="start">
<p>Creating a dining hall schedule takes only three easy steps! Before completing each tab, make sure press save before moving on to the next tab.</p>

<ol>
<li>Add workers: In the “Add Workers” tab, add every worker.</li>
<li>Assign Worker Hours: Assign designated hours to each worker in the “Worker Hours” tab. For each student, this number should be based on the number of hours Carleton allows the student to work per week.</li>
<li>Add shifts: For each day of the week tab, add shifts by typing in a shift name and assigning a start time, end time, and meal to each shift.</li>
<li> Finally, confirm that you have completed all three steps in the “Finish” tab in order to submit the schedule.</li>
</ol>

</div>

<div id="hours">
<table style="width:50%;">
<?php

$participants = getParticipantsForProblem($problem['id']);

foreach ($participants as $participant) { ?>

  <tr>
  <td><?php echo getNameString($participant) ?></td>
    <td><select id="<?php echo $participant['id'] ?>" class="hours">
    <?php
    $hours = getData($problem['id'], $participant['id'], 'contractedHours');
      for ($i=0;$i<12.5;$i=$i+.5) {
        if ($i == $hours['v']) {
          echo '<option value="' . $i . '" selected>' . $i . '</option>';
        }
        else {
          echo '<option value="' . $i . '">' . $i . '</option>';
        }
      }
    ?>
  </select></td>
  </tr>
<?php } ?>
</table>

<input type="button" value="save hours" onclick="saveHours()">

</div>

<div id="sun"><table></table></div>
<div id="mon"><table></table></div>
<div id="tues"><table></table></div>
<div id="wed"><table></table></div>
<div id="thurs"><table></table></div>
<div id="fri"><table></table></div>
<div id="sat"><table></table></div>
<div id="finish"><p>Please make sure you have completed every tab in the dining hall setup.</p><p>By clicking submit below, the set-up of your schedule will be completed.</p></div>

</div>

<?php include_once PATH . '/includes/footer.inc' ?>