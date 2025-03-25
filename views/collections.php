<h1>Danh mục: <?php echo htmlspecialchars($category_name); ?></h1>
<div class="mt-5 container-md">
    <div class="row">
        <?php if (!empty($products) && is_array($products)): ?>
            <?php foreach ($products as $row): ?>
                <?php
                $imagePath = "/MIKEPHP/img/" . htmlspecialchars($row["image_url"]);
                $imageFullPath = __DIR__ . "/../img/" . $row["image_url"];

                if (empty($row["image_url"]) || !file_exists($imageFullPath)) {
                    $imagePath = "/MIKEPHP/img/default.png";
                }
                ?>

                <a class="col-12 col-xs-custom-6 col-sm-3 col-lg-3 mb-32px nav-link me-2 ms-2" href="/MIKEPHP/product/<?php echo $row['slug'] ?>">
                    <div class="product-grid-thumb">
                        <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="">
                        <div class="card-body">
                    <h3 class="card-text"><?php echo$row['name'] ?></h3>
                    <span class="card-price text-danger"><?php echo $row['price'] ?> đ </span>
                </div>
                    </div>
                </a>

            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có sản phẩm nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
</div>