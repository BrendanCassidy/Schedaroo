<?php
include_once '../../includes/config.inc';
include_once 'functions.php';
checkPermissions();
include_once PATH . '/includes/header.inc';
include_once PATH . '/includes/body.inc';
?>

<style>

#availableTable {
margin-right: 100px;

width:250px;
text-align:center;
background-color: lightblue;
}

#myHeaders{
border-bottom: black solid thin;
border-top: black solid thin;
border-left: black solid thin;
border-right: black solid thin;
}
</style>

<h1>Add Workers</h1><br>


<div style="width: 300px; height: 200px; overflow: scroll; border: 5px gray; background-color: lightblue;margin-right:50px; margin-left:auto">

<table id="availableTable">
<tr>
<th id="myHeaders">Worker</th>
<th id="myHeaders">Available Hours</th>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
<tr>
<td>Wes Elfman</td>
<td>10</td>
</tr>
</table>
</div>

<?php
include_once PATH . '/includes/footer.inc';
?>

