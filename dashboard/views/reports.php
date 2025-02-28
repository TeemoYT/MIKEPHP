

<h2>Danh sách báo cáo & phân tích</h2>
<div style="overflow-y: auto; height: 300px;">
<table class="table-notifi" style="width: 100%; border-collapse: collapse; text-align: center; font-family: Arial, sans-serif;">
    <thead style="background-color: #f8f9fa; font-weight: bold;">
        <tr>
                <th>📊 Doanh thu hôm nay</th>
                <th>📦 Đơn hàng hôm nay</th>
                <th>🔥 Top bán chạy</th>
                <th>❌ Đơn bị hoàn</th>
                <th>⚠️ Sắp hết hàng</th>
        </tr>
    </thead>
    <tbody class="table-notifi" >
        <tr style="border-bottom: 1px solid #ddd;">
                <td>💰 15.000.000 VND</td>
                <td>✅ 120 đơn</td>
                <td>👟 Air Force 1, Jordan 1</td>
                <td>⚠️ 3%</td>
                <td>🔻 AF1 size 43</td>
        </tr>
        
    </tbody>
</table>
</div>

<?php
// Dữ liệu thống kê
$doanhThuHomNay = 15000000;
$donHangHomNay = 120;
$donBiHoan = 3; // %
$sanPhamSapHet = 1; // Số lượng sản phẩm sắp hết hàng
?>

<h2>📊 Biểu đồ Báo Cáo & Phân Tích</h2>
<canvas id="reportChart"></canvas>

<script>
// Lấy dữ liệu từ PHP
const data = {
    labels: ["Doanh thu", "Đơn hàng", "Hoàn đơn", "Sắp hết hàng"],
    datasets: [{
        label: "Thống kê hôm nay",
        data: [
            <?= $doanhThuHomNay / 1000000 ?>, // Chuyển về đơn vị triệu VND
            <?= $donHangHomNay ?>,
            <?= $donBiHoan ?>,
            <?= $sanPhamSapHet ?>
        ],
        backgroundColor: ["#007bff", "#28a745", "#dc3545", "#ffc107"]
    }]
};

// Tạo biểu đồ
const ctx = document.getElementById("reportChart").getContext("2d");
new Chart(ctx, {
    type: "bar",
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
