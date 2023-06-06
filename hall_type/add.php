<!DOCTYPE html>
<html>
<head>

<?php include '../head.php'; ?>

    <title>Thêm loại sảnh cưới</title>
</head>



    <div id="wrapper">

    <?php include '../nav.php'; ?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Thêm loại sảnh cưới
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->


             <div class="col-lg-12">
                      <div class="col-lg-6">

                        <form role="form" method="post" action="transac.php?action=add">
                            
                            <div class="form-group">
                              <input class="form-control" placeholder="First Name" name="firstname">
                            </div>
                            <div class="form-group">
                              <input class="form-control" placeholder="Last Name" name="lastname">
                            </div> 
                            <div class="form-group">
                              <input class="form-control" placeholder="Middle Name" name="Middlename">
                            </div> 
                            <div class="form-group">
                              <input class="form-control" placeholder="Address" name="Address">
                            </div> 
                            <div class="form-group">
                              <input class="form-control" placeholder="Contact" name="Contact">
                            </div> 
                            <div class="form-group">
                             <label>Comment</label>
                              <textarea class="form-control" rows="3"  name="comment"></textarea>
                            </div>  
                            <button type="submit" class="btn btn-default">Save Record</button>
                            <button type="reset" class="btn btn-default">Clear Entry</button>


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