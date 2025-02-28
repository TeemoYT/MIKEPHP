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
        <tr style="border-bottom: 1px solid #ddd;">
          <td>1</td>
          <td>Nguyễn Văn A</td>
          <td>0939618903</td>
          <td>3 sản phẩm</td>
          <td>10 Nguyễn Thái Sơn, Gò Vấp, TP.HCM</td>
          <td>14/08/2025</td>
          <td>MOMO</td>
          <td><span style="color: orange;">Đang xử lý</span></td>
          <td>
            <button class="btn btn-primary" onclick="showOrderDetail('ORD001', 'AF1', '43', 'TRẮNG', '2', '350.000VND','700.000VND')"
              style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-eye" aria-hidden="true"></i> Xem
            </button>
            <button class="btn btn-danger"
              style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
            </button>
          </td>
        </tr>
        <tr style="border-bottom: 1px solid #ddd;">
          <td>1</td>
          <td>Nguyễn Văn A</td>
          <td>0939618903</td>
          <td>3 sản phẩm</td>
          <td>10 Nguyễn Thái Sơn, Gò Vấp, TP.HCM</td>
          <td>14/08/2025</td>
          <td>MOMO</td>
          <td><span style="color: orange;">Đang xử lý</span></td>
          <td>
            <button class="btn btn-primary" onclick="showOrderDetail('ORD001', 'AF1', '43', 'TRẮNG', '2', '350.000VND','700.000VND')"
              style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-eye" aria-hidden="true"></i> Xem
            </button>
            <button class="btn btn-danger"
              style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
            </button>
          </td>
        </tr>
        <tr style="border-bottom: 1px solid #ddd;">
          <td>1</td>
          <td>Nguyễn Văn A</td>
          <td>0939618903</td>
          <td>3 sản phẩm</td>
          <td>10 Nguyễn Thái Sơn, Gò Vấp, TP.HCM</td>
          <td>14/08/2025</td>
          <td>MOMO</td>
          <td><span style="color: orange;">Đang xử lý</span></td>
          <td>
            <button class="btn btn-primary" onclick="showOrderDetail('ORD001', 'AF1', '43', 'TRẮNG', '2', '350.000VND','700.000VND')"
              style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-eye" aria-hidden="true"></i> Xem
            </button>
            <button class="btn btn-danger"
              style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
            </button>
          </td>
        </tr>
        <tr style="border-bottom: 1px solid #ddd;">
          <td>1</td>
          <td>Nguyễn Văn A</td>
          <td>0939618903</td>
          <td>3 sản phẩm</td>
          <td>10 Nguyễn Thái Sơn, Gò Vấp, TP.HCM</td>
          <td>14/08/2025</td>
          <td>MOMO</td>
          <td><span style="color: orange;">Đang xử lý</span></td>
          <td>
            <button class="btn btn-primary" onclick="showOrderDetail('ORD001', 'AF1', '43', 'TRẮNG', '2', '350.000VND','700.000VND')"
              style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-eye" aria-hidden="true"></i> Xem
            </button>
            <button class="btn btn-danger"
              style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
            </button>
          </td>
        </tr>
        <tr style="border-bottom: 1px solid #ddd;">
          <td>1</td>
          <td>Nguyễn Văn A</td>
          <td>0939618903</td>
          <td>3 sản phẩm</td>
          <td>10 Nguyễn Thái Sơn, Gò Vấp, TP.HCM</td>
          <td>14/08/2025</td>
          <td>MOMO</td>
          <td><span style="color: orange;">Đang xử lý</span></td>
          <td>
            <button class="btn btn-primary" onclick="showOrderDetail('ORD001', 'AF1', '43', 'TRẮNG', '2', '350.000VND','700.000VND')"
              style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-eye" aria-hidden="true"></i> Xem
            </button>
            <button class="btn btn-danger"
              style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
            </button>
          </td>
        </tr>    

        <tr style="border-bottom: 1px solid #ddd;">
          <td>2</td>
          <td>Nguyễn Văn B</td>
          <td>0866443269</td>
          <td>3 sản phẩm</td>
          <td>10 Nguyễn Thái Sơn, Gò Vấp, TP.HCM</td>
          <td>14/08/2025</td>
          <td>MOMO</td>
          <td><span style="color: orange;">Đang xử lý</span></td>
          <td>
            <button class="btn btn-primary btn-order" onclick="showOrderDetail('ORD001', 'AF1', '43', 'TRẮNG', '2', '350.000VND','700.000VND')"
              style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-eye" aria-hidden="true"></i> Xem
            </button>
            <button class="btn btn-danger"
              style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
              <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
            </button>
          </td>
        </tr>

      </tbody>
    </table>
  </div>
  <div id="pagination" style="display: flex; justify-content: center; margin-top: 10px;"></div>

  <div id="detailOrder" class="detailOrder">
    <table>
      <h2>Chi tiết đơn hàng</h2>
      <p><strong>Mã sản phẩm:</strong> <span id="detailMSP"></span></p>
      <p><strong>Tên sản phẩm:</strong> <span id="detaiLTSP"></span></p>
      <p><strong>Size:</strong> <span id="detailSIZE"></span></p>
      <p><strong>Màu:</strong> <span id="detailCOLOR"></span></p>
      <p><strong>Số lượng:</strong> <span id="detailSL"></span></p>
      <p><strong>Giá bán:</strong> <span id="detailGB"></span></p>
      <p><strong>Tổng tiền:</strong> <span id="detailTT"></span></p>
    </table>
  </div>

  <script>
    function showOrderDetail(msp, tsp, size, color, sl, gb, tt) {
      // Load CSS riêng cho trang chi tiết khách hàng
      let detailCSS = document.getElementById("detailCSS");
      if (!detailCSS) {
        detailCSS = document.createElement("link");
        detailCSS.id = "detailCSS";
        detailCSS.rel = "stylesheet";
        detailCSS.href = "order_detail.css";
        document.head.appendChild(detailCSS);
      }

      // Cập nhật thông tin khách hàng
      document.getElementById("detailMSP").innerText = msp;
      document.getElementById("detaiLTSP").innerText = tsp;
      document.getElementById("detailSIZE").innerText = size;
      document.getElementById("detailCOLOR").innerText = color;
      document.getElementById("detailSL").innerText = sl;
      document.getElementById("detailGB").innerText = gb;
      document.getElementById("detailTT").innerText = tt;

      // Ẩn danh sách, hiển thị chi tiết
      document.getElementById("detailOrder").classList.add("hidden");
      document.getElementById("customerList").classList.remove("hidden");
    }

    function backToList() {
      // Hiển thị danh sách, ẩn chi tiết
      document.getElementById("detailOrder").classList.remove("hidden");
      document.getElementById("customerList").classList.add("hidden");
    }
  </script>