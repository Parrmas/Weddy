<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include 'connection.php';

// Handle CRUD operations for types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit or Delete type
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $name = $_POST['name'];
            $price = $_POST['price'];

            $query = "INSERT INTO dishes (name, price) VALUES ('$name', '$price')";
        } elseif ($action === 'edit') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];

            $query = "UPDATE dishes SET name = '$name', price = '$price' WHERE id='$id'";
        } else{
            $id = $_POST['id'];
            $query = "DELETE FROM dishes WHERE id='$id'";
        }

        $result = mysqli_query($db, $query) or die(mysqli_error($db));

    }
}
?>

<?php
$query = "SELECT * FROM dishes";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
?>

<?php include 'head.php'; ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Quản lý tiệc cưới</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Quản lý món ăn</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Thêm món ăn mới
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputName" type="text" placeholder="Món ăn A"  name="name" required />
                        <label for="inputType">Tên món ăn</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPrice" type="number" placeholder="200000" name ="price" value="200000" required/>
                        <label for="inputType">Đơn giá</label>
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
                Sửa thông tin món ăn
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputNameUpdate" type="text" placeholder="Sảnh A"  name="name" required />
                        <label for="inputType">Tên món ăn</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPriceUpdate" type="number" placeholder="200000" name ="price" value="200000" required/>
                        <label for="inputType">Đơn giá</label>
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
                Danh sách món ăn
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Tên món ăn</th>
                        <th>Đơn giá</th>
                        <th>Action</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= number_format($row['price']); ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button
                                        class="btn btn-primary btn-edit"
                                        data-id="<?= $row['id']; ?>"
                                        data-name="<?= $row['name']; ?>"
                                        data-price="<?= $row['price']; ?>"
                                        type="button">Sửa</button>
                                    <button class="btn btn-danger" type="submit" name="action" value="delete">Xoá</button>
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
            $("#inputNameUpdate").val($(this).data('name'));
            $("#inputPriceUpdate").val($(this).data('price'));

            $("#form-edit").css('display','block');
        });
    });
</script>
