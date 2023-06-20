<?php
    // Check if the admin is logged in
    session_start();
    if (!isset($_SESSION['admin'])) {
      header('Location: login.php');
      exit();
    }
?>

<?php 
    include 'head.php';
    include 'connection.php';

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'edit') {
            $id = $_POST['id'];

            $query = "UPDATE bookings SET status = 1 WHERE id='$id'";
        }
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
    }

    $bookingId = $_GET['id'];

    $query = "
        SELECT b.*,t.name as type_name,s.shift_name as shift_name FROM bookings b
        LEFT JOIN types t ON b.type_id = t.id
        LEFT JOIN shifts s ON b.shift_id = s.id
        WHERE b.id = '$bookingId'
    ";

    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    $booking = mysqli_fetch_array($result);
    
    if (!$booking) {
        echo "Booking not found.";
        exit;
    }
?>
<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Chi tiết lịch hẹn</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Lịch hẹn đã đặt</li>
                            <li class="breadcrumb-item active">Chi tiết lịch hẹn</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông tin chi tiết lịch hẹn
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td>ID:</td>
                                        <td><?php echo $booking['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tên chú rể:</td>
                                        <td><?php echo $booking['person_1_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tên cô dâu:</td>
                                        <td><?php echo $booking['person_2_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại:</td>
                                        <td><?php echo $booking['phone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ngày:</td>
                                        <?php
                                            $date = date_create_from_format("Y-m-d", $booking['date']);
                                            $date_formatted = date_format($date,"d/m/Y");
                                        ?>
                                        <td><?= $date_formatted; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tiền đặt cọc:</td>
                                        <td><?php echo $booking['amount']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Số bàn:</td>
                                        <td><?php echo $booking['no_of_table']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Số bàn dự phòng:</td>
                                        <td><?php echo $booking['no_of_reserved_table']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sảnh:</td>
                                        <td><?php echo $booking['type_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ca:</td>
                                        <td><?php echo $booking['shift_name']; ?></td>
                                    </tr>

                                    <?php
                                        $query2 = "SELECT d.* FROM dishes d LEFT JOIN booking_dishes bd ON d.id = bd.dish_id AND bd.booking_id = $bookingId";
                                        $result2 = mysqli_query($db, $query2) or die(mysqli_error($db));
                                    ?>

                                    <tr>
                                        <td>Món ăn:</td>
                                        <td>
                                            <?php while ($row = mysqli_fetch_array($result2)): ?>
                                                <?php echo $row['name']; ?> </br>
                                            <?php endwhile; ?>
                                        </td>
                                    </tr>

                                    <?php
                                        $query3 = "SELECT s.* FROM services s LEFT JOIN booking_services bs ON s.id = bs.service_id AND bs.booking_id = $bookingId";
                                        $result3 = mysqli_query($db, $query3) or die(mysqli_error($db));
                                    ?>

                                    <tr>
                                        <td>Dịch vụ:</td>
                                        <td>
                                            <?php while ($row = mysqli_fetch_array($result3)): ?>
                                                <?php echo $row['service_name']; ?> </br>
                                            <?php endwhile; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Trạng thái:</td>
                                        <td>
                                        <?php echo $booking['status'] ? 'Đã duyệt' : 'Chưa duyệt' ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" name="id" value="<?= $booking['id']; ?>">
                                                <button type="submit" name="action" value="edit" class="btn btn-primary">Duyệt</button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<?php include 'foot.php'; ?>
                
