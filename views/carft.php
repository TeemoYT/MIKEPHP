<?php
require_once __DIR__ . "/../module/carftModule.php";
$carftModule = new CarftModule();
$getCarft = [];
$sumItem = 0;
$productName;
$productPrice;
$productSize;
$quantity;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

  
    if (isset($_COOKIE['cartItem'])) {
        $decodedData = base64_decode($_COOKIE['cartItem']);
        $cartData = json_decode($decodedData, true);
    
        if (!is_array($cartData)) {
            setcookie("cartItem", "", time() - 3600, "/");
            echo "Cookie đã bị xóa vì dữ liệu lỗi!";
            exit;
        }
    
        foreach ($cartData as $item) {
            if (!is_array($item)) continue; 
    
            $productName = $item['name'] ?? '';
            $productPrice = $item['price'] ?? 0;
            $productSize = $item['size'] ?? '';
            $quantity = $item['quantity'] ?? 1;
            $image_url=$item['image_url']??'';
            $productId=$item['id'];
            $existingItem = $carftModule->getCart($userId, $productId, $productSize,$image_url);
    
            if (!$existingItem) {
                setcookie("cartItem", "", time() - 3600, "/");
                $carftModule->addCart($userId, $productId, $productSize, $quantity);
            }
        }
    }
    

    
    $getCarft = $carftModule->getCart($userId);

} else {
   
    if (isset($_COOKIE['cartItem'])) {
        $decodedData = base64_decode($_COOKIE['cartItem']);
        $getCarft = json_decode($decodedData, true) ?? [];
    } else {
        $getCarft = [];
    }
}

?>

<div class="card">
    <div class="row row-cols-2">
        <div class="col-8 ps-5 pt-4 pb-4">
            <div class="p-3 d-flex align-items-end">
                <h3 class="me-1">Giỏ hàng </h3>
                <div class="ms-1 mb-2">(1 sản phẩm)</div>
            </div>

            <div class="card w-100 p-2 mt- mb-2">
                <?php
                $index = 0;
                $imagePath;
                $imageFullPath;
                foreach ($getCarft as $item) {
                    $imagePath = "/MIKEPHP/img/" . $item['image_url'];
                    $imageFullPath = __DIR__ . "/../img/" . $item['image_url'];
                    if (empty($item) || !file_exists($imageFullPath)) {
                        $imagePath = "/MIKEPHP/img/default.png";
                    }
                    $sumItem = $sumItem + ($item["price"] * $item['quantity']);
                ?>
                    <div class="border-bottom  mt-3 pb-3 row row-cols-5">
                        <div class="col">
                            <img src="<?php echo $imagePath; ?>" class="img-fluid rounded" style="max-width: 8rem;" alt="">
                        </div>
                        <div class="col-9">
                            <div>
                                <div class=" d-flex justify-content-between text-align-baseline">
                                    <div>
                                        <h6><?php echo  $item['name'] ?></h6>
                                    </div>
                                    <div class="input-group-sm d-flex">
                                        
                                        <span>Số lượng: <?php echo $item['quantity']; ?></span>
                                        
                                    </div>
                                    <div>
                                        <h5><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</h5>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <form action="/MIKEPHP/cart/delete" method="POST">
                                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                    <div class="border-bottom pt-5 pb-2"></div>
                                    <div class="d-flex mt-1 justify-content-between">
                                        <div class="mt-auto p-2"><span>Size: </span><span class="text-success"> <?php echo  $item['size'] ?></span></div>
                                        <button class="btn btn-outline-danger" onclick="deleteItem(<?php echo $item['id'] ?>, this)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                <?php $index++;
                } ?>
            </div>


        </div>
        <div class="col-4 pe-4 pt-4 pb-4">
            <div class="p-3">
                <h4>Thanh Toán</h4>
                <div>
                    <div class="d-flex justify-content-between">
                        <p>Tổng giá trị sản phẩm</p>
                        <p><?php echo number_format($sumItem, 0, ',', '.'); ?> đ</p>
                    </div>
                </div>
                <div>
                    <Button class="w-100 mt-2 mb-2 btn btn-info text-white">Mobile banking</Button>
                    <Button class="w-100 mt-2 mb-2 btn btn-momo text-white">Mua siêu tốc với MoMo</Button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>



    function deleteItem(itemId, button) {
        if (!confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) return;
        
    }



</script>