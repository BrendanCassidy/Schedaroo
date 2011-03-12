<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

checkPermissions();
$inputIDs = '';
if (isset($_GET['problem'])) {
  // check to make sure the problem type is the same. if not, die with error

  $problem = getProblemById($_GET['problem']);
  // what happens when an admin deletes a resource after a user enters a preference for it
  
  if (isset($_GET['editing'])) {
    $editing=true;
  }
  else {
    $editing=false;
  }
  
  $theHTML = "";

  $resources = getResources($problem['id']);
  if ($resources['v'] == "") {
    $theHTML .= '<tr class="row" id="1"><td></td><td></td><td><input id="res" type = "text"></td><td><a href ="#" class="itemDelete" onclick="deleteField(1);"><img src="../../images/Delete.png"></a></td><tr>';
    //For now, we're doing this as a table, but this old code may come in handy as a reference and if we want to switch back.
    //$theHTML .= '<div id="dragbuttons"><ul id="sortable"><li id="1"><input id ="foo_1" type="text">[<a href="#" class="itemDelete" style="color:#b00000; text-decoration:none; "onclick="deleteField();"><img src="../../images/Delete.png"></a>]</li></ul></div>';
    $max_id=1;

  }
  else {
    $resources = preg_split('[\r\n|\n|\r]', $resources['v']);
    $max_id = 0;
    foreach($resources as $resource) {
      $resource = preg_split('[::]', $resource);
      if ($resource[0] > $max_id) {$max_id = $resource[0]; }
      $theHTML .= '<tr class="row" id = "' . $resource[0] . '"><td></td><td></td><td><input id="res" type="text" value = "' . $resource[1] . '"></td><td><a href="#" class="itemDelete" onclick="deleteField(' . $resource[0] . ');"><img src="../../images/Delete.png"></a></td></tr>';

    }

      //Extra code again
    /*
    $theHTML = '<div id="dragbuttons"><ul id="sortable">';
    foreach ($resources as $resource) {
      $resource = preg_split('[::]', $resource);
      if ($resource[0] > $max_id) { $max_id = $resource[0]; }
      $theHTML .= '<li id="' . $resource[0] . '"><input id="foo_' . $resource[0] . '" type="text" value="' . $resource[1] . '">[<a href="#" class="itemDelete" onclick="deleteField();">X</a>]</li>';
    }
    $theHTML .= "</ul></div>";
    */
  }  
 }

include_once PATH . '/includes/header.inc';

?>

<script src="<?php echo URL ?>/js/jquery-1.4.2.min.js"></script>
<script src="<?php echo URL ?>/js/jquery-ui-1.8.6.custom.min.js"></script>
<script>
$(document).ready(function() {
		    

		    $("form").submit(function() {
				       var string = "";
				       $("#resource-table input[id*='res']").each(function() {
										    string = string + $(this).parent().parent().attr('id') + "::" + $(this).val() + "\n";
							
										  });
				       string = string.substring(0, string.length-1);
				       $("#data").val(string);

				       //var myArray = $('#sortable').sortable('toArray');
				       //var string = "";
				       //for (var i=0, len=myArray.length; i<len; ++i) {
				       //string = string + myArray[i].toString() + '::' + $("#foo_" + myArray[i].toString()).val() + "\n";
				       
				     });

		  });

// should this be inside the document.ready thing?
var max_id = <?php echo $max_id + 1; ?>;

function addField() {
  $("#resource-table").append('<tr class="row" id="' + max_id + '"><td></td><td></td><td><input id = "res" type = "text"></td><td><a href ="#" class="itemDelete" onclick="deleteField(' + max_id + ');"><img src="../../images/Delete.png"></a></td><tr>');

//  $("#sortable").append('<li id="' + max_id + '"><span><input id ="foo_' + max_id + '" type="text">[<a href="javascript:void()" class="itemDelete" style="color:#b00000; text-decoration:none; "onclick="deleteField();">X</a>]</span></li>');
  max_id++;
}

function deleteField(row_id) {
  $("#" + row_id).remove();
}

</script>

<style>
    h1 { text-align:center; }
    h2 { margin-bottom: 0; } 
    table.center {margin-left:auto; margin-right:auto;}
    tr.row { border-bottom: 1px solid black;}
    input {font-size: 18px;
           text-align: right;
    }
    //body {text-align:center;}
    #block {
        text-align:center;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
    }
    #num {
display:block;
        text-align:auto;
        width: 50%;
        margin-left:auto;
        margin-right:auto;
        margin-top: 40px;
        background-color: #CCCCCC;
        border: 1px solid black;
}
.button { font-size:2em;}
</style>

<?php include_once PATH . '/includes/body.inc' ?>

<h1><?php echo 'Editing resources for ' . $problem['name']; ?></h1>

<div id="num">
<form name="start" onSubmit="prepPage();">
<p>Resource set-up</p>
<li><label>Number of resources: <input name="numres" type="int" value=1 min=1 max=50></label><br>
<li><label>Select resource input type: <input type="checkbox" name="type" value="text"> text <input type="checkbox" name="type" value="date"> date <input type="checkbox" name="type" value="time"> time</label>
</form>
</div>

<form name="form" method="post" action="process.php">
<input type="hidden" name="action" value="edit_problem_structure">
<input type="hidden" name="admin" value="<?php echo $_COOKIE['user'] ?>">
<input type="hidden" name="algorithm" value="<?php print $algorithm['id'] ?>">
<input type="hidden" name="problem" value="<?php echo $problem['id'] ?>">
<input type="hidden" name="data" id="data">

<div id="block">

<p>
Enter the names of the resources you are trying to schedule.
<table id="resource-table" class="center">
      <tr align=right><td colspan=4><input type="button" style="font-size:1em" value="Add Resource" onclick="addField();"></td></tr>
<?php echo $theHTML;?>
</table>

</p>

<p>
<input type="button" class="button" onclick="window.location='<?php echo URL . '/problem.php?problem=' . $_GET['problem'] ?>';" value="<- previous step"><input type="submit" class="button" value="done!">
</p>

<?php drawNotifyButton($problem['id']) ?>
</div>

</form>
<?php include_once PATH . '/includes/footer.inc' ?>
