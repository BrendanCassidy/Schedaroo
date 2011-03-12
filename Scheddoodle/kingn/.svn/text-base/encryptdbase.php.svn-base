


<?php

include_once '../web/includes/config.inc';

$result = mysql_query("SELECT * FROM users");
while ($row = mysql_fetch_array($result)){
  $pw = $row['password'];
  $newPW = md5($pw);
  echo $newPW;
  mysql_query("UPDATE users SET password='" . $newPW . "' WHERE id=" . $row['id'] . ";");
 }

?>