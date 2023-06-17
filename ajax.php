<?php
include 'connection.php';

$date = date_create_from_format("d/m/Y", $_GET['date']);
$date_formatted = date_format($date,"Y-m-d");
$type = $_GET['type'];

$query = "SELECT shifts.id, shifts.shift_name FROM shifts INNER JOIN bookings ON shifts.id = bookings.shift_id AND bookings.date = '$date_formatted' AND bookings.type_id = '$type'";
$shifts = mysqli_query($db, $query) or die(mysqli_error($db));

$data = [];

while($row = mysqli_fetch_array($shifts)){
    array_push($data, $row['id']);
}    

echo json_encode(array('success' => 1, 'data' => $data));
?>