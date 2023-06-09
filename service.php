<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle CRUD operations for services
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add service
    if (isset($_POST['add_service'])) {
        $service_name = $_POST['service_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        // Insert the new service into the database
        // Add your database code here
    }

    // Edit or Delete service
    if (isset($_POST['action']) && isset($_POST['service_id'])) {
        $action = $_POST['action'];
        $service_id = $_POST['service_id'];

        if ($action === 'edit') {
            $updated_service_name = $_POST['updated_service_name'];
            $updated_description = $_POST['updated_description'];
            $updated_price = $_POST['updated_price'];
            // Update the service in the database
            // Add your database code here
        } elseif ($action === 'delete') {
            // Delete the service from the database
            // Add your database code here
        }
    }
}

// Fetch services from the database
// Add your database code here to retrieve the services
$services = [
    ['id' => 1, 'service_name' => 'Service 1', 'description' => 'Description 1', 'price' => 10.99],
    ['id' => 2, 'service_name' => 'Service 2', 'description' => 'Description 2', 'price' => 19.99],
    ['id' => 3, 'service_name' => 'Service 3', 'description' => 'Description 3', 'price' => 14.99],
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service Management</title>
</head>
<body>
    <h1>Service Management</h1>

    <h2>Add Service</h2>
    <form method="POST" action="">
        <input type="text" name="service_name" placeholder="Service Name" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" name="price" placeholder="Price" required>
        <button type="submit" name="add_service">Add</button>
    </form>

    <h2>Edit/Delete Service</h2>
    <table>
        <tr>
            <th>Service ID</th>
            <th>Service Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($services as $service) : ?>
            <tr>
                <td><?= $service['id']; ?></td>
                <td><?= $service['service_name']; ?></td>
                <td><?= $service['description']; ?></td>
                <td><?= $service['price']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="service_id" value="<?= $service['id']; ?>">
                        <input type="text" name="updated_service_name" placeholder="Updated Service Name" required>
                        <input type="text" name="updated_description" placeholder="Updated Description" required>
                        <input type="number" name="updated_price" placeholder="Updated Price" required>
                        <button type="submit" name="action" value="edit">Update</button>
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
