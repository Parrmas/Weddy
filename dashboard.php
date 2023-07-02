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

    $query = "SELECT b.*,t.name as type_name,s.shift_name as shift_name FROM bookings b
    LEFT JOIN types t ON b.type_id = t.id
    LEFT JOIN shifts s ON b.shift_id = s.id";

    $result = mysqli_query($db, $query) or die(mysqli_error($db));
?>
<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Quản lý tiệc cưới</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Quản lý đơn đặt tiệc</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông tin đặt lịch
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th>Tên chú rể</th>
                                            <th>Tên cô dâu</th>
                                            <th>Điện thoại</th>
                                            <th>Ngày</th>
                                            <th>Sảnh</th>
                                            <th>Ca</th>
                                            <th>Số lượng bàn</th>
                                            <th>Trạng thái</th>
                                            <th>Tổng</th>
                                            <th>Thanh toán</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_array($result)): ?>
                                            <tr>
                                                <td><?= $row['person_1_name']; ?></td>
                                                <td><?= $row['person_2_name']; ?></td>
                                                <td><?= $row['phone']; ?></td>
                                                <?php
                                                    $date = date_create_from_format("Y-m-d", $row['date']);
                                                    $date_formatted = date_format($date,"d/m/Y");
                                                ?>
                                                <td><?= $date_formatted; ?></td>
                                                <td><?= $row['type_name']; ?></td>
                                                <td><?= $row['shift_name']; ?></td>
                                                <td><?= $row['no_of_table']; ?></td>
                                                <td><?= $row['status'] ? 'Đã duyệt' : 'Chưa duyệt' ?></td>
                                                <td><?= $row['total'];?></td>
                                                <td><?= $row['paid'] ? 'Đã thanh toán' : 'Chưa thanh toán'?></td>
                                                <td><a href='detail.php?id=<?= $row['id']; ?>'>Chi tiết</a></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<?php include 'foot.php'; ?>
                
