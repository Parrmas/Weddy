<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle CRUD operations for shifts
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add shift
    if (isset($_POST['add_shift'])) {
        $shift_name = $_POST['shift_name'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        // Insert the new shift into the database
        // Add your database code here
    }

    // Edit or Delete shift
    if (isset($_POST['action']) && isset($_POST['shift_id'])) {
        $action = $_POST['action'];
        $shift_id = $_POST['shift_id'];

        if ($action === 'edit') {
            $updated_shift_name = $_POST['updated_shift_name'];
            $updated_start_time = $_POST['updated_start_time'];
            $updated_end_time = $_POST['updated_end_time'];
            // Update the shift in the database
            // Add your database code here
        } elseif ($action === 'delete') {
            // Delete the shift from the database
            // Add your database code here
        }
    }
}

// Fetch shifts from the database
// Add your database code here to retrieve the shifts
$shifts = [
    ['id' => 1, 'shift_name' => 'Morning', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
    ['id' => 2, 'shift_name' => 'Afternoon', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
    ['id' => 3, 'shift_name' => 'Evening', 'start_time' => '18:00:00', 'end_time' => '21:00:00'],
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shift Management</title>
</head>
<body>
    <h1>Shift Management</h1>

    <h2>Add Shift</h2>
    <form method="POST" action="">
        <input type="text" name="shift_name" placeholder="Shift Name" required>
        <input type="time" name="start_time" required>
        <input type="time" name="end_time" required>
        <button type="submit" name="add_shift">Add</button>
    </form>

    <h2>Edit/Delete Shift</h2>
    <table>
        <tr>
            <th>Shift ID</th>
            <th>Shift Name</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
        </tr>
        <?php foreach ($shifts as $shift) : ?>
            <tr>
                <td><?= $shift['id']; ?></td>
                <td><?= $shift['shift_name']; ?></td>
                <td><?= $shift['start_time']; ?></td>
                <td><?= $shift['end_time']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="shift_id" value="<?= $shift['id']; ?>">
                        <input type="text" name="updated_shift_name" placeholder="Updated Shift Name" required>
                        <input type="time" name="updated_start_time" required>
                        <input type="time" name="updated_end_time" required>
                        <button type="submit" name="action" value="edit">Update</button>
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
