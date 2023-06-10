<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Quản lý tiệc cưới</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="js/jquery-3.7.0.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">Quản lý tiệc cưới</a>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Cơ bản</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Quản lý lịch hẹn
                            </a>
                            <a class="nav-link" href="type.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-house"></i></div>
                                Quản lý sảnh
                            </a>
                            <a class="nav-link" href="shift.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                                Quản lý ca
                            </a>
                            <a class="nav-link" href="dish.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-lemon"></i></div>
                                Quản lý món ăn
                            </a>
                            <a class="nav-link" href="service.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                                Quản lý dịch vụ
                            </a>
                            <div class="sb-sidenav-menu-heading">Quản lý chung</div>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Cài đặt
                            </a>
                        </div>
                    </div>
                    
                    <?php if(isset($_SESSION['username'])): ?>
                      <div class="sb-sidenav-footer">
                          <div class="small">Đã đăng nhập với:</div>
                          <?= $_SESSION['username']; ?>
                      </div>
                    <?php endif; ?>
                </nav>
            </div>
            <div id="layoutSidenav_content">