<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle CRUD operations for types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add type
    if (isset($_POST['add_type'])) {
        $type = $_POST['type'];
        // Insert the new type into the database
        // Add your database code here
    }

    // Edit or Delete type
    if (isset($_POST['action']) && isset($_POST['type_id'])) {
        $action = $_POST['action'];
        $type_id = $_POST['type_id'];

        if ($action === 'edit') {
            $updated_type = $_POST['updated_type'];
            // Update the type in the database
            // Add your database code here
        } elseif ($action === 'delete') {
            // Delete the type from the database
            // Add your database code here
        }
    }
}

// Fetch types from the database
// Add your database code here to retrieve the types
$types = [
    ['id' => 1, 'type' => 'Type 1'],
    ['id' => 2, 'type' => 'Type 2'],
    ['id' => 3, 'type' => 'Type 3'],
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Type Management</title>
</head>
<body>
    <h1>Type Management</h1>

    <h2>Add Type</h2>
    <form method="POST" action="">
        <input type="text" name="type" placeholder="Type" required>
        <button type="submit" name="add_type">Add</button>
    </form>

    <h2>Edit/Delete Type</h2>
    <table>
        <tr>
            <th>Type ID</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <?php foreach ($types as $type) : ?>
            <tr>
                <td><?= $type['id']; ?></td>
                <td><?= $type['type']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="type_id" value="<?= $type['id']; ?>">
                        <input type="text" name="updated_type" placeholder="Updated Type" required>
                        <button type="submit" name="action" value="edit">Update</button>
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
