<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="row">
        <div class="col-10">
          <?php
          require_once __DIR__ . "/../module/productModule.php";
          $productsModule = new ProductsModule();


          $path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
          $slug = end($path);

          $productImage = $productsModule->getProductByImage($slug);
          $productSizeJson = $productsModule->getProductBySize($slug);
          $productItem=$productsModule->getProductByItem($slug);
          $sizeJson ;
          $imageJson;
          $imageUrl;
          $imageFullPath;
          if ($productImage) {
            $imageJson = json_decode($productImage['image_json'], true) ?? [];
            $imageUrl = "/MIKEPHP/img/" . $productImage['image_url'];
            $sizeJson = json_decode($productSizeJson['size_json'], true) ?? [];
            $imageFullPath = __DIR__ . "/../img/". $productImage['image_url'];
            if(!file_exists($imageFullPath)){
              $imageUrl="/MIKEPHP/img/default.png";
            }

            
          } else {
            $imageJson = '[]';
            $imageUrl = "/MIKEPHP/img/default.jpg";
          }

          ?>
          <img src="<?php echo htmlspecialchars($imageUrl); ?>" class=" img-thumbnail" style="width: 100%;" alt="">
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
      <div>
        <h5>ĐÁNH GIÁ SẢN PHẨM</h5>
      </div>
      <div class="container bootdey">
        <div class="col-md-12 bootstrap snippets">
          <div class="panel">
            <div class="panel-body">
              <!-- Newsfeed Content -->
              <!--===================================================-->
              <div class="media-block">
                <a class="media-left" href="#"><img class="img-circle img-sm rounded-circle " alt="Profile Picture"
                    src="https://bootdey.com/img/Content/avatar/avatar1.png"></a>
                <div class="media-body">
                  <div class="mar-btm">
                    <a href="#" class="btn-link text-semibold media-heading box-inline">Lisa D.</a>
                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> - From Mobile - 11 min ago</p>
                  </div>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, velit! Asperiores debitis
                    voluptates rem esse nostrum, qui modi harum aliquid temporibus minus omnis non! Fugiat, aperiam
                    cupiditate. Similique, sapiente recusandae.</p>
                  <div class="pad-ver">
                    <div class="btn-group">
                      <a class="btn btn-sm btn-default btn-hover-success" href="#"><i class="fa fa-thumbs-up"></i></a>
                      <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i class="fa fa-thumbs-down"></i></a>
                    </div>
                    <a class="btn btn-sm btn-default btn-hover-primary" href="#">Comment</a>
                  </div>
                  <hr>
                </div>
              </div>
            </div>
          </div>
          <!-- comment -->
          <div class="panel">
            <div class="panel-body-comment">
              <textarea id="textComment" class="form-control" style="max-height: 200px;" value="" rows="2"
                placeholder="What are you thinking?"></textarea>
              <div class="mar-top clearfix">
                <button onclick="testCommet()" id="id" class="btn btn-sm btn-primary pull-right" type="submit"><i
                    class="fa fa-pencil fa-fw"></i> Share</button>
                <a><i class="fa fa-camera" aria-hidden="true" href="#"></i></a>
                <a><i class="fa fa-video-camera" aria-hidden="true" href="#"></i></a>
                <a><i class="fa fa-file" aria-hidden="true" href="#"></i></a>
              </div>
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
                  $disable ='disabled';
                foreach ($sizeJson as $size) {
                  $sizeNumber = $size[0];
                  $sizeActi = $size[1];
                ?>
                <button <?php echo $sizeActi ? '': $disable  ?> type="button" class="btn btn-light"> <?php echo $sizeNumber ?></button>

                <?php } ?>

              </div>
            </section>

        </td>
        <td>
          <section class="flex items-center">
            <h6>Số Lượng</h6>
            <div class="flex items-center">
              <button class="input-group-text">-</button>
              <input class="form-control" style="max-width: 38px;" name="quantity" type="number" required="" min="1" max="50" step="1" placeholder="Số lượng" value="1">
              <button class="input-group-text">+</button>
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