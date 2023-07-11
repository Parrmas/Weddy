<?php
 $db = mysqli_connect('localhost', 'aroayrma_preservation', 'Admin123$%') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'aroayrma_preservation' ) or die(mysqli_error($db));

        function get_value($mysqli, $sql) {
                $result = $mysqli->query($sql);
                $value = $result->fetch_array(MYSQLI_NUM);
                return is_array($value) ? $value[0] : "";
            }
?>