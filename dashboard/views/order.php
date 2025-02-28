<div style="overflow-y: auto; height: 750px; padding: 20px;">
  <div class="d-flex head-order" style="justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="margin: 0; font-weight: bold;">📦 Danh sách đơn hàng</h3>
    <input type="text" id="searchInput" placeholder="🔍 Tìm kiếm..." onkeyup="searchOrders()"
           style="width: 200px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
    <select class="filter" id="filterOption" onchange="applyFilter()"
            style="width: 180px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
      <option value="">🔎 Lọc theo</option>
      <option value="id">🔢 Id</option>
      <option value="name-asc">🔤 Tên (A->Z)</option>
      <option value="name-desc">🔡 Tên (Z->A)</option>
      <option value="SDT">📞  SĐT</option>
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
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
          <button class="btn btn-primary" onclick="toggleDetail('detail-1')" 
                  style="padding: 5px 12px; border-radius: 8px; background-color: #007bff; color: white; border: none; transition: background-color 0.3s;">
            <i class="fa fa-eye" aria-hidden="true"></i> Xem
          </button>
          <button class="btn btn-danger" 
                  style="padding: 5px 12px; border-radius: 8px; background-color: #dc3545; color: white; border: none; transition: background-color 0.3s;">
            <i class="fa fa-times-circle" aria-hidden="true"></i> Hủy
          </button>
        </td>
      </tr>
      
      <!-- Bảng con (chi tiết đơn hàng) với hiệu ứng -->
      <tr id="detail-1" class="detail-row">
        <td colspan="8">
          <div class="detail-content">
            <h5 style="margin-bottom: 15px;">📝 Chi tiết đơn hàng</h5>
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
              <thead style="background-color: #e9ecef;">
                <tr>
                  <th>Mã sản phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Size</th>
                  <th>Màu</th>
                  <th>Số lượng</th>
                  <th>Giá bán</th>
                  <th>Tổng tiền</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>G001</td>
                  <td>Air Force 1</td>
                  <td>40</td>
                  <td>Trắng</td>
                  <td>2</td>
                  <td>2.500.000 VND</td>
                  <td>5.000.000 VND</td>
                </tr>
              </tbody>
            </table>
          </div>
          <strong style="float: right; margin-top: 10px; color: #28a745;">💰 Tổng tiền: 5.000.000 VND</strong>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  <div id="pagination" style="display: flex; justify-content: center; margin-top: 20px;"></div>

  <style>
    /* Ẩn bảng chi tiết với animation */
    .detail-row {
      display: none;
      transition: all 0.5s ease;
      background-color: #f9f9f9;
    }

    .detail-content {
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #fff;
      animation: fadeIn 0.5s ease;
    }

    /* Animation khi hiển thị */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Hover cho nút */
    .btn:hover {
      opacity: 0.8;
      cursor: pointer;
    }
  </style>

  <script>
    const rowsPerPage = 5;
    let currentPage = 1;

    function applyFilter() {
      searchOrders();
    }

    function searchOrders() {
      const searchValue = document.getElementById('searchInput').value.toLowerCase();
      const filterValue = document.getElementById('filterOption').value;
      const tableBody = document.getElementById('orderTableBody');
      const rows = Array.from(tableBody.getElementsByTagName('tr'));

      let filteredRows = rows.filter(row => {
        return row.innerText.toLowerCase().includes(searchValue);
      });

      if (filterValue) {
        filteredRows.sort((a, b) => {
          const aText = a.cells[1].innerText.toLowerCase();
          const bText = b.cells[1].innerText.toLowerCase();
          return filterValue === 'name-desc' ? bText.localeCompare(aText) : aText.localeCompare(bText);
        });
      }

      renderPagination(filteredRows);
    }

    function renderPagination(rows) {
      const tableBody = document.getElementById('orderTableBody');
      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';
      tableBody.innerHTML = '';

      const totalPages = Math.ceil(rows.length / rowsPerPage);
      const startIndex = (currentPage - 1) * rowsPerPage;
      const paginatedRows = rows.slice(startIndex, startIndex + rowsPerPage);

      paginatedRows.forEach(row => tableBody.appendChild(row));

      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = 'btn ' + (i === currentPage ? 'btn-primary' : 'btn-secondary');
        btn.onclick = function() {
          currentPage = i;
          renderPagination(rows);
        };
        pagination.appendChild(btn);
      }
    }

    function toggleDetail(id) {
      const detailRow = document.getElementById(id);
      detailRow.style.display = (detailRow.style.display === "none" || detailRow.style.display === "") ? "table-row" : "none";
    }

    document.addEventListener('DOMContentLoaded', searchOrders);   
    // Hiệu ứng mượt khi mở/đóng bảng chi tiết
    function toggleDetail(id) {
      const detailRow = document.getElementById(id);
      detailRow.style.display = (detailRow.style.display === "none" || detailRow.style.display === "") ? "table-row" : "none";
    }
  </script>
</div>
