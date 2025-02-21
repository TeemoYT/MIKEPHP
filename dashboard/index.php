

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../dashboard/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

</head>
    
<body>
<div class="dash d-flex">
    <ul class="dash-board">
        <li><a href="#"><img width="80" height="80" src="/MIKEPHP/img/Logo.png" href="#"></a></li>
        <li><a href="./views/dashboard.php">Thông tin tổng quan</a></li>
        <li><a href="./views/product.php">Quản lý sản phẩm</a></li>
        <li><a href="./views/order.php">Quản lý đơn hàng</a></li>
        <li><a href="./views/customer.php">Quản lý thanh toán</a></li>
        <li><a href="./views/payment.php">Báo cáo và phân tích</a></li>
        <li><a href="./views/report.php">Thông báo</a></li>
    </ul>
    <div class="right" style="width: 100%;">
        <?php include("./views/dashboard.php"); ?>

<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

    </div>
</div>

<script src="./js/javascript.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>