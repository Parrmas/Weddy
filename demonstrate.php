<?php
    // Initiate variables
    require_once(__DIR__ . '/classes/DbConnection.php');
    require_once(__DIR__ . '/classes/BookingRepository.php');
    require_once(__DIR__ . '/classes/Type.php');
    require_once(__DIR__ . '/classes/Shift.php');
    require_once(__DIR__ . '/classes/Product.php');
    require_once(__DIR__ . '/classes/Service.php');
    require_once(__DIR__ . '/classes/Dish.php');
    require_once(__DIR__ . '/classes/Booking.php');

    $db = new DbConnection();
    $booking_repository = new BookingRepository($db);
    // Create Object Array
    $types = array();
    $shifts = array();
    $services = array();
    $dishes = array();
    // Data Context
    $types = Type::toList();
    $shifts = Shift::toList();
    $services = Service::toList();
    $dishes = Dish::toList();

    //Submit
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Get post values
        $booking = new Booking();
        $object['person_1_name'] = $_POST['name1'];
        $object['person_2_name'] = $_POST['name2'];
        $object['phone'] = $_POST['phone'];
        $object['date'] = $_POST['date'];
        $object['type_id'] = $_POST['type'];
        $object['shift_id'] = $_POST['shift'];
        $object['amount'] = $_POST['amount'];
        $object['no_of_table'] = $_POST['noOfTable'];
        $object['no_of_reserved_table'] = $_POST['noOfReservedTable'];
        $booking->setBookingData($object);

        // Explode the | between the id and tag to make an array with id and tag
        $chosen_products = array();
        foreach ($_POST['products'] as $product) {
            list($id, $tag) = explode('|', $product);
            $chosen_products[] = array('id' => $id, 'tag' => $tag);
        }
        // Get all details of chosen products
        $products = array();
        $products = $booking_repository->getChosenProductsDetails($chosen_products);

        // Calculate booking total
        $total = $booking_repository->calculateTotal($booking, $products);
        $booking->setTotal($total);

        // Add booking and products
        $booking_repository->addBooking($booking);
        $booking_repository->addProducts($booking->getId(), $products);
        header('Location: thankyou.php');
        exit();
    }
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
                                                <?php foreach ($types as $row): ?>
                                                    <option value="<?= $row->getId(); ?>" data-price="<?= $row->getPrice(); ?>"><?= $row->getName(); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="inputType">Sảnh</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select id="inputShift" class="form-select" name="shift">
                                                <?php foreach ($shifts as $row): ?>
                                                    <option value="<?= $row->getId(); ?>"><?= $row->getShiftName(); ?></option>
                                                <?php endforeach; ?>
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
                                    <?php foreach ($dishes as $row): ?>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-check">
                                                        <input class="form-check-input dish" type="checkbox" id="inputDishes<?= $row->getId(); ?>" name="products[]" value="<?= $row->getId() . '|dish'; ?>" data-price="<?= $row->getPrice(); ?>">
                                                        <label class="form-check-label"><?= $row->getName(); ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label><?= number_format($row->getPrice(), 0, '.', ','); ?>đ</label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
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
                                        <?php foreach ($services as $row): ?>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-check">
                                                            <input class="form-check-input service" type="checkbox" id="inputServices<?= $row->getId(); ?>" name="products[]" value="<?= $row->getId() . '|service'; ?>" data-price="<?= $row->getPrice(); ?>">
                                                            <label class="form-check-label"><?= $row->getName(); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label><?= number_format($row->getPrice(), 0, '.', ','); ?>đ</label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
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
    $(document).ready(function() {
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
