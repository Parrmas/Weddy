<!DOCTYPE html>
<html>
<head>

<?php include '../head.php'; ?>
<title>Sửa loại sảnh cưới</title>



</head>



    <div id="wrapper">

    <?php include '../nav.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Sửa loại sảnh cưới
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->


             <?php
include "../connection.php"; 
$query = 'SELECT * FROM hall_type
              WHERE
              id ='.$_GET['id'];
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
              while($row = mysqli_fetch_array($result))
              { 
                $id = $row['id'];  
                $name = $row['name'];
              }         
?>

             <div class="col-lg-12">
                  <h2>Cập nhật dữ liệu</h2>
                      <div class="col-lg-6">

                        <form role="form" method="post" action="edit1.php">
                            
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            </div>
                            <div class="form-group">
                              <label>Tên</label>
                              <input class="form-control" placeholder="Name" name="name" value="<?php echo $name; ?>">
                            </div>
                            <button type="submit" class="btn btn-default">Update Record</button>
                         


                      </form>  
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