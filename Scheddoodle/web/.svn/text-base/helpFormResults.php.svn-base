<?php
include_once 'includes/config.inc';
include_once 'includes/header.inc';
include_once 'includes/body.inc';
?>

<h1>Feedback Form Submitted!</h1>

<?php
	$to = "elfmanw@carleton.edu, levyd@carleton.edu, cassidyb@carleton.edu, kingn@carleton.edu, martint@carleton.edu, smithc@carleton.edu";

	$headers = "From: Schedaroo Feedback <schedaroo@carleton.edu>";
	$subject = "Schedaroo Feedback from $name";

	$body = "Name: $_POST[name] \n\n"
			. "Requested improvements:\n\n$_POST[improvements]\n\n\n";

	if( mail( $to, $subject, $body, $headers ) )
	{
		echo '<div style="width:90%; margin-left:auto; margin-right:auto;">';
		echo nl2br(htmlentities($body));
		echo '</div>';
	}
	else
	{
		echo("\n\nAn error has occured.  Please try again later.\n");
		?>
		
		<a href="helpForm.php">Return to Feedback Page</a>
		<?php
	}
?>

<?php include_once PATH .'/includes/footer.inc' ?>
