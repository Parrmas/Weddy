<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $person1_name = $_POST['person1_name'];
    $person2_name = $_POST['person2_name'];
    $phone_number = $_POST['phone_number'];
    $date = $_POST['date'];
    $deposit = $_POST['deposit'];
    $num_of_tables = $_POST['num_of_tables'];
    $num_of_reserved_tables = $_POST['num_of_reserved_tables'];
    $type_id = $_POST['type'];
    $shift_id = $_POST['shift'];
    $selected_dishes = $_POST['dishes'];
    $selected_services = $_POST['services'];

    // Process the booking data and store it in the database
    // Add your database code here

    // Clear the form fields after submission
    $person1_name = '';
    $person2_name = '';
    $phone_number = '';
    $date = '';
    $deposit = '';
    $num_of_tables = '';
    $num_of_reserved_tables = '';
    $type_id = '';
    $shift_id = '';
    $selected_dishes = [];
    $selected_services = [];
}

// Fetch types from the database
// Add your database code here to retrieve the types
$types = [
    ['id' => 1, 'type' => 'Type 1'],
    ['id' => 2, 'type' => 'Type 2'],
    ['id' => 3, 'type' => 'Type 3'],
];

// Fetch shifts from the database
// Add your database code here to retrieve the shifts
$shifts = [
    ['id' => 1, 'shift_name' => 'Morning', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
    ['id' => 2, 'shift_name' => 'Afternoon', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
    ['id' => 3, 'shift_name' => 'Evening', 'start_time' => '18:00:00', 'end_time' => '21:00:00'],
];

// Fetch dishes from the database
// Add your database code here to retrieve the dishes
$dishes = [
    ['id' => 1, 'dish_name' => 'Dish 1', 'price' => 10.99],
    ['id' => 2, 'dish_name' => 'Dish 2', 'price' => 19.99],
    ['id' => 3, 'dish_name' => 'Dish 3', 'price' => 14.99],
];

// Fetch services from the database
// Add your database code here to retrieve the services
$services = [
    ['id' => 1, 'service_name' => 'Service 1', 'price' => 5.99],
    ['id' => 2, 'service_name' => 'Service 2', 'price' => 7.99],
    ['id' => 3, 'service_name' => 'Service 3', 'price' => 9.99],
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking</title>
</head>
<body>
    <h1>Booking</h1>

    <form method="POST" action="">
        <label>Person 1 Name:</label>
        <input type="text" name="person1_name" value="<?= $person1_name ?>" required><br>

        <label>Person 2 Name:</label>
        <input type="text" name="person2_name" value="<?= $person2_name ?>"><br>

        <label>Phone Number:</label>
        <input type="text" name="phone_number" value="<?= $phone_number ?>" required><br>

        <label>Date:</label>
        <input type="date" name="date" value="<?= $date ?>" required><br>

        <label>Deposit Amount:</label>
        <input type="number" name="deposit" step="0.01" value="<?= $deposit ?>" required><br>

        <label>Number of Tables:</label>
        <input type="number" name="num_of_tables" value="<?= $num_of_tables ?>" required><br>

        <label>Number of Reserved Tables:</label>
        <input type="number" name="num_of_reserved_tables" value="<?= $num_of_reserved_tables ?>" required><br>

        <label>Type:</label>
        <select name="type" required>
            <option value="">Select Type</option>
            <?php foreach ($types as $type) : ?>
                <option value="<?= $type['id'] ?>" <?= $type_id == $type['id'] ? 'selected' : '' ?>>
                    <?= $type['type'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Shift:</label>
        <select name="shift" required>
            <option value="">Select Shift</option>
            <?php foreach ($shifts as $shift) : ?>
                <option value="<?= $shift['id'] ?>" <?= $shift_id == $shift['id'] ? 'selected' : '' ?>>
                    <?= $shift['shift_name'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Dishes:</label>
        <select name="dishes[]" multiple required>
            <?php foreach ($dishes as $dish) : ?>
                <option value="<?= $dish['id'] ?>" <?= in_array($dish['id'], $selected_dishes) ? 'selected' : '' ?>>
                    <?= $dish['dish_name'] ?> ($<?= $dish['price'] ?>)
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Services:</label>
        <select name="services[]" multiple required>
            <?php foreach ($services as $service) : ?>
                <option value="<?= $service['id'] ?>" <?= in_array($service['id'], $selected_services) ? 'selected' : '' ?>>
                    <?= $service['service_name'] ?> ($<?= $service['price'] ?>)
                </option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Book</button>
    </form>
</body>
</html>
