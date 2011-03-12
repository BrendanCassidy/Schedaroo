<?php

include_once '../../includes/config.inc';
include_once 'functions.php';

checkPermissions();


include_once PATH . '/includes/header.inc';
include_once PATH . '/includes/body.inc';

?>

<h1>Worker Hours</h1>
<table style="width:50%;">
<?php for ($m=0;$m<10;$m++): ?>
   <tr><td>Worker <?php echo $m ?></td><td><select><?php for ($i=0;$i<12.5;$i=$i+.5) { if ($i == 10) { echo '<option selected>' . $i . '</option>'; } else { echo '<option>' . $i . '</option>'; } } ?></select></td></tr>
<?php endfor; ?>
<table>

<?php
include_once PATH . '/includes/footer.inc';

?>