<?php

########################################################################
## ALGORITHM FUNCTIONS
########################################################################

function getAlgorithmById($algorithm) {
    $algorithm = sanitize($algorithm);
    $query = sprintf("SELECT * FROM `algorithms` WHERE id=%d", $algorithm);
    $result = mysql_query($query);
    return mysql_fetch_array($result);
}

function getAlgorithmFromProblem($problem_id) {
    $problem_id = sanitize($problem_id);
    $query = sprintf("SELECT * FROM `problems` WHERE id=%s", $problem_id);
    $result = mysql_query($query);
    $problem = mysql_fetch_array($result);
    return getAlgorithmById($problem['algorithm']);
}

?>