<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include 'connection.php';

// Retrieve the number of bookings
$query = "SELECT COUNT(*) FROM bookings";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$num_bookings = mysqli_fetch_array($result)[0];

// Calculate the total number of dishes
$query = "SELECT COUNT(*) FROM dishes";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$num_dishes = mysqli_fetch_array($result)[0];

// Calculate the total number of services
$query = "SELECT COUNT(*) FROM services";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$num_services = mysqli_fetch_array($result)[0];

// Calculate the total number of types
$query = "SELECT COUNT(*) FROM types";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$num_types = mysqli_fetch_array($result)[0];

// Calculate the total amount of money from bookings
$query = "SELECT SUM(amount) FROM bookings";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$total_amount = mysqli_fetch_array($result)[0];
?>

<?php include 'head.php'; ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Thống kê</h1>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <h2 class="card-title text-primary">Đơn đặt tiệc</h2>
                        <p class="card-text h3"><?php echo $num_bookings; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body">
                        <h2 class="card-title text-success">Món ăn</h2>
                        <p class="card-text h3"><?php echo $num_dishes; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-info">
                    <div class="card-body">
                        <h2 class="card-title text-info">Dịch vụ</h2>
                        <p class="card-text h3"><?php echo $num_services; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-warning">
                    <div class="card-body">
                        <h2 class="card-title text-warning">Sảnh</h2>
                        <p class="card-text h3"><?php echo $num_types; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-danger">
                    <div class="card-body">
                        <h2 class="card-title text-danger">Tổng doanh thu</h2>
                        <p class="card-text h3">$<?php echo $total_amount; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'foot.php'; ?>
