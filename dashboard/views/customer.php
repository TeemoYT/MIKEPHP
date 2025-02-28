

<h2>Danh sách khách hàng</h2>
<div style="overflow-y: auto; height: 300px;">
<table class="table-custom" style="width: 100%; border-collapse: collapse; text-align: center; font-family: Arial, sans-serif;">
    <thead style="background-color: #f8f9fa; font-weight: bold;">
        <tr>
            <th>#</th>
            <th>👤 Họ và tên</th>
            <th>📞 Số điện thoại</th>
            <th>Email</th>
            <th>Tổng đơn</th>
            <th>Tổng chi tiêu</th>
            <th>Hạng</th>
            <th>Xem</th>
        </tr>
    </thead>
    <tbody class="table-customer" >
        <tr style="border-bottom: 1px solid #ddd;">
            <td>1</td>
            <td>Nguyễn Văn A</td>
            <td>0939618903</td>
            <td>nvtinh14072002@gmail.com</td>
            <td>3</td>
            <td>750.000VND</td>
            <td>Mới</td>
            <td class="sub-customer">
                <button class="btn btn-primary btn-customer" 
                    onclick="showCustomerDetail('Nguyễn Văn A', '0939618903', 'nvtinh14072002@gmail.com', 3, '750.000VND', 'Mới')">
                    <i class="fa fa-eye"></i> Xem
                </button>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid #ddd;">
            <td>1</td>
            <td>Nguyễn Văn A</td>
            <td>0939618903</td>
            <td>nvtinh14072002@gmail.com</td>
            <td>3</td>
            <td>750.000VND</td>
            <td>Mới</td>
            <td class="sub-customer">
                <button class="btn btn-primary btn-customer" 
                    onclick="showCustomerDetail('Nguyễn Văn A', '0939618903', 'nvtinh14072002@gmail.com', 3, '750.000VND', 'Mới')">
                    <i class="fa fa-eye"></i> Xem
                </button>
            </td>
        </tr>
        
    </tbody>
</table></div>
    <!-- Chi tiết khách hàng (ẩn ban đầu) -->
    <div id="customerDetail" class="customerDetail">
        <table>
        <h2>Thông tin khách hàng</h2>
        <p><strong>Họ và tên:</strong> <span id="detailName"></span></p>
        <p><strong>Số điện thoại:</strong> <span id="detailPhone"></span></p>
        <p><strong>Email:</strong> <span id="detailEmail"></span></p>
        <p><strong>Tổng đơn:</strong> <span id="detailOrders"></span></p>
        <p><strong>Tổng chi tiêu:</strong> <span id="detailSpent"></span></p>
        <p><strong>Hạng:</strong> <span id="detailMember"></span></p>
        <button class="btn btn-back" onclick="backToList()">Quay lại</button>
    </table>
</div>
<script>
function showCustomerDetail(name, phone, email, orders, spent, member) {
    // Load CSS riêng cho trang chi tiết khách hàng
    let detailCSS = document.getElementById("detailCSS");
    if (!detailCSS) {
        detailCSS = document.createElement("link");
        detailCSS.id = "detailCSS";
        detailCSS.rel = "stylesheet";
        detailCSS.href = "customer_detail.css";
        document.head.appendChild(detailCSS);
    }

    // Cập nhật thông tin khách hàng
    document.getElementById("detailName").innerText = name;
    document.getElementById("detailPhone").innerText = phone;
    document.getElementById("detailEmail").innerText = email;
    document.getElementById("detailOrders").innerText = orders;
    document.getElementById("detailSpent").innerText = spent;
    document.getElementById("detailMember").innerText = member;

    // Ẩn danh sách, hiển thị chi tiết
    document.getElementById("customerDetail").classList.add("hidden");
    document.getElementById("customerList").classList.remove("hidden");
}

function backToList() {
    // Hiển thị danh sách, ẩn chi tiết
    document.getElementById("customerDetail").classList.remove("hidden");
    document.getElementById("customerList").classList.add("hidden");

    // Xóa CSS chi tiết khách hàng khi quay lại danh sách
    let detailCSS = document.getElementById("detailCSS");
    if (detailCSS) {
        document.head.removeChild(detailCSS);
    }
}
</script>



