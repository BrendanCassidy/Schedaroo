
<?php

include_once '../web/includes/config.inc';

$name = $_POST["name"];
echo $name;
echo $_POST["password"];
$newPW = md5($_POST["password"]);
$result = mysql_query("UPDATE users SET password='" . $newPW . "' WHERE name='" . $name . "'");
echo $result;

?>