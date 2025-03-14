<?php 
 require_once __DIR__."/../../module/productModule.php";

  $product= new ProductsModule();
  $productItem =  $product->getAll();

 

?>


<div style="overflow-y: auto; height: 750px;">
<table class="table">
  <thead>
    <tr>
      <th scope="col">Ảnh đại diện</th>
      <th scope="col">Danh mục</th>
      <th scope="col">Tên sản phẩm</th>
      <th scope="col">Thương hiệu</th>
      <th scope="col">Mô tả</th>
      <th scope="col">Giá</th>
      <th scope="col">Tồn kho</th>
      <th style="width:11%;"><button type="button" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Thêm</button></th>
    </tr>
  </thead>
  <tbody >
    <?php 
      foreach($productItem as $item){
        $imagePath = "/MIKEPHP/img/" . $item["image_url"];
          if (empty($item["image_url"]) || !file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
            $imagePath = "/MIKEPHP/img/default.png";
          }
        echo "
        <tr>
      <th scope='row'><a class='media-left' href='#'><img class='img-circle img-sm rounded-circle ' alt='Profile Picture'
            src='{$imagePath}' width='50' height='50'></a></th>
        <td>Danh muc</td>
      <td>{$item['name']}</td>
      <td>{$item['trademark_id']}</td>
      <td class='describe'>{$item['description']}</td>
      <td>{$item['price']}</td>
      <td>50</td>
      <td>
        <button class='btn btn-primary'><i class='fa fa-pencil' aria-hidden='true'></i> Sửa</button>
        <button class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Xóa</button>
      </td>
    </tr>";

      }
    
    ?>
    

  </tbody>
</table>