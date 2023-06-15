<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include 'connection.php';

// Handle CRUD operations for settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit setting
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'edit') {
            $id = $_POST['id'];
            $settingName = $_POST['setting_name'];
            $description = $_POST['description'];
            $active = isset($_POST['active']) ? 1 : 0;

            $query = "UPDATE general_settings SET setting_name = '$settingName', description = '$description', active = '$active' WHERE id='$id'";
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
        }
    }
}

$query = "SELECT * FROM general_settings";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
?>

<?php include 'head.php'; ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Quản lý tiệc cưới</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Cài đặt chung</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Danh sách cài đặt
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Tên cài đặt</th>
                            <th>Mô tả</th>
                            <th>Đang sử dụng</th>
                            <th>Chỉnh sửa</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['setting_name']; ?></td>
                                <td><?= $row['description']; ?></td>
                                <td><?= $row['active'] ? 'Đã bật' : 'Đã tắt'; ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <input type="hidden" name="setting_name" value="<?= $row['setting_name']; ?>">
                                        <input type="hidden" name="description" value="<?= $row['description']; ?>">
                                        <button class="btn btn-success" type="submit" name="action" value="edit" onclick="document.getElementById('active<?= $row['id']; ?>').value = 'true'">Bật</button>
                                        <button class="btn btn-danger" type="submit" name="action" value="edit" onclick="document.getElementById('active<?= $row['id']; ?>').value = 'false'">Tắt</button>
                                        <input type="hidden" id="active<?= $row['id']; ?>" name="active">
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