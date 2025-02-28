<h2>Danh sách thanh toán</h2>
<div style="overflow-y: auto; height: 300px;">
<table class="table-payment" style="width: 100%; border-collapse: collapse; text-align: center; font-family: Arial, sans-serif;">
    <thead style="background-color: #f8f9fa; font-weight: bold;">
        <tr>
            <th>🏷️ Mã giao dịch</th>
            <th>📄 Mã đơn hàng</th>
            <th>👤 Tên khách hàng</th>
            <th>💰 Số tiền</th>
            <th> ℹ️  Trạng thái</th>
            <th>📅 Ngày thanh toán</th>
            <th>🔄 Hoàn tiền</th>
        </tr>
    </thead>
    <tbody class="table-customer">
        <tr style="border-bottom: 1px solid #ddd;"> 
            <td>PAY001</td>
            <td>ORD123</td>
            <td>Nguyễn Văn A</td>
            <td>2.500.000VND</td>
            <td>Momo</td>
            <td>Đã thanh toán</td>
            <td>12/02/20225</td>
            <td class="sub-payment">
                <button class="btn btn-primary btn-payment" 
                    onclick="showCustomerDetail('PAY001', 'ORD123', 'Nguyễn Văn A', '2.500.000VND', 'Momo', 'Đã thanh toán' ,'12/02/20225', 'Thanh toán thành công qua visa')">
                    <i class="fa fa-eye"></i> Xem
                </button>
            </td>
        </tr>
    </tbody>
</table>
</div>
<div id="paymentDetail" class="paymentDetail">
<table>
    <h2>Thông tin khách hàng</h2>
    <p><strong>Mã giao dịch:</strong> <span id="detailTransaction"></span></p>
    <p><strong>Mã đơn hàng:</strong> <span id="detailOrder"></span></p>
    <p><strong>Tên khách hàng:</strong> <span id="detailCustomer"></span></p>
    <p><strong>Số tiền:</strong> <span id="detailAmount"></span></p>
    <p><strong>Trạng thái:</strong> <span id="detailStatus"></span></p>
    <p><strong>Ngày thanh toán:</strong> <span id="detailPaymentDate"></span></p>
    <p><strong>Ghi chú:</strong> <span id="detailNote"></span></p>
    <button class="btn btn-in" onclick="printPaymentDetail()">🖨 In</button>
</table>
</div>

<script>
function showCustomerDetail(transaction, order, customer, amount, status, paymentDate, note) {
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
    document.getElementById("detailTransaction").innerText = transaction;
    document.getElementById("detailOrder").innerText = order;
    document.getElementById("detailCustomer").innerText = customer;
    document.getElementById("detailAmount").innerText = amount;
    document.getElementById("detailStatus").innerText = status;
    document.getElementById("detailPaymentDate").innerText = paymentDate;
    document.getElementById("detailNote").innerText = note;

    // Ẩn danh sách, hiển thị chi tiết
    document.getElementById("paymentDetail").classList.add("hidden");
}

function backToList() {
    // Hiển thị danh sách, ẩn chi tiết
    document.getElementById("paymentList").classList.add("hidden");

    // Xóa CSS chi tiết khách hàng khi quay lại danh sách
    let detailCSS = document.getElementById("detailCSS");
    if (detailCSS) {
        document.head.removeChild(detailCSS);
    }
}

function printPaymentDetail() {
    let printContents = document.getElementById("paymentDetail").innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
            <head>
                <title>In Chi Tiết Thanh Toán</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h2 { text-align: center; color: #007bff; }
                    p { font-size: 16px; margin: 10px 0; }
                    strong { color: #333; }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `;

    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // Reload lại trang sau khi in
}
</script>