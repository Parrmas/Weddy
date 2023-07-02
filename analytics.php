<?php
// Check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include 'head.php';
include 'connection.php';

// Initialize variables
$bookings_by_day = array();
$revenue_by_day = array();
$total_revenue = 0;
$previous_revenue = 0;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = $_POST['month'];

    $query = "SELECT date, total FROM bookings WHERE MONTH(date) = $month AND paid = '1'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
}
else {
    $month = date('n');

    $query = "SELECT date, total FROM bookings WHERE MONTH(date) = $month AND paid = '1'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
}

?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Thống kê doanh thu</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Thống kê
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <label for="month">Chọn tháng:</label>
                        <select id="month" name="month" onchange="this.form.submit()">
                            <option value="1">Tháng 1</option>
                            <option value="2">Tháng 2</option>
                            <option value="3">Tháng 3</option>
                            <option value="4">Tháng 4</option>
                            <option value="5">Tháng 5</option>
                            <option value="6">Tháng 6</option>
                            <option value="7">Tháng 7</option>
                            <option value="8">Tháng 8</option>
                            <option value="9">Tháng 9</option>
                            <option value="10">Tháng 10</option>
                            <option value="11">Tháng 11</option>
                            <option value="12">Tháng 12</option>
                            <!-- Add more options for each month -->
                        </select>
                        <button type="submit" class="btn btn-primary">Thống kê</button>
                    </form>
                    <table id="datatablesSimple" class="table">
                        <thead>
                        <tr>
                            <td>Ngày</td>
                            <td>Số đơn tiệc</td>
                            <td>Doanh thu</td>
                            <td>Tỉ lệ (%)</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                            <?php
                            $date = $row['date'];
                            $total = $row['total'];
                            $day = date('d', strtotime($date));

                            if (!isset($bookings_by_day[$day])) {
                                $bookings_by_day[$day] = 0;
                                $revenue_by_day[$day] = 0;
                            }
                            $bookings_by_day[$day]++;
                            $revenue_by_day[$day]+= $total;

                            $total_revenue += $total;

                            $revenue_rate = ($total - $previous_revenue) / ($previous_revenue != 0 ? $previous_revenue : 1);
                            if ($revenue_rate > 1)
                            {
                                $revenue_rate = 0;
                            }
                            $previous_revenue = $total;
                            ?>
                            <tr>
                                <td><?=$date; ?> </td>
                                <td><?=$bookings_by_day[$day];?></td>
                                <td><?=number_format($revenue_by_day[$day],0,".",","); ?> </td>
                                <td><?=number_format($revenue_rate*100,2); ?> </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                        <td>
                            Tổng quát: <?=number_format($total_revenue,0,".",",");?>
                        </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>

<?php include 'foot.php'; ?>