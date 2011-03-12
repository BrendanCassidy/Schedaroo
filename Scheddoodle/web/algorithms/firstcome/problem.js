
$(document).ready(function() {
    $("#sortable").sortable();
    
    $("input").change(function() {
        activateSave();
    });


    $("input").keyup(function() { 
        activateSave();
    });

});

function activateSave() {
  $("#saveButton").val("Save");
  $("#saveButton").attr("disabled", false);
}

function getFieldText() {
  var text = '<li id="' + max_id + '">';
  text = text + '<input type="text">';
  text = text + '<a href="javascript:void(0);" onclick="addField(' + max_id + ');"><img src="../../images/add.png"></a>';
  text = text + '<a href="javascript:void()" onclick="deleteField(' + max_id + ');"><img src="../../images/delete.png"></a>';
  text = text + '<img src="../../images/drag.png">';
  text = text + '</li>';
  return text;
}

function parseResources() {
  var myArray = $("#sortable").sortable('toArray');
  var string = "";
  for (var i=0,len=myArray.length;i<len;++i) {
    string = string + myArray[i].toString() + '::' + $("#sortable  #" + myArray[i].toString() + " input").val() + "\n";
  }
  string = string.substring(0, string.length-1);
  return string;
}

function saveTimeSlots(problem) {
  var resources = parseResources();
  $.post("do.php", { "problem": problem, "action":"update_resources", "resources": resources }, function(data) {
      if (data.error) { alert("an error has occured"); }
      else {
	$("#saveButton").val("Saved");
        $("#saveButton").attr("disabled", true);
        window.location='../../problems.php';
      }
  });
}

function addField(id) {
    if (id) { $("#sortable #" + id).after(getFieldText()); }
    else { $("#sortable").append(getFieldText()); }
    $("#sortable #" + max_id).hide().slideDown("fast");
    activateSave();
    max_id++;
}

function deleteField(resource) {
    var numItems = $("#sortable li").length;
    if (numItems == 1) { return; }
    $("#sortable #" + resource).slideUp("fast", function() { $("#sortable #" + resource).remove(); });
    activateSave();
}
