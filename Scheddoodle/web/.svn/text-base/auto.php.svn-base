<?php

include_once("includes/config.inc");

class custom_json {

    /**
     * Convert array to javascript object/array
     * @param array $array the array
     * @return string
     */
    public static function encode($array)
    {
        // determine type
        if(is_numeric(key($array))) {
            // indexed (list)
            $output = '[';
            for($i = 0, $last = (sizeof($array) - 1); isset($array[$i]); ++$i) {
                if(is_array($array[$i])) $output .= self::encode($array[$i]);
                else  $output .= self::_val($array[$i]);
                if($i !== $last) $output .= ',';
            }
            $output .= ']';

        } else {

            // associative (object)
            $output = '{';
            $last = sizeof($array) - 1;
            $i = 0;
            foreach($array as $key => $value) {
                $output .= '"'.$key.'":';
                if(is_array($value)) $output .= self::encode($value);
                else  $output .= self::_val($value);
                if($i !== $last) $output .= ',';
                ++$i;
            }
            $output .= '}';

        }
        return $output;
    }

    /**
     * [INTERNAL] Format value
     * @param mixed $val the value
     * @return string
     */
    private static function _val($val)
    {
        if(is_string($val)) return '"'.$val.'"';
        elseif(is_int($val)) return sprintf('%d', $val);
        elseif(is_float($val)) return sprintf('%F', $val);
        elseif(is_bool($val)) return ($val ? 'true' : 'false');
        else  return 'null';
    }
}

$return_arr = array();

/*
Thoughts on whether or not the following is bad? I guess we should put this in the sql folder with everything else, both for organization
*/

    $terms = explode(" ", $_GET['term']);

    $query = "("; // search through users
    foreach ($terms as $term) {
        $query .= "(firstNames LIKE '%" . $term . "%' OR lastNames LIKE '%" . $term . "%' OR name LIKE '%" . $term . "%') AND ";
    }
    $query = substr($query, 0, -5) . ")";
    $fetch = mysql_query("SELECT id, firstNames, lastNames, name FROM users WHERE " . $query . " ORDER BY firstNames ASC LIMIT 20");

    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
        $row_array['id'] = $row['id'];
        $row_array['value'] = $row['firstNames'] . " " . $row['lastNames'] . ' (' . $row['name'] . ')';
        $row_array['uid'] = $row['name'];
        array_push($return_arr,$row_array);
    }
    
    // search through groups
    $fetch = mysql_query("SELECT * FROM `groups` WHERE name LIKE '%" . $_GET['term'] . "%' ORDER BY name ASC");

    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
      if (!canUseGroup($row['id'], $current_user)) { continue; } // if the user cannot view the group, skip it
      $row_array['id'] = $row['id'];
      $row_array['value'] = "Group: " . $row['name'];
      $row_array['uid'] = $row['name'];
      array_push($return_arr,$row_array);
    }

echo custom_json::encode($return_arr);

?>
