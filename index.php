<?php
include 'connection.php';

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name1 = $_POST['name1'];
    $name2 = $_POST['name2'];
    $phone = $_POST['phone'];
    $date = date_create_from_format("d/m/Y", $_POST['date']);
    $type = $_POST['type'];
    $shift = $_POST['shift'];
    $amount = $_POST['amount'];
    $noOfTable = $_POST['noOfTable'];
    $noOfReservedTable = $_POST['noOfReservedTable'];
    $dishes = $_POST['dishes'];
    $services = $_POST['services'];

    $date_formatted = date_format($date,"Y-m-d");

    // Calculate total price from selected dishes
    $dishTotal = 0;
    foreach ($dishes as $dish) {
        // Assuming the price of each dish is stored in the 'price' column of the 'dishes' table
        $queryDish = "SELECT price FROM dishes WHERE id = '$dish'";
        $resultDish = mysqli_query($db, $queryDish) or die(mysqli_error($db));
        $rowDish = mysqli_fetch_assoc($resultDish);
        $dishPrice = $rowDish['price'];
        $dishTotal += $dishPrice;
    }

// Calculate total price from selected services
    $serviceTotal = 0;
    foreach ($services as $service) {
        // Assuming the price of each service is stored in the 'price' column of the 'services' table
        $queryService = "SELECT price FROM services WHERE id = '$service'";
        $resultService = mysqli_query($db, $queryService) or die(mysqli_error($db));
        $rowService = mysqli_fetch_assoc($resultService);
        $servicePrice = $rowService['price'];
        $serviceTotal += $servicePrice;
    }
    //Calculate total price from table
    $tableTotal = 0;
    $queryTable = "SELECT price FROM types WHERE id = '$type'";
    $resultTable = mysqli_query($db, $queryTable) or die(mysqli_error($db));
    $rowTable = mysqli_fetch_assoc($resultTable);
    $tablePrice = $rowTable['price'];
    $tableTotal += $tablePrice * $noOfTable;

// Calculate the overall total price
    $total = $dishTotal + $serviceTotal + $tableTotal;

    $query = "INSERT INTO bookings (person_1_name, person_2_name, phone, date, amount, no_of_table, no_of_reserved_table, type_id, shift_id, status, total)
     VALUES ('$name1', '$name2', '$phone', '$date_formatted', '$amount', '$noOfTable', '$noOfReservedTable', '$type', '$shift', '0', '$total')";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
    $booking_id = $db->insert_id;
    $query2 = "INSERT INTO booking_dishes (booking_id, dish_id) VALUES ";

    foreach($dishes as $index => $dish){
        $query2 .= "('$booking_id', '$dish')";

        if($index != count($dishes) - 1) $query2 .= ", ";
    }

    $result = mysqli_query($db, $query2) or die(mysqli_error($db));

    $query3 = "INSERT INTO booking_services (booking_id, service_id) VALUES ";

    foreach($services as $index => $service){
        $query3 .= "('$booking_id', '$service')";

        if($index != count($service) - 1) $query3 .= ", ";
    }

    $result = mysqli_query($db, $query3) or die(mysqli_error($db));


    header('Location: thankyou.php');
    exit();
}

// Fetch types from the database
// Add your database code here to retrieve the types
$query = "SELECT * FROM types";
$types = mysqli_query($db, $query) or die(mysqli_error($db));

// Fetch shifts from the database
// Add your database code here to retrieve the shifts
$query = "SELECT * FROM shifts";
$shifts = mysqli_query($db, $query) or die(mysqli_error($db));

// Fetch dishes from the database
// Add your database code here to retrieve the dishes
$query = "SELECT * FROM dishes";
$dishes = mysqli_query($db, $query) or die(mysqli_error($db));

// Fetch services from the database
// Add your database code here to retrieve the services
$query = "SELECT * FROM services";
$services = mysqli_query($db, $query) or die(mysqli_error($db));
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Wedding &amp;amp; Event Planner, -We believe that it is all about the Big Dreams and the small details!, What to expect from your planner, Dream Weddings, Bespoke Wedding Planner, Destination Wedding, Same Sex Marriages, Wedding Planner Team, Destination Wedding">
    <meta name="description" content="">
    <title>Nhà hàng tiệc cưới Weddy</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
    <link rel="stylesheet" href="home.css" media="screen">
    <link href="css/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="js/fontawesome.js" crossorigin="anonymous"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet prefetch" href="css/datepicker.css" />
    <script src="js/datepicker.js"></script>
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 5.12.7, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <script type="application/ld+json">{
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "",
            "logo": "images/logowedding.png"
        }</script>
    <meta name="theme-color" content="#a68053">
    <meta property="og:title" content="home">
    <meta property="og:type" content="website">
    <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
<body class="u-body u-overlap u-overlap-transparent u-xl-mode" data-lang="en"><header class="u-clearfix u-header u-header" id="sec-ec89"><div class="u-clearfix u-sheet u-sheet-1">
        <a href="index.php" class="u-image u-logo u-image-1" data-image-width="403" data-image-height="403">
            <img src="images/logowedding.png" class="u-logo-image u-logo-image-1">
        </a>
        <nav class="u-menu u-menu-one-level u-offcanvas u-menu-1">
            <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px;">
                <a class="u-button-style u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="#">
                    <svg class="u-svg-link" viewBox="0 0 24 24"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#menu-hamburger"></use></svg>
                    <svg class="u-svg-content" version="1.1" id="menu-hamburger" viewBox="0 0 16 16" x="0px" y="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><g><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
                        </g></svg>
                </a>
            </div>
            <div class="u-custom-menu u-nav-container">
                <ul class="u-nav u-spacing-25 u-unstyled u-nav-1"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="index.php" style="padding: 8px 0px;">Trang chủ</a>
                    </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="typeList.php" style="padding: 8px 0px;">Sảnh</a>
                    </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="servicesList.php" style="padding: 8px 0px;">Món ăn và dịch vụ</a>
                    </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="shiftList.php" style="padding: 8px 0px;">Ca đãi tiệc</a>
                    </li></ul>
            </div>
            <div class="u-custom-menu u-nav-container-collapse">
                <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
                    <div class="u-inner-container-layout u-sidenav-overflow">
                        <div class="u-menu-close"></div>
                        <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="index.php">Trang chủ</a>
                            </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="typeList.php">type</a>
                            </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="servicesList.php">services</a>
                            </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="shiftList.php">shift</a>
                            </li></ul>
                    </div>
                </div>
                <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
            </div>
        </nav>
    </div></header>
<section class="u-clearfix u-image u-shading u-section-1" id="sec-535d">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-align-center u-container-style u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-group u-group-1">
            <div class="u-container-layout u-container-layout-1">
                <h1 class="u-custom-font u-font-abril-fatface u-text u-title u-text-1">Nhà hàng tiệc cưới Weddy</h1>
            </div>
        </div>
    </div>
</section>
<section class="u-clearfix u-palette-3-light-3 u-section-2" id="sec-b2e1">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-layout-wrap u-layout-wrap-1">
            <div class="u-layout">
                <div class="u-layout-row">
                    <div class="u-container-style u-layout-cell u-left-cell u-size-33 u-white u-layout-cell-1">
                        <div class="u-container-layout u-valign-middle u-container-layout-1">
                            <h6 class="u-text u-text-1">about us</h6>
                            <div class="u-border-3 u-border-palette-2-base u-line u-line-horizontal u-line-1"></div>
                            <h2 class="u-custom-font u-font-abril-fatface u-text u-text-2">-Chúng tôi tin rằng những thứ quan trọng chính là một ước mơ lớn và những chi tiết nhỏ</h2>
                            <p class="u-text u-text-3">Nhà hàng tiệc cưới Weddy cung cấp những dịch vụ hạng nhất cho bữa tiệc quan trọng nhất cuộc đời bạn với những thiết kế kì diệu mang phong cách lãng mạn và đáng nhớ.</p>
                        </div>
                    </div>
                    <div class="u-container-style u-layout-cell u-right-cell u-size-27 u-white u-layout-cell-2">
                        <div class="u-container-layout">
                            <img class="u-image u-image-1" src="images/89f8b55c0fca88060dd9bedb603953db.jpeg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="u-clearfix u-palette-3-light-3 u-section-3" id="sec-3028" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction="">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-group u-radius-50 u-shape-round u-white u-group-1">
        <div class="u-container-layout u-container-layout-1">
            <h1 class="mt-4" style="text-align: center">Đặt tiệc cưới</h1>
            <form method="POST" action="" style="margin: 20px">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Thông tin tiệc cưới
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" id="inputName1" type="text" placeholder="Nguyễn Văn A"  name="name1" required />
                                    <label for="inputName1">Tên chú rể</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" id="inputName2" type="text" placeholder="Nguyễn Thị A"  name="name2" required />
                                    <label for="inputName2">Tên cô dâu</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" id="inputPhone" type="text" placeholder="0901234567"  name="phone" required />
                                    <label for="inputPhone">Điện thoại</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" id="inputDate" type="text" placeholder="01/01/2023"  name="date" required />
                                    <label for="inputDate">Ngày</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="inputType" class="form-select" name="type">
                                        <option>----</option>
                                        <?php while($row = mysqli_fetch_array($types)): ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="inputType">Sảnh</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="inputShift" class="form-select" name="shift">
                                        <option>----</option>
                                        <?php while($row = mysqli_fetch_array($shifts)): ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['shift_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="inputShift">Ca</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" id="inputAmount" type="number" placeholder="1000000"  name="amount" required />
                                    <label for="inputAmount">Tiền đặt cọc</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" id="inputNoOfTable" type="number" placeholder="10"  name="noOfTable" required />
                                    <label for="inputNoOfTable">Số lượng bàn</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" id="inputNoOfReservedTable" type="number" placeholder="2"  name="noOfReservedTable" required />
                                    <label for="inputNoOfReservedTable">Số bàn dự trữ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Món ăn
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <?php while($row = mysqli_fetch_array($dishes)): ?>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inputDishes<?= $row['id']; ?>" name="dishes[]" value="<?= $row['id']; ?>">
                                                <label class="form-check-label"><?= $row['name']; ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label><?= number_format($row['price'], 0, '.', ','); ?>đ</label>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Dịch vụ
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <?php while($row = mysqli_fetch_array($services)): ?>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="inputServices<?= $row['id']; ?>" name="services[]" value="<?= $row['id']; ?>">
                                                    <label class="form-check-label"><?= $row['service_name']; ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label><?= number_format($row['price'], 0, '.', ','); ?>đ</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-4 mb-0" style="margin-left: 50px">
                    <button type="submit" name="action" value="add" class="btn btn-primary">Gửi</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</section>
<section class="u-clearfix u-palette-3-light-3 u-section-4" id="sec-6892" style="text-align: center;padding-top: 20px">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-expanded-width u-radius-50 u-shape u-shape-round u-white u-shape-1"></div>
        <div class="u-radius-50 u-shape u-shape-round u-white u-shape-2" style="align-items: center"><h1 class="u-text u-text-default u-text-1" style="padding-top: 15px">Người phát triển</h1></div>
        <div class="u-expanded-width u-list u-list-1" style="text-align: center;padding-bottom: 10px">
            <div class="u-repeater u-repeater-1">
                <div class="u-container-style u-list-item u-repeater-item">
                    <div class="u-container-layout u-similar-container u-container-layout-1">
                        <div class="u-radius-50 u-shape u-shape-round u-white u-shape-3"></div>
                        <img class="u-image u-image-circle u-image-1" src="images/pat.png" alt="" data-image-width="1280" data-image-height="853">
                        <h2 class="u-text u-text-default u-text-2">Trần Khánh Huy</h2>
                        <h3 class="u-text u-text-default u-text-3">21DH114410</h3>
                    </div>
                </div>
                <div class="u-container-style u-list-item u-repeater-item">
                    <div class="u-container-layout u-similar-container u-container-layout-2">
                        <div class="u-radius-50 u-shape u-shape-round u-white u-shape-4"></div>
                        <img class="u-image u-image-circle u-image-2" src="images/xen.png" alt="" data-image-width="1280" data-image-height="853">
                        <h2 class="u-text u-text-default u-text-4">Vũ Lê Huy</h2>
                        <h3 class="u-text u-text-default u-text-5">21DH110702</h3>
                    </div>
                </div>
                <div class="u-container-style u-list-item u-repeater-item">
                    <div class="u-container-layout u-similar-container u-container-layout-3">
                        <div class="u-radius-50 u-shape u-shape-round u-white u-shape-5"></div>
                        <img class="u-image u-image-circle u-image-3" src="images/luk.png" alt="" data-image-width="1280" data-image-height="853">
                        <h2 class="u-text u-text-default u-text-6">Trần Bảo Lộc</h2>
                        <h3 class="u-text u-text-default u-text-7">21DH111061</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="u-clearfix u-image u-shading u-section-5" id="sec-bb18">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-align-center u-container-style u-group u-group-1">
            <div class="u-container-layout u-valign-middle u-container-layout-1">
                <h2 class="u-custom-font u-font-abril-fatface u-text u-text-1">Destination Wedding</h2>
                <p class="u-text u-text-2">Nhà hàng tiệc cưới Weddy tổ chức các lễ cưới sinh động ở địa chỉ số 121 đường 3 Tháng 2, Quận 10, Thành phố Hồ Chí Minh.</p>
            </div>
        </div>
    </div>
</section>
</body></html>

<script type="text/javascript">
$(function () {  
    $("#inputDate").datepicker({         
        autoclose: true,         
        todayHighlight: true,
        format: "dd/mm/yyyy"
    }).datepicker('update', new Date());
});
$('#inputType').change(function(){
    $.ajax(
    'ajax.php',
        {
            data: { 
                date: $('#inputDate').val(),
                type: $('#inputType').val()
            },
            success: function(data) {
                var result = JSON.parse(data);

                $('#inputShift option').each(function () {
                    if(jQuery.inArray($(this).attr('value'), result.data) !== -1){
                        $(this).html($(this).html() + ' - đã nhận tiệc');
                        $(this).attr('disabled', true);
                    }
                });
            },
            error: function() {
                alert('There was some error performing the AJAX call!');
            }
        }
    );
});
</script>

<style>
.form-floating > .date > .form-control {
    padding: 1rem 0.75rem;
}
.form-floating > .date > .form-control {
    height: calc(3.5rem + 2px);
    line-height: 1.25;
}
</style>