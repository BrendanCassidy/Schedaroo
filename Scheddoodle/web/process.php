<?php

include_once 'includes/config.inc';
include_once 'includes/header.inc';
include_once 'includes/body.inc';

switch ($_POST['action']) {
    case "add_problem":
        if ($_POST['expiration_toggle'] == "timed") { $expires = $_POST['expiration_time']; }
        else { $expires = null; }
        addProblem($_POST['name'], $_POST['algorithm'], $_POST['admin'], $_POST['description'], $expires);
        $problem_id = mysql_insert_id();
        $participants = splitOnNewLines($_POST['participants']);      
        $goodUsers = array();
        $badUsers = array();
        $repeatedUsers = array();
        foreach ($participants as $participant) {
            $user = getUserByName($participant);
            if ($user) {
                if (addUserToProblem($problem_id, $user['id'])) {
                    $repeatedUsers[] = $participant;
                }
                else {
                    $goodUsers[] = $participant;
                }
            }
            else {
                $badUsers[] = $participant;
            }
        }
        echo "<h1>Added: " . $_POST['name'] . "</h1>";
        if (!empty($goodUsers)) {
            echo  "<h2>Added Participants:</h2>";
            echo "<ul>";
            foreach ($goodUsers as $goodUser) {
                echo "<li>" . $goodUser . "</li>";
            }
            echo "</ul>";
        }
        if (!empty($repeatedUsers)) {
            echo  "<h2>You Tried to Add the Following Duplicate Participants:</h2>";
            echo "<ul>";
            foreach ($repeatedUsers as $repeatedUser) {
                echo "<li>" . $repeatedUser . "</li>";
            }
            echo "</ul>";
        } 
        
        if (!empty($badUsers)) {
            echo "<h2>Failed to add these participants:</h2>";
            echo "<ul>";
            foreach($badUsers as $badUser) {
                echo "<li>" . $badUser . "</li>";
            }
            echo "</ul>";
        }
	$algorithm = getAlgorithmById($_POST['algorithm']);
	$algorithmSlug = $algorithm['slug'];
	echo '<a href="' . URL . '/algorithms/' . $algorithmSlug . '/problem.php?problem=' . $problem_id . '">Next</a>';
	//echo '<a href="' . URL . '/problem.php?problem=' . $problem_id  . '">Next</a>';
        break;

    case "add_user": 
      if ($_POST['password1'] == $_POST['password2']) {
	if (addUser($_POST['name'], $_POST['email'], $_POST['password1'])) {
	  echo "added user: " . $_POST['name'];
        }
        else { echo "user already exists"; }
      } else {
	echo "non-matching passwords given";
      }
      break;

    case "update_preferences":
        updatePreferences($_POST['problem'], $_POST['user'], $_POST['resources']);
        markResponded($_POST['problem'], $_POST['user']);
        break;
        
    case "update_problem":
        $removedUsers = array();  
        $goodUsers = array();
        $badUsers = array();
        $repeatedUsers = array();

        foreach ($_POST['existing_participants'] as $hide) {
            if ($hide != 'skip') {
                removeUserFromProblem($_POST['problem'], $hide);
                $removedUser = getUserById($hide);
                $removedUsers[] = $removedUser['name'];
            }
        }
        $new_participants = splitOnNewLines($_POST['participants']);
        if ($new_participants != NULL) {
            foreach ($new_participants as $new_participant) {
                    $user = getUserByName($new_participant);
                    if ($user) {
                        if (addUserToProblem($_POST['problem'], $user['id'])) {
                        $repeatedUsers[] = $new_participant;
                        }
                        $goodUsers[] = $new_participant;
                    }
                    else {
                        $badUsers[] = $new_participant;
                    }
            }
        }
        if ($_POST['expiration_toggle'] == "timed") { $expires = $_POST['expiration_time']; }
        else { $expires = null; }

        updateProblem($_POST['problem'], $_POST['name'], $_POST['admin'], $_POST['description'], $expires);

        echo "<h1>Updated: " . $_POST['name'] . "</h1>";
        if (!empty($goodUsers)) {
            echo  "<h2>Added Participants:</h2>";
            echo "<ul>";
            foreach ($goodUsers as $goodUser) {
                echo "<li>" . $goodUser . "</li>";
            }
            echo "</ul>";
        }
        if (!empty($repeatedUsers)) {
            echo "<h2>You Tried to Add the Following Duplicate Participants:</h2>";
            echo "<ul>";
            foreach ($repeatedUsers as $repeatedUser) {
                echo "<li>" . $repeatedUser . "</li>";
            }
            echo "</ul>";
        }
        if (!empty($badUsers)) {
            echo "<h2>Failed to add these participants:</h2>";
            echo "<ul>";
            foreach($badUsers as $badUser) {
                echo "<li>" . $badUser . "</li>";
            }
            echo "</ul>";
        }
        if (!empty($removedUsers)) {
            echo "<h2>Removed Particpants:</h2>";
            echo "<ul>";
            foreach($removedUsers as $removedUser) {
                echo "<li>" . $removedUser . "</li>";
            }
            echo "</ul>";
        }
	echo '<a href="' . URL . '/problem.php?problem=' . $_POST['problem']  . '">Okay</a>';
        break;
           
    case "delete_problem":
      $problem = getProblemById($_POST['problem']);
      $problemName = $problem['name'];
	deleteProblem($_POST['problem']); 
        header('Location: problems.php?output=deleted problem: ' . $problemName);
        break;

 case "login": // make it so if you are an active user, the cookie will not expire
        $user = getUserByName($_POST['user']);
        if (!(empty($user))) {
	  if ($user['password'] == $_POST['password']) {
            setcookie("user", $user['id'], time()+100000);
            if ($_POST['redirect']) {
                echo '<script>window.location="' . $_POST['redirect']  . '";</script>';
            }
            else {
	      echo '<script>window.location="problems.php";</script>';
            }
	  }
	  else {
	    echo "incorrect password";
	  }
        }
        else { echo "not a valid username"; }
        break;

case "update_password":
  if (isset($_COOKIE['user'])){
    $user = $_COOKIE['user'];
    $oldPass = $_POST["oldpass"];
    $newPass = $_POST["newpass"];
    //$oldPass = md5($_POST["oldpass"]);
    //$newPass1 = md5($_POST["newpass"]);
    //$newPass2 = md5($_POST["rnewpass"]);
    if (checkPassword($oldPass, $user)) {
	setPassword($newPass,$user);
	echo("Password successfully changed");
      }
    //We should do this with javascript in the same way we check to confirm new password.
    else {
      echo("Password is not correct");  
     
    }
  }
  else {
    echo "No user logged in";
  }
  break;


    case "mark_unread":
        markUnread($_POST['problem'], $_POST['user']);
        break;

    case "mark_many_unread":
        foreach($_POST['checkboxes'] as $problem) {
            markUnread($problem, $_POST['user']);
        }
        break;

    case "mark_many_read":
        foreach($_POST['checkboxes'] as $problem) {
            markRead($problem, $_POST['user']);
        }
        break;

    case "mark_responded":
        markResponded($_POST['problem'], $_POST['user']);
        break;

    default:
        print "NO ACTION SPECIFIED";
        break;
}

include_once 'includes/footer.inc';

?>