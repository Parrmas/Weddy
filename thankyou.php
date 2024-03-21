<?php include 'headWithoutNav.php'; ?>
<main>
    <div class="container-fluid px-4">
        <div class="text-center">
            <h1>Xin cảm ơn</h1>
                <p>Nhân viên của chúng tôi sẽ liên hệ bạn sớm nhất có thể!</p>
                <button class="btn btn-primary" type="submit" onclick="back()">
                    Trở về trang chủ
                </button>
        </div>
    </div>
</main>
<?php include 'foot.php'; ?>

<script>
    function back(){
        window.location.replace("http://vutt94.io.vn/weddy/index.php");
    }      
</script>