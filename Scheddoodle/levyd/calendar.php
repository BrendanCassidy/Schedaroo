<html>
<head>

<script src="http://cs-research1.mathcs.carleton.edu/scheddoodle/sched-doodle/web/js/jquery-1.4.2.min.js"></script>

<script>

jQuery.fn.disableTextSelect = function() {
   return this.each(function() {
		      $(this).css({
			  'MozUserSelect' : 'none'
			    }).bind('selectstart', function() {
				      return false;
				    }).mousedown(function() {
						   return false;
						 });
		    });
 };


$(document).ready(function() {

		    $('#table').disableTextSelect();

		    var mouseState = 0;
		    var isSelecting = 0;

		    $('.slot').mousedown(function() {
					   mouseState = 1;   
					   if  ($(this).hasClass('down')) {
					     isSelecting = 0;
					     $(this).removeClass('down');
					   }
					   else {
					     isSelecting = 1;
					     $(this).addClass('down');
					   }
					 });
		    $(document).mouseup(function() { mouseState = 0; });

		    $('.slot').mouseover(function() {
					   if (mouseState) {
					     if  (isSelecting) {
					       $(this).addClass('down');
					     }
					     else {
					       $(this).removeClass('down');
					     }

					   }

					 });



		  });

function apply() {
  var startDate = $('#startDate').val();
  var endDate = parseInt($('#endDate').val());
  var startTime = $('#startTime').val();
  var endTime = parseInt($('#endTime').val());
  var row;

  row = '<tr>';

  for (i=startDate;i<endDate+1;i++) {
    row = row + '<td>' + i + '</td>';
  }

  row = row + '</tr>';

  $('#table').html(row);

  for (j=startTime;j<endTime+1;j++) {
    row = '<tr>';

    for (i=startDate;i<endDate+1;i++) {
      row = row + '<td>' + j + '</td>';
    }
    row = row + '</tr>';

    $('#table tr:last').after(row);
    $('#table tr:last').addClass('slot');;

  }

}

</script>

<style>

.down { background: #CCCCCC; }

</style>

</head>

<body>

Start Date: <input type="text" id="startDate"><br>
End Date:<input type="text" id="endDate"><br>
Start Time: <input type="text" id="startTime"><br>
End Time:<input type="text" id="endTime"><br>

<input type="button" value="apply" onclick="apply()">

<table id="table" border="1">
<?php



for ($i=0;$i<5;$i++) {

  echo '<tr>';
  
  for ($j=0;$j<5;$j++) {
    echo '<td class="slot">9:00</td>';

  }
  echo '</tr>';

}

?>

</table>

</body>
</html>