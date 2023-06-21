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
            $type = $_POST['type'];
            $count = $_POST['count'];
            $price = $_POST['price'];
            $note = $_POST['note'];

            $query = "INSERT INTO types (name, type, count, price, note) VALUES ('$name', '$type', '$count', '$price','$note')";
        } elseif ($action === 'edit') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $type = $_POST['type'];
            $count = $_POST['count'];
            $price = $_POST['price'];
            $note = $_POST['note'];

            $query = "UPDATE types SET name = '$name', type = '$type', count = '$count', price = '$price', note = '$note' WHERE id='$id'";
        } else{
            $id = $_POST['id'];
            $query = "DELETE FROM types WHERE id='$id'";
        }

        $result = mysqli_query($db, $query) or die(mysqli_error($db));

    }
}
?>

<?php
    $query = "SELECT * FROM types";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
?>

<?php include 'head.php'; ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Quản lý tiệc cưới</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Quản lý sảnh</li>
            </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                    Thêm sảnh mới
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputName" type="text" placeholder="Sảnh A"  name="name" required />
                        <label for="inputType">Tên sảnh</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-control" id="inputType" name="type" required>
                            <option value="A" data-price="1000000">A</option>
                            <option value="B" data-price="1100000">B</option>
                            <option value="C" data-price="1200000">C</option>
                            <option value="D" data-price="1400000">D</option>
                            <option value="E" data-price="1600000">E</option>
                        </select>
                        <label for="inputType">Loại sảnh</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputCount" type="number" placeholder="30"  name="count" required />
                        <label for="inputCount">Số lượng bàn tối đa</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPrice" type="price" placeholder="1000000"  name="price" value="1000000" required readonly />
                        <label for="inputPrice">Đơn giá bàn tối thiểu</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputNote" type="textArea" placeholder="Chỉ nhận 30 bàn trở lên"  name="note" />
                        <label for="inputCount">Ghi chú</label>
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
                    Sửa thông tin sảnh
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputNameUpdate" type="text" placeholder="Sảnh A"  name="name" required />
                        <label for="inputNameUpdate">Tên sảnh</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-control" id="inputType" name="type" required>
                            <option value="A" data-price="1000000">A</option>
                            <option value="B" data-price="1100000">B</option>
                            <option value="C" data-price="1200000">C</option>
                            <option value="D" data-price="1400000">D</option>
                            <option value="E" data-price="1600000">E</option>
                        </select>
                        <label for="inputType">Loại sảnh</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputCountUpdate" type="number" placeholder="30"  name="count" required />
                        <label for="inputCountUpdate">Số lượng bàn tối đa</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPriceUpdate" type="price" placeholder="1000000"  name="price" value="1000000" required readonly />
                        <label for="inputPriceUpdate">Đơn giá bàn tối thiểu</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputNoteUpdate" type="textArea" placeholder="Chỉ nhận 30 bàn trở lên"  name="note" />
                        <label for="inputCountUpdate">Ghi chú</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <input id="inputIdUpdate" type="hidden" name="id" />
                        <button type="submit" name="action" value="edit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                    Danh sách sảnh
            </div>
            <div class="card-body">
            <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Tên sảnh</th>
                        <th>Loại sảnh</th>
                        <th>Bàn tối đa</th>
                        <th>Đơn giá bàn</th>
                        <th>Ghi chú</th>
                        <th>Action</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['type']; ?></td>
                            <td><?= $row['count']; ?></td>
                            <td><?= number_format($row['price']); ?></td>
                            <td><?= $row['note']; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button 
                                        class="btn btn-primary btn-edit" 
                                        data-id="<?= $row['id']; ?>"
                                        data-name="<?= $row['name']; ?>"
                                        data-type="<?= $row['type']; ?>"
                                        data-count="<?= $row['count']; ?>"
                                        data-price="<?= $row['price']; ?>"
                                        data-note="<?= $row['note']; ?>"
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
        $('#inputType').on('change', function() {
            var price = $(this).find(":selected").data('price');
            $('#inputPrice').val(price);
        });

        $(".btn-edit").click(function(){
            $("#inputIdUpdate").val($(this).data('id'));
            $("#inputNameUpdate").val($(this).data('name'));
            $("#inputTypeUpdate").val($(this).data('type'));
            $("#inputCountUpdate").val($(this).data('count'));
            $("#inputPriceUpdate").val($(this).data('price'));
            $("#inputNoteUpdate").val($(this).data('note'));

            $("#form-edit").css('display','block');
        });
    });
</script>