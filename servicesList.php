<?php

include 'connection.php';

$query1 = "SELECT * FROM services";
$result1 = mysqli_query($db, $query1) or die(mysqli_error($db));

$query2 = "SELECT * FROM dishes";
$result2 = mysqli_query($db, $query2) or die(mysqli_error($db));
?>

<?php include 'main-page-header.php'?>
    <section class="u-clearfix u-palette-3-light-3 u-section-2" id="sec-b2e1">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-group u-radius-50 u-shape-round u-white u-group-1" style="margin-top: 20px">
          <div class="u-container-layout u-container-layout-1" style="padding-left:20px;padding-right: 20px">
              <h1 class="mt-4" style="text-align: center">Danh sách Món ăn và Dịch vụ</h1>
              <div class="card mb-4">
                  <div class="card-header">
                      <i class="fas fa-table me-1"></i>
                      Danh sách món ăn
                  </div>
                  <div class="card-body">
                      <table class="table">
                          <tr>
                              <th>Tên món ăn</th>
                              <th>Đơn giá</th>
                          </tr>
                          <?php while($row = mysqli_fetch_array($result2)): ?>
                              <tr>
                                  <td><?= $row['name']; ?></td>
                                  <td><?= number_format($row['price']); ?></td>
                              </tr>
                          <?php endwhile; ?>
                      </table>
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
                              <th>Tên dịch vụ</th>
                              <th>Mô tả</th>
                              <th>Đơn giá</th>
                          </tr>
                          <?php while ($row = mysqli_fetch_array($result1)): ?>
                              <tr>
                                  <td><?= $row['service_name']; ?></td>
                                  <td><?= $row['description']; ?></td>
                                  <td><?= number_format($row['price']); ?></td>
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