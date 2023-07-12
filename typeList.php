<?php

include 'connection.php';

$query = "SELECT * FROM types";
$result = mysqli_query($db, $query) or die(mysqli_error($db));

?>

<?php include 'main-page-header.php' ?>

<section class="u-clearfix u-palette-3-light-3 u-section-2" id="sec-b2e1">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-group u-radius-50 u-shape-round u-white u-group-1" style="margin-top: 20px">
            <div class="u-container-layout u-container-layout-1" style="padding-left:20px;padding-right: 20px">
                <h1 class="mt-4" style="text-align: center">Danh sách Sảnh</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Danh sách sảnh
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Tên sảnh</th>
                                <th>Bàn tối đa</th>
                                <th>Đơn giá bàn</th>
                                <th>Ghi chú</th>
                            </tr>
                            <?php while($row = mysqli_fetch_array($result)): ?>
                                <tr>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['count']; ?></td>
                                    <td><?= number_format($row['price']); ?></td>
                                    <td><?= $row['note']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'main-page-footer.php'?>