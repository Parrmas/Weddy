<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle CRUD operations for types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add type
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $count = $_POST['count'];
        $price = $_POST['price'];
        $note = $_POST['note'];

        $query = "INSERT INTO types VALUES ($name, $type, $count, $price,$note)";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
    }

    // Edit or Delete type
    if (isset($_POST['action']) && isset($_POST['type_id'])) {
        $action = $_POST['action'];
        $type_id = $_POST['type_id'];

        if ($action === 'edit') {
            $updated_type = $_POST['updated_type'];
            // Update the type in the database
            // Add your database code here
        } elseif ($action === 'delete') {
            // Delete the type from the database
            // Add your database code here
        }
    }
}

// Fetch types from the database
// Add your database code here to retrieve the types
$types = [
    ['id' => 1, 'type' => 'Type 1'],
    ['id' => 2, 'type' => 'Type 2'],
    ['id' => 3, 'type' => 'Type 3'],
];
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
                        <button type="submit" name="add" class="btn btn-primary">Thêm</a>
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
            <table>
                    <tr>
                        <th>Type ID</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($types as $type) : ?>
                        <tr>
                            <td><?= $type['id']; ?></td>
                            <td><?= $type['type']; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="type_id" value="<?= $type['id']; ?>">
                                    <input type="text" name="updated_type" placeholder="Updated Type" required>
                                    <button type="submit" name="action" value="edit">Update</button>
                                    <button type="submit" name="action" value="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
    });
</script>