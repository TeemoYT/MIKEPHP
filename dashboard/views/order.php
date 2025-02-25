
<div style="overflow-y: auto; height: 750px;">
<div class="d-flex head-order">
<h3>Danh sách đơn hàng</h3>
    <select class="filter" style="width:52px;">
        <option value="">Lọc</option>
        <option value="">Id</option>
        <option value="Name">A->Z</option>
        <option value="Name">Z->A</option>
        <option value="">Tổng sản phẩm</option>
        <option value="">Ngày đặt</option>
        <option value="">Trạng thái</option>
    </select>
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Tên khách hàng</th>
      <th scope="col">Tổng sản phẩm</th>
      <th scope="col">Tổng tiền</th>
      <th scope="col">Ngày đặt</th>
      <th scope="col">Trạng thái</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody >
    <tr>
      <td>1</td>
      <td>Nguyễn văn cặc</td>
      <td>3 sản phẩm</td>
      <td>2.500.000 VND</td>
      <td>14/08/2025</td>
      <td>Đang xử lý</td>
      <td>
        <button class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> Xem</button>
        <button class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Hủy</button>
      </td>
    </tr>

  </tbody>
</table>