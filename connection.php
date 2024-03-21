<?php
 $db = mysqli_connect('localhost', 'lbtpdijm_weddy', 'Admin@123$%') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'lbtpdijm_weddy' ) or die(mysqli_error($db));

        function get_value($mysqli, $sql) {
                $result = $mysqli->query($sql);
                $value = $result->fetch_array(MYSQLI_NUM);
                return is_array($value) ? $value[0] : "";
            }
?>