<?php

########################################################################
## USERS
########################################################################

function addUser($name, $email, $password) { // change the return values
    $name = sanitize($name);
    $email = sanitize($email); // maybe use filter_var($email, FILTER_SANITIZE_EMAIL)
    $password = sanitize($password);
    if (!getUserByName($name)) {
      $query = sprintf("INSERT INTO `users` (`name`, `email`, `password`) VALUES ('%s', '%s', '%s')", $name, $email, $password);
        mysql_query($query);
        return 1;
    }
    else {
        return 0; // in the case that the name already exists in the database
    }
}

// returns a user object as identified by its id
function getUserById($id) {
    $result = mysql_query("SELECT * FROM `users` WHERE id=$id");
    return mysql_fetch_array($result);
}

// returns a user object as identified by its username
function getUserByName($name) {
    $name = sanitize($name);
    $query = sprintf("SELECT * FROM `users` WHERE name='%s'", $name);
    $result = mysql_query($query);
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 1) { return mysql_fetch_array($result); }
    else if ($num_rows == 0) { // return 0 if we cannot find the user
        return 0;
    }
    else {
        print "something is wrong in the users database";
        return 1;
    }
}

// returns a string for a user
function getNameString($user) {
  if ($user['firstNames'] && $user['lastNames'] && $user['name']) {
    return $user['firstNames'] . ' ' . $user['lastNames'] . ' (' . $user['name'] . ')';
  }
  else { return "--"; }
}

########################################################################
## ACCOUNT ACTIVATION
########################################################################

function getActivatedByName($name) {
  $name=sanitize($name);
  $query=sprintf("SELECT * FROM users WHERE name='%s'",$name);
  $result=mysql_query($query);
  $num_rows = mysql_num_rows($result);
  if ($num_rows == 1) {
    $val = mysql_fetch_array($result);
    return $val['activated'];
  }
  else if ($num_rows == 0) {return -1;} //hopefully we won't ever have -1 as a legitimate entry in the d-base
  else {
    print "something is wrong in the users database";
    return -2;
  }
}

function activateUser($name) {
  $name=sanitize($name);
  $pw = generateRandomPassword();
  $encryptedPW = md5($pw);
  $to = $name . "@carleton.edu";

  $headers = "From: Scheddoodle <scheddoodle@carleton.edu>";
  $subject = "Scheddoodle Account Activation";
   
  $body = "Welcome to Scheddoodle. Your account was successfully activated. The following is your login information.\n\n\tUsername: "
    . $name . "\n\tPassword: " . $pw . "\n\n"
    . "You can log into Scheddoodle with the above information, after which you are free to change your password to something more memorable (although you do not have to use your regular Carleton password). Happy scheduling!\n\n"
    . "Click Below to Go to Scheddoodle\n" . URL;

  if (mail($to, $subject, $body, $headers)) {
    setPasswordByName($encryptedPW,$name);
    $query=sprintf("UPDATE users SET activated=1 WHERE name='%s'", $name);
    return mysql_query($query);
  }
  else { return 0; }
}

########################################################################
## PASSWORDS
########################################################################

function generateRandomPassword($numChars=8) {
  $password = "";
  for ($i = 0; $i<$numChars; $i++) {
    $val = rand(0,51);
    if ($val < 10) {
      $password .= $val;
    }
    else if ($val > 35) {
      $password .= chr(61 + $val);
    }
    else {
      $password .= chr(55 + $val);
    }
  }
  return $password;
}

function encryptPassword($password) {
    $ePass = md5($password);
    return $ePass;
}

function checkPassword($password, $userId) {
    $password = sanitize($password);
    $curPass = mysql_query("SELECT `password` FROM `users` WHERE id = $userId");
    $curPass = mysql_fetch_row($curPass);
    $curPass = $curPass[0];
    if ($password == $curPass) { return true; }
    else { return false; }
}

function confirmPassword($password1, $password2) {
  if ($password1 == $password2) {
    return true;
  }
  else {
    return false;
  }
}


//encrypt text before it gets to this function
function setPassword($encryptedText, $userId) {
    $encryptedText = sanitize($encryptedText);
    mysql_query("UPDATE `users` SET password ='" . $encryptedText . "' WHERE id = '". $userId . "'");
}

function setPasswordByName($encryptedText, $userName) {
    $encryptedText = sanitize($encryptedText);
    mysql_query("UPDATE `users` SET password ='" . $encryptedText . "' WHERE name = '". $userName . "'");
}

function emailNewPasswordByName($userName) {
  $name=sanitize($userName);
  $pw = generateRandomPassword();
  $encryptedPW = md5($pw);
  $to = $name . "@carleton.edu";

  $headers = "From: Scheddoodle <scheddoodle@carleton.edu>";
  $subject = "Scheddoodle Password Reset";
   
  $body = "We received a request to reset your Scheddoodle password. You can now use the following information to log into Scheddoodle. at " . URL . "\n\n\tUsername: "
    . $name . "\n\tPassword: " . $pw . "\n\n";

  if (mail($to, $subject, $body, $headers)) {
    setPasswordByName($encryptedPW,$name);
  }
  else { return 0; }
}


?>