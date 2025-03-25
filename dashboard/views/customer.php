<?php
require_once __DIR__ . "/../../module/customerModule.php";
$customerModule = new CustomerModule();
$customers = $customerModule->getAllCustomers();
?>

<div style="margin-left: 254px;">
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
            <tbody class="table-customer">
                <?php foreach ($customers as $index => $customer): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($customer['full_name']) ?></td>
                        <td><?= htmlspecialchars($customer['phone']) ?></td>
                        <td><?= htmlspecialchars($customer['email']) ?></td>
                        <td><?= $customer['total_orders'] ?></td>
                        <td><?= number_format($customer['total_spent'], 0, ',', '.') ?>VND</td>
                        <td><?= $customer['membership_level'] ?></td>
                        <td class="sub-customer">
                            <button class="btn btn-primary btn-customer" onclick="showCustomerDetail(<?= $customer['id'] ?>)">
                                <i class="fa fa-eye"></i> Xem
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Chi tiết khách hàng (ẩn ban đầu) -->
<div id="customerDetail" class="customerDetail" style="display: none;">
    <div class="customer-detail-content">
        <h2>Thông tin khách hàng</h2>
        <div class="customer-info">
            <p><strong>Họ và tên:</strong> <span id="detailName"></span></p>
            <p><strong>Địa chỉ:</strong> <span id="detailAddress"></span></p>
            <p><strong>Thành phố:</strong> <span id="detailCity"></span></p>
            <p><strong>Quốc gia:</strong> <span id="detailCountry"></span></p>
            <p><strong>Số điện thoại:</strong> <span id="detailPhone"></span></p>
            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
            <p><strong>Tổng đơn:</strong> <span id="detailOrders"></span></p>
            <p><strong>Tổng chi tiêu:</strong> <span id="detailSpent"></span></p>
            <p><strong>Hạng:</strong> <span id="detailMember"></span></p>
        </div>
        <button class="btn btn-back" onclick="backToList()">Quay lại</button>
    </div>
</div>

<script>
async function showCustomerDetail(customerId) {
    try {
        
        const response = await fetch(`/MIKEPHP/admin/customer/${customerId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        


        const customer = await response.json();
       
        
        if (customer.success) {
            const data = customer.data;
            document.getElementById("detailName").innerText = data.name;
            document.getElementById("detailPhone").innerText = data.address_phone;
            document.getElementById("detailAddress").innerText = data.address;
            document.getElementById("detailCity").innerText = data.city;
            document.getElementById("detailCountry").innerText = data.country;
            document.getElementById("detailEmail").innerText = data.email;
            document.getElementById("detailOrders").innerText = data.total_orders;
            document.getElementById("detailSpent").innerText = new Intl.NumberFormat('vi-VN').format(data.total_spent) + 'VND';
            document.getElementById("detailMember").innerText = data.membership_level;
            
            document.getElementById("customerDetail").style.display = "flex";
        } else {
            console.error('Customer data error:', customer);
            alert(customer.message || 'Không thể tải thông tin khách hàng');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi tải thông tin khách hàng');
    }
}

function backToList() {
    document.getElementById("customerDetail").style.display = "none";
}
</script>