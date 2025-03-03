<?php
require_once __DIR__ . "/../module/carftModule.php";
$carftModule = new CarftModule();
$getCarft;
$sumItem = 0;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $getCarft = $carftModule->getCart($userId);
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
                                        <h6>Name:<?php echo  $item['name'] ?></h6>
                                    </div>
                                    <div class="input-group-sm d-flex">
                                        <button onclick="decrease(<?php echo $index; ?>)" class="input-group-text">-</button>
                                        <input onkeydown="return blockInvalidInput(event)" id="numberInput_<?php echo $index; ?>" class="form-control" style="max-width: 45px;" name="quantity" type="number" required min="1" max="50" step="1" placeholder="Số lượng" value="<?php echo $item['quantity']; ?>">
                                        <button onclick="increase(<?php echo $index; ?>)" class="input-group-text">+</button>
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
                                        <div class="mt-auto p-2"><span>Tình trạng: </span><span class="text-success">Còn
                                                hàng</span></div>
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
    function decrease(index) {
        let input = document.getElementById("numberInput_" + index);
        let min = parseInt(input.min);
        let value = parseInt(input.value) || min;

        if (value > min) {
            input.value = value - 1;
        }
    }

    function increase(index) {
        let input = document.getElementById("numberInput_" + index);
        let max = parseInt(input.max);
        let value = parseInt(input.value) || 1;

        if (value < max) {
            input.value = value + 1;
        }
    }

    document.querySelectorAll("input[id^='numberInput_']").forEach(input => {
        input.addEventListener("input", function() {
            let min = parseInt(this.min);
            let max = parseInt(this.max);
            let value = parseInt(this.value);

            if (value < min) this.value = min;
            if (value > max) this.value = max;
        });
    });


    function selectSize(button) {

        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.add('btn-light');
        });



        button.classList.add('active');
    }

    function blockInvalidInput(event) {

        if (["e", "E", "+", "-", ".", ","].includes(event.key)) {
            event.preventDefault();
        }
    }


    function deleteItem(itemId, button) {
        if (!confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) return;


    }
</script>