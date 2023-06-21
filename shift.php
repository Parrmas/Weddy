<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include 'connection.php';

// Handle CRUD operations for shifts
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit or Delete shift
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $shiftName = $_POST['shift_name'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];

            $query = "INSERT INTO shifts (shift_name, start_time, end_time) VALUES ('$shiftName', '$startTime', '$endTime')";
        } elseif ($action === 'edit') {
            $id = $_POST['id'];
            $shiftName = $_POST['shift_name'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];

            $query = "UPDATE shifts SET shift_name = '$shiftName', start_time = '$startTime', end_time = '$endTime' WHERE id='$id'";
        } else {
            $id = $_POST['id'];
            $query = "DELETE FROM shifts WHERE id='$id'";
        }

        $result = mysqli_query($db, $query) or die(mysqli_error($db));
    }
}

$query = "SELECT * FROM shifts";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
?>

<?php include 'head.php'; ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Quản lý tiệc cưới</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Quản lý ca</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Thêm ca mới
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputShiftName" type="text" placeholder="Ca A"  name="shift_name" required />
                        <label for="inputShiftName">Tên ca</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputStartTime" type="time" name="start_time" required/>
                        <label for="inputStartTime">Giờ bắt đầu</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEndTime" type="time" name="end_time" required/>
                        <label for="inputEndTime">Giờ kết thúc</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button type="submit" name="action" value="add" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="form-edit" class="card mb-4" style="display: none">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Sửa thông tin ca
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputShiftNameUpdate" type="text" placeholder="Ca A"  name="shift_name" required />
                        <label for="inputShiftNameUpdate">Tên ca</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputStartTimeUpdate" type="time" name="start_time" required/>
                        <label for="inputStartTimeUpdate">Giờ bắt đầu</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEndTimeUpdate" type="time" name="end_time" required/>
                        <label for="inputEndTimeUpdate">Giờ kết thúc</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <input id="inputIdUpdate" type="hidden" name="id"/>
                        <button type="submit" name="action" value="edit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Danh sách ca
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Tên ca</th>
                        <th>Giờ bắt đầu</th>
                        <th>Giờ kết thúc</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['shift_name']; ?></td>
                            <td><?= $row['start_time']; ?></td>
                            <td><?= $row['end_time']; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button
                                            class="btn btn-primary btn-edit"
                                            data-id="<?= $row['id']; ?>"
                                            data-shift-name="<?= $row['shift_name']; ?>"
                                            data-start-time="<?= $row['start_time']; ?>"
                                            data-end-time="<?= $row['end_time']; ?>"
                                            type="button">Sửa</button>
                                    <button class="btn btn-danger" type="submit" name="action" value="delete">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</main>
<?php include 'foot.php'; ?>

<script>
    $(function(){
        $(".btn-edit").click(function(){
            $("#inputIdUpdate").val($(this).data('id'));
            $("#inputShiftNameUpdate").val($(this).data('shift-name'));
            $("#inputStartTimeUpdate").val($(this).data('start-time'));
            $("#inputEndTimeUpdate").val($(this).data('end-time'));

            $("#form-edit").css('display','block');
        });
    });
</script>