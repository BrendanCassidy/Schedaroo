<?php
include_once 'includes/config.inc';
include_once 'includes/header.inc';
if (isset($_GET['redirect'])) { $redirect = $_GET['redirect']; }
else { $redirect = "problems.php"; }
if (isset($_GET['message'])) { $message = $_GET['message']; }
else { $message = 0; }
?>

<script src="js/jquery-1.4.2.min.js"></script>
<script src="js/login.js"></script>

<?php include_once 'includes/body.inc' ?>

<?php
if ($message == 1) {
    echo '<div id="output" style="display:block;">This account is already activated. Try our forgot password link if you cannot remember your password.</div>';
}
else if ($message == 2) {
    echo '<div id="output" style="display:block;">Your account has been successfully activated. Check your Carleton email for your login information.</div>';
}
else if ($message == 3) {
    echo '<div id="output" style="display:block;">An email has been sent to your account with a new password. </div>';
}

?>

<form id="centerForm" onSubmit="login('<?php echo $redirect ?>'); return false;">
<span id="autherror" class="error" style="text-align:center"></span>
<table>
    <tr><td>Username</td><td><input type="text" name="user"></td></tr>
    <tr><td>Password</td><td><input type="password" name="password"><span id="error" class="error">Incorrect Password</span></td></tr>
    <tr><td colspan="2"><input type="submit" value="Login"></td></tr>
    <tr><td colspan="2"><font size="2"><a href="authenticateaccount.php">First time here?</a></font></td></tr>
    <tr><td colspan="2"><font size="2"><a href="forgotpassword.php">Forgot Your Password?</a></font></td></tr>
</table>
</form>

<?php include_once 'includes/footer.inc' ?>
