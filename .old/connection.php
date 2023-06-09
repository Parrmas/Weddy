<?php
 $db = mysqli_connect('localhost', 'id20849334_root', 'Admin123$%') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'id20849334_preservation_system' ) or die(mysqli_error($db));
?>