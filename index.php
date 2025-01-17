<?php
include 'connection.php';

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name1 = $_POST['name1'];
    $name2 = $_POST['name2'];
    $phone = $_POST['phone'];
    $date = date_create_from_format("d/m/Y", $_POST['date']);
    $date_formatted = date_format($date,"Y-m-d");
    $type = $_POST['type'];
    $shift = $_POST['shift'];
    $amount = $_POST['amount'];
    $noOfTable = $_POST['noOfTable'];
    $noOfReservedTable = $_POST['noOfReservedTable'];
    $dishes = $_POST['dishes'];
    $services = $_POST['services'];

    $typePrice = get_value($db,"SELECT price FROM types WHERE id = '$type' LIMIT 1");
    $total = $typePrice * $noOfTable;

    foreach($dishes as $dishId){
        $dishPrice = get_value($db,"SELECT price FROM dishes WHERE id = '$dishId' LIMIT 1");
        $total += $dishPrice * $noOfTable;
    }

    foreach($services as $serviceId){
        $servicePrice = get_value($db,"SELECT price FROM services WHERE id = '$serviceId' LIMIT 1");
        $total += $servicePrice;
    }

    $query = "INSERT INTO bookings (person_1_name, person_2_name, phone, date, amount, no_of_table, no_of_reserved_table, type_id, shift_id, total)
     VALUES ('$name1', '$name2', '$phone', '$date_formatted', '$amount', '$noOfTable', '$noOfReservedTable', '$type', '$shift', '$total')";
    
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
    $booking_id = $db->insert_id;

    if(!empty($dishes)){
        $query2 = "INSERT INTO booking_dishes (booking_id, dish_id) VALUES ";

        foreach($dishes as $index => $dish){
            $query2 .= "('$booking_id', '$dish')";
    
            if($index != count($dishes) - 1) $query2 .= ", ";
        }
    
        $result = mysqli_query($db, $query2) or die(mysqli_error($db));
    }
   
    if(!empty($services)){
        $query3 = "INSERT INTO booking_services (booking_id, service_id) VALUES ";

        foreach($services as $index => $service){
            $query3 .= "('$booking_id', '$service')";

            if($index != count($service) - 1) $query3 .= ", ";
        }

        $result = mysqli_query($db, $query3) or die(mysqli_error($db));
    }

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

<?php include 'main-page-header.php'?>
<?php include 'quote.php'?>
<section class="u-clearfix u-palette-3-light-3 u-section-2" id="sec-b2e1">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-group u-radius-50 u-shape-round u-white u-group-1" style="margin-top: 20px">
            <div class="u-container-layout u-container-layout-1" style="padding-left:20px;padding-right: 20px">
                <div class="container-fluid px-4">
                    <h1 class="mt-4" style="text-align: center">Đặt tiệc cưới</h1>
                    <form method="POST" action="">
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
                                                    <?php while($row = mysqli_fetch_array($types)): ?>
                                                        <option value="<?= $row['id']; ?>" data-price="<?= $row['price']; ?>"><?= $row['name']; ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                                <label for="inputType">Sảnh</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-floating">
                                                <select id="inputShift" class="form-select" name="shift">
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
                                                        <input class="form-check-input dish" type="checkbox" id="inputDishes<?= $row['id']; ?>" name="dishes[]" value="<?= $row['id']; ?>" data-price="<?= $row['price']; ?>">
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
                                                        <input class="form-check-input service" type="checkbox" id="inputServices<?= $row['id']; ?>" name="services[]" value="<?= $row['id']; ?>" data-price="<?= $row['price']; ?>">
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
                        <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Tổng kết
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label>Thành tiền: <b id="total">0đ</b></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0" style="margin: 0 auto; width: 150px;padding-bottom: 10px;">
                                <button type="submit" name="action" value="add" class="btn btn-primary" style="width: 150px">Gửi</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'contribution.php'?>
<?php include 'main-page-footer.php'?>

<script type="text/javascript">
$(function () {  
    $("#inputDate").datepicker({         
        autoclose: true,         
        todayHighlight: true,
        format: "dd/mm/yyyy"
    }).datepicker('update', new Date());
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
    $('#inputNoOfTable').change(function(){
        var price = $('#inputType option:selected').data('price');
        var noOfTable = $(this).val();

        $('#total').html(formatMoney(price * noOfTable, 0) + 'đ');
    });
    $(".form-check-input").change(function() {
        var price = $('#inputType option:selected').data('price');
        var noOfTable = $('#inputNoOfTable').val();

        total = price * noOfTable;

        $(".form-check-input.dish:checked").each(function(){
            var selPrice = $(this).data('price');
            total += selPrice * noOfTable;
        });

        $(".form-check-input.service:checked").each(function(){
            var selPrice = $(this).data('price');
            total += selPrice;
        });
        
        $('#total').html(formatMoney(total, 0) + 'đ');
    });
    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign +
            (j ? i.substr(0, j) + thousands : '') +
            i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
            (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            console.log(e)
        }
    };
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