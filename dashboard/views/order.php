<?php
require_once __DIR__ . "/../../module/orderModule.php";
$orderModule = new OrderModule();
$orderList = $orderModule->getOrderListItem();

$order_id = $_GET['order_id'] ?? 0;
$orderDetails = $orderModule->getOrderDetails($order_id);


?>

<div style="overflow-y: auto; max-height: 830px; padding: 20px;">
  <div class="d-flex head-order" style="justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="margin: 0; font-weight: bold; margin-left: 240px;">📦 Danh sách đơn hàng</h3>
    <input type="text" id="searchInput" placeholder="🔍 Tìm kiếm..." onkeyup="searchOrders()"
      style="width: 200px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
    <select class="filter" id="filterOption" onchange="applyFilter()"
      style="width: 180px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
      <option value="">🔎 Lọc theo</option>
      <option value="id">🔢 Id</option>
      <option value="name-asc">🔤 Tên (A->Z)</option>
      <option value="name-desc">🔡 Tên (Z->A)</option>
      <option value="SDT">📞 SĐT</option>
      <option value="product">📦 Tổng sản phẩm</option>
      <option value="date">📅 Ngày đặt</option>
      <option value="status">⚡ Trạng thái</option>
    </select>
  </div>
  <div style="overflow-y: auto; height: 300px;">
    <table class="table" style="width: 100%; border-collapse: collapse; text-align: center; font-family: Arial, sans-serif;">
      <thead style="background-color: #f8f9fa; font-weight: bold;">
        <tr>
          <th>🆔 Id</th>
          <th>👤 Tên khách hàng</th>
          <th>📞 Số điện thoại</th>
          <th>📦 Tổng sản phẩm</th>
          <th>🏠 Địa chỉ</th>
          <th>📅 Ngày đặt</th>
          <th>💳 Thanh toán</th>
          <th>⚡ Trạng thái</th>
          <th>⚙️ Hành động</th>
        </tr>
      </thead>
      <tbody class="table-body">
        <?php

        foreach ($orderList as $order) {

        ?>
          <tr style="border-bottom: 1px solid #ddd;">
            <td><?php echo $order['id'] ?></td>
            <td><?php echo $order['name'] ?></td>
            <td><?php echo $order['phone'] ?></td>
            <td><?php echo $order['sumProduct'] ?></td>
            <td><?php echo $order['address'] ?></td>
            <td><?php echo $order['created_at'] ?></td>
            <td><?php echo $order['payment_method'] ?></td>
            <td><span style="color: orange;"><?php echo $order['status'] ?></span></td>
            <td>
              <button class="btn btn-primary"
                onclick="window.location.href='?order_id=<?php echo $order['id']; ?>'"
                style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
                <i class="fa fa-eye" aria-hidden="true"></i> Xem
              </button>
              <button class="btn btn-danger"
                style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
                <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
              </button>
            </td>
          </tr>
        <?php } ?>



      </tbody>
    </table>
  </div>
  <div id="pagination" style="display: flex; justify-content: center; margin-top: 10px;"></div>

  <div id="orderPopup" class="popup-overlay" style="z-index: 99999;" >
    <div class="popup-content">
    <button class="close-btn" onclick="window.location.href='order'">X</button>
      <h2>Chi tiết đơn hàng</h2>

      <?php

      if (!empty($orderDetails)) {
        echo "<h5><small>Mã đơn hàng: #{$orderDetails[0]['order_id']}</small></h5>";
        echo "<p>Sản phẩm: </p>";
        foreach ($orderDetails as $item) {
          $imagePath = "/MIKEPHP/img/" . $item["image_url"];
          if (empty($item["image_url"]) || !file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
            $imagePath = "/MIKEPHP/img/default.png";
          }

          echo "
                <div class='card mb-3' style='max-width: 540px; text-align: left; margin: auto;'>
                    <div class='row g-0'>
                        <div class='col-md-3 mt-2 mb-2 ms-1' style='max-width:150px;'>
                            <img style='min-height:135px;max-height:150px;' src='{$imagePath}' class='img-fluid rounded-start'>
                        </div>
                        <div class='col-md-8' style='max-width:150px;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$item['product_name']}</h5>
                                <p><strong>Size:</strong> {$item['size']}</p>
                                <p><strong>Số lượng:</strong> {$item['quantity']}</p>
                                <p><strong>Giá bán:</strong> {$item['price']}</p>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        echo "<h5><small>Tổng giá: $ {$orderDetails[0]['sumprice']}</small></h5>";
      }
      ?>
    </div>
  </div>

  <script>
    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('order_id')) {
            document.getElementById("orderPopup").style.display = "flex";
        }
    };
  </script>