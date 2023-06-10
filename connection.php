<?php
 $db = mysqli_connect('localhost', 'aroayrma_preservation', 'Admin123$%') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'aroayrma_preservation' ) or die(mysqli_error($db));
?>