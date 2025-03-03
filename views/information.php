<?php
require_once __DIR__ . "/../module/productModule.php";
$productsModule = new ProductsModule();
$path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$slug = end($path);
$productImage = $productsModule->getProductByImage($slug);
$productSizeJson = $productsModule->getProductBySize($slug);
$productItem = $productsModule->getProductByItem($slug);
$sizeJson;
$imageJson;
$imageUrl;
$imageFullPath;

?>
<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="row">
        <div class="col-10">
          <?php

          if ($productImage) {
            $imageJson = json_decode($productImage['image_json'], true) ?? [];
            $imageUrl = "/MIKEPHP/img/" . $productImage['image_url'];
            $sizeJson = json_decode($productSizeJson['size_json'], true) ?? [];
            $imageFullPath = __DIR__ . "/../img/" . $productImage['image_url'];
            if (!file_exists($imageFullPath)) {
              $imageUrl = "/MIKEPHP/img/default.png";
            }
          } else {
            $imageJson = '[]';
            $imageUrl = "/MIKEPHP/img/default.jpg";
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
      <h5>ĐÁNH GIÁ SẢN PHẨM</h5>
      <div class="d-flex">
        <p class="box-tag"><?php
                            $rating = $productsModule->getProductByRating($slug);
                            echo $rating['avg_rating'];
                            ?>
          <span class="fa fa-star checked"></span>
        </p>
        <p class="ms-1"><?php echo $rating['total_reviews'] ?> Đánh giá</p>
      </div>
      <div class="container bootdey">
        <div class="col-md-12 bootstrap snippets">
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
                    <hr>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="panel">
            <div class="panel-body-comment">
              <form id="commentForm" method="post">
                <textarea name="textComment" id="textComment" class="form-control" style="max-height: 200px;" value="" rows="2"
                  placeholder="What are you thinking?"></textarea>
                <div class="mar-top clearfix">
                  <button name="commentPost" class="btn btn-sm btn-primary pull-right" type="submit"><i
                      class="fa fa-pencil fa-fw"></i> Share</button>
                  <a><i class="fa fa-camera" aria-hidden="true" href="#"></i></a>
                  <a><i class="fa fa-video-camera" aria-hidden="true" href="#"></i></a>
                  <a><i class="fa fa-file" aria-hidden="true" href="#"></i></a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <tr>
        <td>
          <div>

            <h4><?php
                echo $productItem["name"];

                ?></h4>
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
            <section class="flex items-center" style="margin-bottom: 24px; align-items: baseline;">
              <h6>Size</h6>
              <div class="flex items-center">
                <?php
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
                <?php } ?>


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
        <button class="btn btn-1 btn-danger">
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
  </script>