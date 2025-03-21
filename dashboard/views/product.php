<?php
require_once __DIR__ . "/../../module/productModule.php";

$product = new ProductsModule();
$productItem =  $product->getAllProducts();




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
    <tbody>
      <?php
      foreach ($productItem as $item) {
        $imagePath = "/MIKEPHP/img/" . $item["image_url"];
        if (empty($item["image_url"]) || !file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
          $imagePath = "/MIKEPHP/img/default.png";
        }
        echo "
        <tr>
      <th scope='row'><a class='media-left' href='#'><img class='img-circle img-sm rounded-circle ' alt='Profile Picture'
            src='{$imagePath}' width='50' height='50'></a></th>
        <td>{$item['category_names']}</td>
      <td>{$item['product_name']}</td>
      <td>{$item['trademark_name']}</td>
      <td class='describe'>{$item['description']}</td>
      <td>{$item['price']}</td>
      <td>{$item['total_stock']}</td>
      <td>
        <button data-id='{$item['product_id']}'
                        data-product='{$item['product_name']}'
                         class='btn btn-primary edit-btn'><i class='fa fa-pencil' aria-hidden='true'></i> Sửa</button>
        <button class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Xóa</button>
      </td>
    </tr>";
      }

      ?>


    </tbody>
  </table>

  <!-- Popup -->

  <div id="editPopup" class="popup-overlay" style="display: none;z-index:9999;overflow-y: auto;max-height:auto;">
    <div class="popup-content" style="left:35%;top:10%;">
      <button class="close-btn" onclick="closePopup()">X</button>
      <h2>Chỉnh sửa sản phẩm</h2>
      <div id="editForm" class="">
        <input type="hidden" id="editOrderId">

        <label for="editProductName">Sản phẩm:</label>
        <input type="text" id="editProductName">

        <label for="editPrice">Giá:</label>
        <input type="text" id="editPrice">

        <label for="editQuantity">Số lượng:</label>
        <input type="number" id="editQuantity" min="1">
        <div id="editColor" class="editAddColor w-100" style="overflow-y: auto; height: 350px;margin-top:10px">
          <div class="editColorInfo d-flex ">

            <div class="editColorInfo mt-2">
              <label for="editAddColorInfoName">Tên Màu:</label>
              <input type="text" id="editAddColorInfoName">
            </div>
            <div class="w-100 mt-2">
              <div class="editAddSize">
                <div class="d-flex">
                  <div>
                    <label for="">Size:</label>
                    <input type="text" name="" id="">
                  </div>
                  <div>
                    <label for="">Số lượng:</label>
                    <input type="text">
                  </div>
                  <button class="btn btn-danger " style="height: 50px;margin-top:25px"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </div>
                <div class="d-flex">
                  <div>
                    <label for="">Size:</label>
                    <input type="text" name="" id="">
                  </div>
                  <div>
                    <label for="">Số lượng:</label>
                    <input type="text">
                  </div>
                  <button class="btn btn-danger " style="height: 50px;margin-top:25px"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </div>
              </div>

              <button class="w-100" style="margin-top: 20px;"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
            <div class="mb-5">
              <button class="btn btn-danger ">X</button>
            </div>
          </div>

          <div style="margin-left: 15%; margin-top:50px;">
            <button class="editAddColorButton w-75 "><i class="fa fa-plus" aria-hidden="true"></i></button>
          </div>
        </div>
        <div style="margin: 10px;">
          <label for="">Danh mục</label>
          <div class="category-container"></div>
        </div>

        <button type="button" onclick="saveChanges()">Lưu</button>
        <button type="button" onclick="closePopup()">Hủy</button>
      </div>
    </div>
  </div>
</div>



<script>
  document.addEventListener("DOMContentLoaded", function() {
    let productData = <?= json_encode($productItem, JSON_HEX_TAG); ?>;

    document.querySelectorAll(".edit-btn").forEach(button => {
      button.addEventListener("click", function() {
        let productId = this.dataset.id;
        let product = productData.find(item => item.product_id == productId);

        if (product) {
          document.getElementById("editOrderId").value = product.product_id;
          document.getElementById("editProductName").value = product.product_name;
          document.getElementById("editPrice").value = product.price;
          document.getElementById("editQuantity").value = product.total_stock;

          // Xử lý danh mục
          let categoryContainer = document.querySelector(".category-container");
          categoryContainer.innerHTML = ""; // Xóa danh mục cũ

          if (product.category_names) {
            let categories = product.category_names.split(", ");
            let showMore = categories.length > 3;

            categories.forEach((category, index) => {
              let categoryDiv = document.createElement("div");
              categoryDiv.className = "category";
              categoryDiv.innerHTML = `${category} <button class="btnCategory remove">&times;</button>`;

              if (index >= 4) {
                categoryDiv.classList.add("hidden");
              }

              categoryContainer.appendChild(categoryDiv);
            });

            if (showMore) {
              let expandBtn = document.createElement("button");
              expandBtn.innerText = ">";
              expandBtn.className = "btnCategory ";
              expandBtn.onclick = function() {
                let hiddenCategories = document.querySelectorAll(".category.hidden");

                if (hiddenCategories.length > 0) {

                  hiddenCategories.forEach(el => el.classList.remove("hidden"));
                  this.innerText = "<";
                } else {
                  let allCategories = document.querySelectorAll(".category");
                  allCategories.forEach((el, index) => {
                    if (index >= 4) el.classList.add("hidden");
                  });
                  this.innerText = ">";
                }

              };

              categoryContainer.appendChild(expandBtn);
            }

          }


          let addCategoryBtn = document.createElement("button");
          addCategoryBtn.innerText = "+";
          addCategoryBtn.className = "btnCategory addCategory";
          categoryContainer.appendChild(addCategoryBtn);

          addCategoryBtn.onclick = () => {
            let categories = <?php echo json_encode($product->getCategoriesNotInProduct(1)); ?>;

            
            let existingList = document.getElementById("categoryList");
            if (existingList) return existingList.remove();

            let popup= document.getElementById('editPopup');


            let categoryList = document.createElement("div");
            categoryList.id = "categoryList";
            categoryList.className = "category-dropdown"; // CSS để tạo kiểu dropdown
            popup.appendChild(categoryList);
            let search= document.createElement("input");
              search.className="category-searcch";
              search.inertText= "search"
            categoryList.appendChild(search);
            categories.forEach(category => {
              

              let categoryItem = document.createElement("div");
              categoryItem.className = "category-item";
              categoryItem.innerText = category.name;

              // Xử lý khi nhấn vào danh mục
              categoryItem.onclick = () => {
                addCategoryToProduct(1, category.id, categoryItem);
              };
              
              categoryList.appendChild(categoryItem);
            });

            // Hiển thị danh sách gần nút bấm
            let rect = addCategoryBtn.getBoundingClientRect();
            categoryList.style.position = "absolute";
            categoryList.style.left = rect.left + "px";
            categoryList.style.top = rect.bottom + "px";
            categoryList.style.zIndex="99999";
          };

          // Gửi request để thêm danh mục vào sản phẩm
          function addCategoryToProduct(productId, categoryId, categoryItem) {
            fetch("add_category.php", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  product_id: productId,
                  category_id: categoryId
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  categoryItem.remove(); // Xóa khỏi danh sách khi đã thêm thành công
                } else {
                  alert("Thêm thất bại: " + data.message);
                }
              })
              .catch(error => console.error("Lỗi:", error));
          }


          document.getElementById("editPopup").style.display = "block";
        }
      });
    });

    // Đóng popup
    function closePopup() {
      document.getElementById("editPopup").style.display = "none";
      let existingList = document.getElementById("categoryList");
            if (existingList) return existingList.remove();
    }
    document.querySelector(".close-btn").addEventListener("click", closePopup);
  });



  function saveChanges() {
    let productId = document.getElementById("editOrderId").value;
    let newPrice = document.getElementById("editPrice").value;
    let newStock = document.getElementById("editStock").value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "update_product.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        alert("Cập nhật thành công!");
        location.reload();
      }
    };
    xhr.send(`product_id=${productId}&price=${newPrice}&stock=${newStock}`);
  }
</script>