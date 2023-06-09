<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
      <li><a href="admin.php?page=dashboard">Dashboard</a></li>
      <li><a href="admin.php?page=type_management">Type Management</a></li>
      <li><a href="admin.php?page=shift_management">Shift Management</a></li>
      <li><a href="admin.php?page=service_management">Service Management</a></li>
      <li><a href="admin.php?page=general_settings">General Settings</a></li>
      <li><a href="admin.php?page=booking">Booking</a></li>
    </ul>
  </div>

  <div class="content">
    <?php
    // Check if the admin is logged in
    session_start();
    if (!isset($_SESSION['admin'])) {
      header('Location: login.php');
      exit();
    }

    // Include the appropriate page based on the 'page' query parameter
    if (isset($_GET['page'])) {
      $page = $_GET['page'];

      switch ($page) {
        case 'dashboard':
          include 'dashboard.php';
          break;
        case 'type_management':
          include 'type_management.php';
          break;
        case 'shift_management':
          include 'shift_management.php';
          break;
        case 'service_management':
          include 'service_management.php';
          break;
        case 'general_settings':
          include 'general_settings.php';
          break;
        case 'booking':
          include 'booking.php';
          break;
        default:
          include 'dashboard.php';
          break;
      }
    } else {
      include 'dashboard.php';
    }
    ?>
  </div>
</body>
</html>
