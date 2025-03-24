<?php
require_once __DIR__ . "/../module/productModule.php";
$productsModule = new ProductsModule();
$path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$slug = end($path);
$productImage = $productsModule->getProductByImage($slug);

$productItem = $productsModule->getProductByItem($slug);
$sizeJson;
$imageJson;
$imageUrl;
$imageFullPath;

$cart;


?>
<div class="information-container">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <div class="row">
          <div class="col-10">
            <?php

            if ($productImage)
              $imageJson = json_decode($productImage['image_json'], true) ?? [];
            $imageUrl = "/MIKEPHP/img/" . $productImage['image_url'];
            // $sizeJson = json_decode($productSizeJson['size_json'], true) ?? [];
            $imageFullPath = __DIR__ . "/../img/" . $productImage['image_url'];
            if (!file_exists($imageFullPath)) {
              $imageUrl = "/MIKEPHP/img/default.png";
            }
            ?>
            <img src="<?php echo htmlspecialchars($imageUrl) ?>" class=" img-thumbnail" style="width: 100%;" alt="">
          </div>
          <div class="col-2">
            <?php
            $imagePath;
            $imageFullPath;
            foreach ($imageJson as $row) {
              $imagePath = "/MIKEPHP/img/" . $row;
              $imageFullPath = __DIR__ . "/../img/" . $row;
              if (empty($row) || !file_exists($imageFullPath)) {
                $imagePath = "/MIKEPHP/img/default.png";
              }
            ?>
              <div class="row"><img style="width: 150px;" src="<?php echo $imagePath; ?>" alt=""></div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-6">
        <tr>
          <td>
            <div>

              <h4><?php
                  echo $productItem["name"];

                  ?></h4>
            </div>
            <div class="d-flex rating">
              <p class="box-tag"><?php
                                  $rating = $productsModule->getProductByRating($slug);
                                  echo $rating['avg_rating'];
                                  ?>
                <span class="fa fa-star checked"></span>
              </p>
              <p class="ms-1"><?php echo $rating['total_reviews'] ?> Đánh giá</p>
              <p class="ms-1"> | 250k Sold | </p>
              <p class="ms-1">
                <i class="fa fa-heart-o" aria-hidden="true"></i>
                <span class="like-text">Đã thích (26,8k)</span>
              </p>
            </div>
          </td>
          <td>
            <div class="infor">
              <h3>₫<?php
                    echo $productItem["price"];

                    ?></h3>
            </div>
          </td>
          <td>
            <div class="flex flex-column">
              <section class="flex items-center">
                <h6>Vận chuyển</h6>
                <div class="flex items-center">
                  <p>🚚 Nhận từ 17 Th 03 - 19 Th 03</p>
                </div>
              </section>
              <section class="flex items-center" style="margin-bottom: 24px; align-items: baseline;">
                <h6>Size</h6>
                <div class="flex items-center">
                  <!-- <?php
                        $disable = 'disabled';
                        foreach ($sizeJson as $size) {
                          $sizeNumber = $size[0];
                          $sizeActi = $size[1];
                        ?>
                    <button
                      <?php echo $sizeActi ? '' : $disable ?>
                      type="button"
                      class="btn btn-light size-btn"
                      onclick="selectSize(this)">
                      <?php echo $sizeNumber ?>
                    </button>
                  <?php } ?> -->


                </div>
              </section>
          </td>
          <td>
            <section class="flex items-center">
              <h6>Số Lượng</h6>
              <div class="flex items-center">
                <button onclick="decrease()" class="input-group-text">-</button>
                <input onkeydown="return blockInvalidInput(event)" id="numberInput" class="form-control" style="max-width: 45px;" name="quantity" type="number" required="" min="1" max="50" step="1" placeholder="Số lượng" value="1">
                <button onclick="increase()" class="input-group-text">+</button>
              </div>
            </section>
      </div>
      </td>
      <td>
        <div class="high-button-section">
          <button class="btn btn-1 btn-danger" id="addToCart">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
            <span>Thêm Vào Giỏ Hàng</span>
          </button>
          <button class="btn btn-2 btn-danger">
            <span>Mua</span>
          </button>
        </div>
      </td>
      </tr>
    </div>
  </div>
</div>
<!-- Mô tả -->
<div class="Product-Description">
  <h4>CHI TIẾT SẢN PHẨM</h4>
  <h5>MÔ TẢ SẢN PHẨM</h5>
  <ul>
    <li>Dép nữ với thiết kế quai ngang bản to nhún cách điệu, dép được làm bằng chất ulệu da tổng hợp cao cấp nên rất êm mềm và bền bỉ.</li>
    <li>Dép nữ với thiết kế quai ngang bản to nhún cách điệu, dép được làm bằng chất liệu da tổng hợp cao cấp nên rất êm mềm và bền bỉ.</li>
    <li>Dép nữ với thiết kế quai ngang bản to nhún cách điệu, dép được làm bằng chất liệu da tổng hợp cao cấp nên rất êm mềm và bền bỉ.</li>
  </ul>

  <h5>CHI TIẾT</h5>
  <ul>
    <li>Chiều cao: Khoảng 3cm</li>
    <li>Chất liệu: Da mềm tổng hợp cao cấp</li>
    <li>Kiẻu dáng: Dép nữ quai ngang bản to, dép thời trang nữ</li>
  </ul>
</div>

<!-- đánh giá sản phẩm -->
<div class="col-6-1 evaluate">
  <h5>ĐÁNH GIÁ SẢN PHẨM</h5>

  <div class="container bootdey">
    <div class="col-md-12 bootstrap snippets" style="margin-left: -133px;">
      <div class="panel">
        <div class="panel-body">
          <?php
          $comment = $productsModule->getProductByComment($slug);
          foreach ($comment as $row) {
          ?>
            <div class="media-block">
              <a class="media-left" href="#"><img class="img-circle img-sm rounded-circle " alt="Profile Picture"
                  src="https://bootdey.com/img/Content/avatar/avatar1.png"></a>
              <div class="media-body">
                <div class="mar-btm ">
                  <div class=" d-flex">
                    <a href="#" class="btn-link text-semibold media-heading box-inline"><?php echo $row['user_name'] ?></a>
                    <p class="box-tag">
                      <?php
                      $checked = "";
                      echo $row['rating'];
                      if ($row['rating'] > 0) {
                        $checked = "checked";
                      }
                      ?>
                      <span class="fa fa-star <?php echo $checked ?>"></span>
                    </p>
                  </div>
                  <p class="text-muted text-sm mb-1"><?php
                                                      date_default_timezone_set('Asia/Ho_Chi_Minh');

                                                      $postTime = strtotime($row['created_at']);
                                                      $currentTime = time();

                                                      $timeDiff = $currentTime - $postTime;

                                                      if ($timeDiff < 60) {
                                                        echo $timeDiff . " giây trước";
                                                      } elseif ($timeDiff < 3600) {
                                                        echo floor($timeDiff / 60) . " phút trước";
                                                      } elseif ($timeDiff < 86400) {
                                                        echo floor($timeDiff / 3600) . " giờ trước";
                                                      } else {
                                                        echo floor($timeDiff / 86400) . " ngày trước";
                                                      } ?></p>
                </div>
                <p class="ms-3"><?php echo $row['comment'] ?></p>

                <!-- <hr> -->
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <!-- <div class="panel">
        <div class="panel-body-comment">
          <form id="commentForm" action="/MIKEPHP/product/<?php echo $slug; ?>" method="post" style="width: 560px;">
            <textarea name="textComment" id="textComment" class="form-control" style="max-height: 200px;" value="" rows="2"
              placeholder="What are you thinking?"></textarea>
            <div class="mar-top clearfix">
              <button id="commentPost" name="commentPost" class="btn btn-sm btn-primary pull-right" type="submit"><i
                  class="fa fa-pencil fa-fw"></i> Share</button>
              <a><i class="fa fa-camera" aria-hidden="true" href="#"></i></a>
              <a><i class="fa fa-video-camera" aria-hidden="true" href="#"></i></a>
              <a><i class="fa fa-file" aria-hidden="true" href="#"></i></a>
            </div> -->
      </form>
    </div>
  </div>
</div>
<script>
  function decrease() {
    let input = document.getElementById("numberInput");
    let min = parseInt(input.min);
    let value = parseInt(input.value) || min;

    if (value > min) {
      input.value = value - 1;
    }
  }

  function increase() {
    let input = document.getElementById("numberInput");
    let max = parseInt(input.max);
    let value = parseInt(input.value) || 1;

    if (value < max) {
      input.value = value + 1;
    }
  }
  document.getElementById("numberInput").addEventListener("input", function() {
    let min = parseInt(this.min);
    let max = parseInt(this.max);
    let value = parseInt(this.value);

    if (value < min) this.value = min;
    if (value > max) this.value = max;

  });

  function selectSize(button) {

    document.querySelectorAll('.size-btn').forEach(btn => {
      btn.classList.remove('active');
      btn.classList.add('btn-light');
    });
  }

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
 

  function comment() {
    let slug = window.location.pathname.split("/").pop();
    let textComment = document.getElementById("textComment").value.trim();

    if (!textComment) {
      alert("Vui lòng nhập nội dung bình luận!");
      return;
    }


  }


  document.getElementById("addToCart").onclick = function() {
    addToCart()
  };


  let newItem = {};

  function addToCart() {
    let isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

    if (!isLoggedIn) {
      alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!");
      window.location.href = "/MIKEPHP/login";
      return;
    }
    let productName = "<?php echo addslashes($productItem['name']); ?>";
    let productId = "<?php echo addslashes($productItem['id']); ?>";
    let productPrice = "<?php echo addslashes($productItem['price']); ?>";
    let productImageURL = "<?php echo addslashes($productImage['image_url']); ?>";
    let selectedSize = document.querySelector('.size-btn.active') ? document.querySelector('.size-btn.active').textContent.trim() : "";
    let quantity = parseInt(document.getElementById("numberInput").value);

    if (!selectedSize) {
      alert("Vui lòng chọn size!");
      return;
    }

    newItem = {
      id: productId,
      name: productName,
      price: productPrice,
      size: selectedSize,
      quantity: quantity,
      image_url: productImageURL
    };

    fetch("/MIKEPHP/cart/add", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(newItem)
      })
      .then(response => response.json())
      .then(data => {
        alert(data.message);
      })
      .catch(error => {
        console.error("Lỗi khi thêm vào giỏ hàng:", error);
      });

  }
</script>
</div>