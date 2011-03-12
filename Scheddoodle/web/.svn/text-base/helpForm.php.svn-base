<?php
include_once 'includes/config.inc';

checkPermissions();

include_once 'includes/header.inc';
include_once 'includes/body.inc';
?>

<div id="right">
<h1>Feedback Form</h1>

<p>Thank you for taking the time to help us improve our site. Please respond to the following
questions to the best of your ability. We would love to meet with you in person if you would 
like to provide more specific input.</p>

<form action="helpFormResults.php" method="post">
<ol>
<li><p>Name <input type="text" name="name" value="<?php echo getNameString(getUserById($current_user)) ?>" size="40" disabled></p></li>
<li>
    <p>What changes would you like see made to our site?</p>
    <p><textarea name="improvements" rows="10" cols="80"></textarea></p>
</li>
</ol>

<p style="text-align:center;"><input type="submit" value="Submit"></p>

</form>
</div>

<?php include_once 'includes/footer.inc' ?>