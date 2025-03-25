<?php
require_once __DIR__ . "/../../module/productModule.php";
require_once __DIR__ . "/../../module/trademarkModule.php";
require_once __DIR__ . "/../../module/productColorModule.php";

$product = new ProductsModule();
$productItem = $product->getAllProducts();

$categoriesModule = new CollectionsModules();
$productCategories = new ProductCategoryModule();
$productCategoriesItem = $productCategories->getProductCategories();

$trademarks = new TrademarkModule();
$trademarkList = $trademarks->getAllTrademarks();

$productColorModule = new ProductColorModule();


$productColorsData = [];
foreach ($productItem as $item) {
    $colors = $productColorModule->getProductColorsAndSizes($item['product_id']);
    $productColorsData[$item['product_id']] = $colors;
}


?>

<div style="overflow-y: auto; height: 750px; overflow-x:hidden;">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Ảnh đại diện</th>
        <th scope="col">Danh mục</th>
        <th scope="col">Tên sản phẩm</th>
        <th scope="col">Thương hiệu</th>
        <th scope="col">Giá</th>
        <th scope="col">Tồn kho</th>
        <th style="width:11%;">
          <button type="button" class="btn btn-success" onclick="openAddProductPopup()">
            <i class="fa fa-plus" aria-hidden="true"></i> Thêm
          </button>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($productItem as $item) {
        $imagePath = "/MIKEPHP/img/" . $item["image_url"];
        if (empty($item["image_url"]) || !file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
          $imagePath = "/MIKEPHP/img/default.png";
        }
        $priceFormatted = number_format($item['price'], 0, ',', '.') . ' vnđ';
        $total_stockFormatted = number_format($item['total_stock'], 0, ',', '.');
        echo "
        <tr>
          <th scope='row'>
            <a class='media-left' href='#'>
              <img class='img-circle img-sm rounded-circle' alt='Product Image' src='{$imagePath}' width='50' height='50'>
            </a>
          </th>
        <td>{$item['category_names']}</td>
      <td>{$item['product_name']}</td>
      <td>{$item['trademark_name']}</td>
      <td>{$priceFormatted}</td>
      <td>{$total_stockFormatted}</td>
      <td>
            <button data-id='{$item['product_id']}' class='btn btn-primary edit-btn'>
              <i class='fa fa-pencil' aria-hidden='true'></i> Sửa
            </button>
            <button class='btn btn-danger delete-btn' data-id='{$item['product_id']}'>
              <i class='fa fa-trash' aria-hidden='true'></i> Xóa
            </button>
      </td>
    </tr>";
      }
      ?>
    </tbody>
  </table>




  <!-- Product Popup -->
  <div id="productPopup" class="popup-overlay" style="display: none;overflow-y: auto;">
    <div class="popup-content" style="left:35%;top:10%;">
      <button class="close-btn" onclick="closePopup()">X</button>
      <h2 id="popupTitle">Thêm sản phẩm mới</h2>
      <div id="productForm" class="p-3">
        <input type="hidden" id="productId">
        
        <div class="form-group mb-3">
          <label for="productName">Tên sản phẩm:</label>
          <input type="text" id="productName" class="form-control" required>
        </div>

        <div class="form-group mb-3">
          <label for="productDescription">Mô tả:</label>
          <div class="editor-container">
            <div id="toolbar-container" class="border-bottom mb-2"></div>
            <div id="productDescription" class="editor-content border rounded p-3" style="min-height: 200px;"></div>
          </div>
          <small class="form-text text-muted">Bạn có thể sử dụng các công cụ định dạng văn bản ở trên để tùy chỉnh mô tả sản phẩm</small>
        </div>

        <div class="form-group mb-3">
          <label for="productPrice">Giá:</label>
          <input type="number" id="productPrice" class="form-control" min="0" required>
            </div>

        <div class="form-group mb-3">
          <label for="productTrademark">Thương hiệu:</label>
          <select id="productTrademark" class="form-control" required>
            <?php foreach ($trademarkList as $trademark): ?>
              <option value="<?= $trademark['id'] ?>"><?= $trademark['name'] ?></option>
            <?php endforeach; ?>
          </select>
                  </div>

        <div class="form-group mb-3">
          <label for="productThumb">Ảnh đại diện:</label>
          <input type="file" id="productThumb" class="form-control" accept="image/*">
          <div id="thumbPreview" class="mt-2 position-relative d-inline-block">

                  </div>
                </div>

        <div class="form-group mb-3">
          <label for="productImages">Ảnh sản phẩm:</label>
          <input type="file" id="productImages" class="form-control" accept="image/*" multiple>
          <div id="imagesPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                  </div>

        <div class="form-group mb-3">
          <label>Màu sắc và Size:</label>
          <div id="colorContainer" class="border p-3 rounded">
            <div class="color-section mb-3">
              <div class="d-flex align-items-center mb-2">
                <input type="text" class="form-control color-name" placeholder="Tên màu" required>
                <button class="btn btn-danger ms-2 remove-color"><i class="fa fa-trash"></i></button>
                  </div>
              <div class="size-container">
                <div class="size-item d-flex align-items-center mb-2">
                  <input type="text" class="form-control size-input" placeholder="Size" required>
                  <input type="number" class="form-control ms-2 stock-input" placeholder="Số lượng" min="0" required>
                  <button class="btn btn-danger ms-2 remove-size"><i class="fa fa-trash"></i></button>
                </div>
                <button class="btn btn-success add-size"><i class="fa fa-plus"></i> Thêm Size</button>
              </div>
            </div>
            <button class="btn btn-primary add-color"><i class="fa fa-plus"></i> Thêm Màu</button>
          </div>
            </div>

        <div class="form-group mb-3">
          <label>Danh mục:</label>
          <div class="category-container d-flex flex-wrap gap-2">

          </div>
          <div class="mt-2">
            <select id="categorySelect" class="form-control">
              <option value="">Chọn danh mục...</option>
              <?php foreach ($categoriesData as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-success mt-2 add-category"><i class="fa fa-plus"></i> Thêm Danh mục</button>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-secondary" onclick="closePopup()">Hủy</button>
          <button type="button" class="btn btn-primary" onclick="saveProduct()">Lưu</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/decoupled-document/ckeditor.js"></script>

<script>
let categoriesData = []; 
const productColorsData = <?= json_encode($productColorsData, JSON_PRETTY_PRINT) ?>; 
let editor; 

  document.addEventListener("DOMContentLoaded", function() {
 
  DecoupledEditor
    .create(document.querySelector('#productDescription'), {
      toolbar: [
        'heading',
        '|',
        'fontSize',
        'fontFamily',
        '|',
        'bold',
        'italic',
        'underline',
        'strikethrough',
        '|',
        'link',
        'bulletedList',
        'numberedList',
        '|',
        'undo',
        'redo'
      ],
      fontSize: {
        options: [
          9, 11, 13, 'default', 17, 19, 21, 27, 35
        ]
      },
      fontFamily: {
        options: [
          'default',
          'Arial, Helvetica, sans-serif',
          'Courier New, Courier, monospace',
          'Georgia, serif',
          'Lucida Sans Unicode, Lucida Grande, sans-serif',
          'Tahoma, Geneva, sans-serif',
          'Times New Roman, Times, serif',
          'Trebuchet MS, Helvetica, sans-serif',
          'Verdana, Geneva, sans-serif'
        ]
      },
      language: 'vi'
    })
    .then(newEditor => {
      editor = newEditor;
      const toolbarContainer = document.querySelector('#toolbar-container');
      toolbarContainer.appendChild(editor.ui.view.toolbar.element);
    })
    .catch(error => {
      console.error(error);
    });

  const productData = <?= json_encode($productItem, JSON_HEX_TAG) ?>;
  categoriesData = <?= json_encode($categoriesModule->getIdNameCategory(), JSON_HEX_TAG) ?>;
  const productCategoriesData = <?= json_encode($productCategoriesItem, JSON_HEX_TAG) ?>;

  document.addEventListener('click', function(e) {

    if (e.target.closest('.add-color')) {
      const colorContainer = document.getElementById('colorContainer');
      const colorSection = document.createElement('div');
      colorSection.className = 'color-section mb-3';
      colorSection.innerHTML = `
        <div class="d-flex align-items-center mb-2">
          <input type="text" class="form-control color-name" placeholder="Tên màu" required>
          <button class="btn btn-danger ms-2 remove-color"><i class="fa fa-trash"></i></button>
        </div>
        <div class="size-container">
          <div class="size-item d-flex align-items-center mb-2">
            <input type="text" class="form-control size-input" placeholder="Size" required>
            <input type="number" class="form-control ms-2 stock-input" placeholder="Số lượng" min="0" required>
            <button class="btn btn-danger ms-2 remove-size"><i class="fa fa-trash"></i></button>
          </div>
          <button class="btn btn-success add-size"><i class="fa fa-plus"></i> Thêm Size</button>
        </div>
      `;
      colorContainer.insertBefore(colorSection, e.target.closest('.add-color'));
    }

 
    if (e.target.closest('.add-size')) {
      const sizeContainer = e.target.closest('.size-container');
      const sizeItem = document.createElement('div');
      sizeItem.className = 'size-item d-flex align-items-center mb-2';
      sizeItem.innerHTML = `
        <input type="text" class="form-control size-input" placeholder="Size" required>
        <input type="number" class="form-control ms-2 stock-input" placeholder="Số lượng" min="0" required>
        <button class="btn btn-danger ms-2 remove-size"><i class="fa fa-trash"></i></button>
      `;
      sizeContainer.insertBefore(sizeItem, e.target.closest('.add-size'));
    }


    if (e.target.closest('.remove-size')) {
      const sizeItem = e.target.closest('.size-item');
      sizeItem.remove();
    }


    if (e.target.closest('.remove-color')) {
      const colorSection = e.target.closest('.color-section');
      colorSection.remove();
    }


    if (e.target.closest('.remove-thumb')) {
      document.getElementById('thumbPreview').innerHTML = '';
      document.getElementById('productThumb').value = '';
    }

    if (e.target.closest('.remove-image')) {
      e.target.closest('.position-relative').remove();
    }


    if (e.target.closest('.edit-btn')) {
      const productId = e.target.closest('.edit-btn').dataset.id;
      const product = productData.find(item => item.product_id == productId);
        if (product) {
        openEditProductPopup(product);
      }
    }


    if (e.target.closest('.delete-btn')) {
      const productId = e.target.closest('.delete-btn').dataset.id;
      if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        deleteProduct(productId);
      }
    }


    if (e.target.closest('.remove-category')) {
      const categoryDiv = e.target.closest('.category');
      const categoryId = categoryDiv.dataset.id;
      const categoryName = categoryDiv.querySelector('.badge').textContent.trim();
      
      const select = document.getElementById('categorySelect');
      const option = document.createElement('option');
      option.value = categoryId;
      option.textContent = categoryName;
      select.appendChild(option);
      
      categoryDiv.remove();
    }
  });


  document.querySelector('.add-category').addEventListener('click', function() {
    const select = document.getElementById('categorySelect');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
      const categoryContainer = document.querySelector('.category-container');
      const categoryDiv = document.createElement('div');
      categoryDiv.className = 'category';
      categoryDiv.dataset.id = selectedOption.value;
      categoryDiv.innerHTML = `
        <span class="badge me-2">${selectedOption.text}</span>
        <button class="btnCategory remove remove-category">×</button>
      `;
              categoryContainer.appendChild(categoryDiv);
      select.remove(select.selectedIndex);
    }
  });


  const handleImagePreview = (file, previewElement) => {
    const reader = new FileReader();
    reader.onload = function(e) {
      previewElement.innerHTML += `
        <div class="position-relative">
          <img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px">
          <button class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image">×</button>
        </div>
      `;
    };
    reader.readAsDataURL(file);
  };


  document.getElementById('productThumb').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('thumbPreview').innerHTML = `
          <div class="position-relative">
            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px">
            <button class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-thumb">×</button>
          </div>
        `;
      };
      reader.readAsDataURL(file);
    }
  });


  document.getElementById('productImages').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.getElementById('imagesPreview');
    
    for (let file of files) {
      handleImagePreview(file, preview);
    }
  });
});

function openAddProductPopup() {
  document.getElementById('popupTitle').textContent = 'Thêm sản phẩm mới';
  

  document.getElementById('productId').value = '';
  document.getElementById('productName').value = '';
  if (editor) {
    editor.setData(''); 
  }
  document.getElementById('productPrice').value = '';
  document.getElementById('productTrademark').selectedIndex = 0;
  document.getElementById('productThumb').value = '';
  document.getElementById('productImages').value = '';
  

  document.getElementById('thumbPreview').innerHTML = '';
  document.getElementById('imagesPreview').innerHTML = '';
  document.querySelector('.category-container').innerHTML = ''; 
  

  const select = document.getElementById('categorySelect');
  select.innerHTML = '<option value="">Chọn danh mục...</option>';
  categoriesData.forEach(category => {
    const option = document.createElement('option');
    option.value = category.id;
    option.textContent = category.name;
    select.appendChild(option);
  });
  
  const colorContainer = document.getElementById('colorContainer');
  colorContainer.innerHTML = `
    <div class="color-section mb-3">
      <div class="d-flex align-items-center mb-2">
        <input type="text" class="form-control color-name" placeholder="Tên màu" required>
        <button class="btn btn-danger ms-2 remove-color"><i class="fa fa-trash"></i></button>
      </div>
      <div class="size-container">
        <div class="size-item d-flex align-items-center mb-2">
          <input type="text" class="form-control size-input" placeholder="Size" required>
          <input type="number" class="form-control ms-2 stock-input" placeholder="Số lượng" min="0" required>
          <button class="btn btn-danger ms-2 remove-size"><i class="fa fa-trash"></i></button>
        </div>
        <button class="btn btn-success add-size"><i class="fa fa-plus"></i> Thêm Size</button>
      </div>
    </div>
    <button class="btn btn-primary add-color"><i class="fa fa-plus"></i> Thêm Màu</button>
  `;


  document.getElementById('productPopup').style.display = 'block';
}

function openEditProductPopup(product) {
  document.getElementById('popupTitle').textContent = 'Chỉnh sửa sản phẩm';
  

  document.getElementById('productId').value = product.product_id;
  document.getElementById('productName').value = product.product_name;
  if (editor) {
    editor.setData(product.description); 
  }
  document.getElementById('productPrice').value = product.price;
  document.getElementById('productTrademark').value = product.trademark_id;
  

  document.getElementById('thumbPreview').innerHTML = '';
  document.getElementById('imagesPreview').innerHTML = '';
  

  if (product.image_url) {
    document.getElementById('thumbPreview').innerHTML = `
      <div class="position-relative">
        <img src="/MIKEPHP/img/${product.image_url}" class="img-thumbnail" style="max-height: 100px">
        <button class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-thumb">×</button>
      </div>
    `;
  }
  
 
  if (product.image_json) {
    const images = JSON.parse(product.image_json);
    images.forEach(image => {
      document.getElementById('imagesPreview').innerHTML += `
        <div class="position-relative">
          <img src="/MIKEPHP/img/${image}" class="img-thumbnail" style="max-height: 100px">
          <button class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image">×</button>
        </div>
      `;
    });
  }
  
 
  document.querySelector('.category-container').innerHTML = '';
  const productCategories = product.category_names.split(', ');
  productCategories.forEach(categoryName => {
    const category = categoriesData.find(c => c.name === categoryName);
    if (category) {
      const categoryDiv = document.createElement('div');
      categoryDiv.className = 'category';
      categoryDiv.dataset.id = category.id;
      categoryDiv.innerHTML = `
        <span class="badge  me-2">${category.name}</span>
        <button class=" btnCategory remove remove-category">×</button>
      `;
      document.querySelector('.category-container').appendChild(categoryDiv);
    }
  });
  
 
  const select = document.getElementById('categorySelect');
  select.innerHTML = '<option value="">Chọn danh mục...</option>';
  categoriesData.forEach(category => {
    if (!productCategories.includes(category.name)) {
      const option = document.createElement('option');
      option.value = category.id;
      option.textContent = category.name;
      select.appendChild(option);
    }
  });
  
 
  const colorContainer = document.getElementById('colorContainer');
  colorContainer.innerHTML = '';

  const productColors = productColorsData[product.product_id] || [];

  
  if (productColors.success && Array.isArray(productColors.colors) && productColors.colors.length > 0) {
    productColors.colors.forEach(colorData => {

      const colorSection = document.createElement('div');
      colorSection.className = 'color-section mb-3';
      
  
      let sizesHtml = '';
      if (colorData.sizes && Array.isArray(colorData.sizes)) {
        sizesHtml = colorData.sizes.map(size => {

          return `
            <div class="size-item d-flex align-items-center mb-2">
              <input type="text" class="form-control size-input" placeholder="Size" value="${size.size || ''}" required>
              <input type="number" class="form-control ms-2 stock-input" placeholder="Số lượng" value="${size.stock || 0}" min="0" required>
              <button class="btn btn-danger ms-2 remove-size"><i class="fa fa-trash"></i></button>
            </div>
          `;
        }).join('');
      }
      
      colorSection.innerHTML = `
        <div class="d-flex align-items-center mb-2">
          <input type="text" class="form-control color-name" placeholder="Tên màu" value="${colorData.color_name || ''}" required>
          <button class="btn btn-danger ms-2 remove-color"><i class="fa fa-trash"></i></button>
        </div>
        <div class="size-container">
          ${sizesHtml}
          <button class="btn btn-success add-size"><i class="fa fa-plus"></i> Thêm Size</button>
        </div>
      `;
      colorContainer.appendChild(colorSection);
    });
  } else {
  
    const colorSection = document.createElement('div');
    colorSection.className = 'color-section mb-3';
    colorSection.innerHTML = `
      <div class="d-flex align-items-center mb-2">
        <input type="text" class="form-control color-name" placeholder="Tên màu" required>
        <button class="btn btn-danger ms-2 remove-color"><i class="fa fa-trash"></i></button>
      </div>
      <div class="size-container">
        <div class="size-item d-flex align-items-center mb-2">
          <input type="text" class="form-control size-input" placeholder="Size" required>
          <input type="number" class="form-control ms-2 stock-input" placeholder="Số lượng" min="0" required>
          <button class="btn btn-danger ms-2 remove-size"><i class="fa fa-trash"></i></button>
        </div>
        <button class="btn btn-success add-size"><i class="fa fa-plus"></i> Thêm Size</button>
      </div>
    `;
    colorContainer.appendChild(colorSection);
  }
  

  const addColorButton = document.createElement('button');
  addColorButton.className = 'btn btn-primary add-color';
  addColorButton.innerHTML = '<i class="fa fa-plus"></i> Thêm Màu';
  colorContainer.appendChild(addColorButton);

  document.getElementById('productPopup').style.display = 'block';
}

function closePopup() {
  document.getElementById('productPopup').style.display = 'none';
}

function saveProduct() {

  const productId = document.getElementById('productId').value;
  const productName = document.getElementById('productName').value.trim();
  const description = editor ? editor.getData().trim() : '';
  const price = document.getElementById('productPrice').value;
  const trademarkId = document.getElementById('productTrademark').value;
  
  
  const slug = productName
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, '');
  

  if (!productName) {
    alert('Vui lòng nhập tên sản phẩm');
    return;
  }
  if (!description) {
    alert('Vui lòng nhập mô tả sản phẩm');
    return;
  }
  if (!price || price <= 0) {
    alert('Vui lòng nhập giá sản phẩm hợp lệ');
    return;
  }
  if (!trademarkId) {
    alert('Vui lòng chọn thương hiệu');
    return;
  }
  
  const categories = Array.from(document.querySelectorAll('.category')).map(cat => cat.dataset.id);
  if (categories.length === 0) {
    alert('Vui lòng chọn ít nhất một danh mục');
    return;
  }
  

  const colors = [];
  document.querySelectorAll('.color-section').forEach(colorSection => {
    const colorName = colorSection.querySelector('.color-name').value.trim();
    if (!colorName) {
      alert('Vui lòng nhập tên màu');
      return;
    }
    
    const sizes = [];
    colorSection.querySelectorAll('.size-item').forEach(sizeItem => {
      const sizeName = sizeItem.querySelector('.size-input').value.trim();
      const stock = sizeItem.querySelector('.stock-input').value;
      
      if (!sizeName) {
        alert('Vui lòng nhập tên size');
        return;
      }
      if (!stock || stock < 0) {
        alert('Vui lòng nhập số lượng tồn kho hợp lệ');
        return;
      }
      
      sizes.push({
        size: sizeName,
        stock: parseInt(stock)
      });
    });

    if (sizes.length === 0) {
      alert('Vui lòng thêm ít nhất một size cho mỗi màu');
      return;
    }
    
    colors.push({
      color_name: colorName,
      sizes: sizes
    });
  });
  
  if (colors.length === 0) {
    alert('Vui lòng thêm ít nhất một màu sắc');
    return;
  }
  

  const formData = new FormData();
  if (productId) {
    formData.append('product_id', productId);
  }
  formData.append('name', productName);
  formData.append('slug', slug);
  formData.append('description', description);
  formData.append('price', price);
  formData.append('trademark_id', trademarkId);
  formData.append('categories', JSON.stringify(categories));
  formData.append('colors', JSON.stringify(colors));
  
  const thumbFile = document.getElementById('productThumb').files[0];
  if (thumbFile) {
    formData.append('image_url', thumbFile);
  }
  
 
  const imageFiles = document.getElementById('productImages').files;
  for (let i = 0; i < imageFiles.length; i++) {
    formData.append('productImages[]', imageFiles[i]);
  }
  

  
  
  fetch('/MIKEPHP/admin/product/save', {
    method: 'POST',
    body: formData
  })
  .then(async response => {
  
    if (!response.ok) {
     
      const text = await response.text();
      console.error('Server Error Response:', text);
      
   
      try {
        const jsonData = JSON.parse(text);
        throw new Error(jsonData.message || 'Server error occurred');
      } catch (e) {
     
        throw new Error('Server error occurred. Please check the console for details.');
      }
    }
    
  
    const contentType = response.headers.get('content-type');
    if (contentType && contentType.includes('application/json')) {
      return response.json();
    } else {
      throw new Error('Server returned non-JSON response');
    }
  })
  .then(data => {
    if (data.success) {
      alert('Lưu sản phẩm thành công!');
      location.reload();
    } else {
      alert('Lỗi: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi lưu sản phẩm: ' + error.message);
  });
}

function deleteProduct(productId) {
  if (!productId) {
    alert('Không tìm thấy ID sản phẩm');
    return;
  }

 
  const formData = new FormData();
  formData.append('id', productId);

 
  fetch('/MIKEPHP/admin/product/delete', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {
      alert('Xóa sản phẩm thành công!');
      location.reload();
    } else {
      alert('Lỗi: ' + (data.message || 'Không thể xóa sản phẩm'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi xóa sản phẩm!');
  });
  }
</script>
</rewritten_file>