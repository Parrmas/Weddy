<?php

include 'connection.php';

$query = "SELECT * FROM shifts";
$result = mysqli_query($db, $query) or die(mysqli_error($db));

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
    <meta property="og:title" content="services">
    <meta property="og:type" content="website">
    <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
<body class="u-body u-overlap u-overlap-transparent u-xl-mode" data-lang="en"><header class="u-clearfix u-header u-header" id="sec-ec89"><div class="u-clearfix u-sheet u-sheet-1">
        <a href="#" class="u-image u-logo u-image-1" data-image-width="403" data-image-height="403">
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
                <ul class="u-nav u-spacing-25 u-unstyled u-nav-1 text-white"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="index.php" style="padding: 8px 0px;">Trang chủ</a>
                    </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="typeList.php" style="padding: 8px 0px;">Sảnh</a>
                    </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="servicesList.php" style="padding: 8px 0px;">Món ăn và Dịch vụ</a>
                    </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="shiftList.php" style="padding: 8px 0px;">Ca đãi tiệc</a>
                    </li></ul>
            </div>
            <div class="u-custom-menu u-nav-container-collapse">
                <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
                    <div class="u-inner-container-layout u-sidenav-overflow">
                        <div class="u-menu-close"></div>
                        <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="home.html">Trang chủ</a>
                            </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="typeList.php">Sảnh</a>
                            </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="servicesList.php">Món ăn và Dịch vụ</a>
                            </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="shiftList.php">Ca đãi tiệc</a>
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
        <div class="u-container-style u-group u-radius-50 u-shape-round u-white u-group-1" style="margin-top: 20px">
            <div class="u-container-layout u-container-layout-1">
                <h1 class="mt-4" style="text-align: center">Danh sách Ca đãi tiệc</h1>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Tên ca</th>
                            <th>Giờ bắt đầu</th>
                            <th>Giờ kết thúc</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                            <tr>
                                <td><?= $row['shift_name']; ?></td>
                                <td><?= $row['start_time']; ?></td>
                                <td><?= $row['end_time']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
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