<!DOCTYPE html>
<html>
<head>
    <?php include '../head.php'; ?>
    <title>Quản lý loại sảnh cưới</title>
</head>
    <div id="wrapper">
    <?php include '../nav.php'; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Quản lý loại sảnh cưới
                           <small><a href="add.php">Thêm</a></small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->
             <div class="col-lg-12">
                      <div class="col-lg-6">
                       <?php include '../connection.php'; ?>

                        <?php $results = mysqli_query($db, "SELECT * FROM hall_type"); ?>

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
        </tr>
    </thead>
    
    <?php while ($row = mysqli_fetch_array($results)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td>
                <a href="https://preservationsystem.000webhostapp.com/hall_type/edit.php?id=<?php echo $row['id']; ?>" class="edit_btn" >Sửa</a>
            </td>
            <td>
                <a href="https://preservationsystem.000webhostapp.com/del.php?type=hall_type&id=<?php echo $row['id']; ?>" class="del_btn">Xoá</a>
            </td>
        </tr>
    <?php } ?>
</table>
                    </div>
                </div>
                
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include '../foot.php'; ?>
</body>
</html>