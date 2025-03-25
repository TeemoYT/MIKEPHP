<div class=" mt-5 container-md">

    <div class="row ">


        <?php
        require_once __DIR__ . "/../module/productModule.php";


        $productsModule = new ProductsModule();
        $itemProduct =   $productsModule->getAll();
        $imageFullPath;$imagePath;
        
        foreach ($itemProduct as $row) {
            $imagePath = "/MIKEPHP/img/" . $row["image_url"];
            $imageFullPath = __DIR__ . "/../img/" . $row["image_url"]; 
            if (empty($row["image_url"]) || !file_exists($imageFullPath)) {
                $imagePath = "/MIKEPHP/img/default.png"; 
            }

        ?>
        <a  class="col-12 col-xs-custom-5 col-sm-3 col-lg-3 mb-32px nav-link me-2 ms-2" href="/MIKEPHP/product/<?php echo$row['slug'] ?>">
            <div class="product-grid-thumb">
                <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <h3 class="card-text"><?php echo$row['name'] ?></h3>
                    <span class="card-price text-danger"><?php echo $row['price'] ?> đ </span>
                </div>
            </div>
        </a>

            <?php }?>

    </div>
</div>