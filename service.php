<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include 'connection.php';

// Handle CRUD operations for services
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit or Delete service
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $serviceName = $_POST['service_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $query = "INSERT INTO services (service_name, description, price) VALUES ('$serviceName', '$description', '$price')";
        } elseif ($action === 'edit') {
            $id = $_POST['id'];
            $serviceName = $_POST['service_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $query = "UPDATE services SET service_name = '$serviceName', description = '$description', price = '$price' WHERE id='$id'";
        } else {
            $id = $_POST['id'];
            $query = "DELETE FROM services WHERE id='$id'";
        }

        $result = mysqli_query($db, $query) or die(mysqli_error($db));
    }
}

$query = "SELECT * FROM services";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
?>

<?php include 'head.php'; ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Quản lý tiệc cưới</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Quản lý dịch vụ</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Thêm dịch vụ mới
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputServiceName" type="text" placeholder="Service A"  name="service_name" required />
                        <label for="inputServiceName">Tên dịch vụ</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="inputDescription" placeholder="Service Description" name="description"></textarea>
                        <label for="inputDescription">Mô tả</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPrice" type="number" placeholder="200000" name="price" required/>
                        <label for="inputPrice">Đơn giá</label>
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
                Sửa thông tin dịch vụ
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputServiceNameUpdate" type="text" placeholder="Service A"  name="service_name" required />
                        <label for="inputServiceNameUpdate">Tên dịch vụ</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="inputDescriptionUpdate" placeholder="Service Description" name="description"></textarea>
                        <label for="inputDescriptionUpdate">Mô tả</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPriceUpdate" type="number" placeholder="200000" name="price" required/>
                        <label for="inputPriceUpdate">Đơn giá</label>
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
                Danh sách dịch vụ
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Tên dịch vụ</th>
                        <th>Mô tả</th>
                        <th>Đơn giá</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['service_name']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td><?= number_format($row['price']); ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button
                                            class="btn btn-primary btn-edit"
                                            data-id="<?= $row['id']; ?>"
                                            data-service-name="<?= $row['service_name']; ?>"
                                            data-description="<?= $row['description']; ?>"
                                            data-price="<?=$row['price']; ?>"
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
            $("#inputServiceNameUpdate").val($(this).data('service-name'));
            $("#inputDescriptionUpdate").val($(this).data('description'));
            $("#inputPriceUpdate").val($(this).data('price'));

            $("#form-edit").css('display','block');
        });
    });
</script>