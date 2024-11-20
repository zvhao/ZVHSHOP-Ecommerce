<?php
if (!empty($data['msg'])) {
    echo '<div class="alert alert-' . $data['type'] . '">' . $data['msg'] . '</div>';
}
?>
<form method="POST">
    <div class="mb-3">
        <label for="customerName" class="form-label">Tên khách hàng</label>
        <input type="text" class="form-control" id="customerName" placeholder="Tên khách hàng" required>
    </div>
    <div class="mb-3">
        <label for="customerPhone" class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" id="customerPhone" placeholder="Số điện thoại" required>
    </div>
    <div class="mb-3">
        <label for="customerEmail" class="form-label">Email</label>
        <input type="text" class="form-control" id="customerEmail" placeholder="Email" required >
    </div>
    <div class="mb-3">
        <label for="customerAddress" class="form-label">Địa chỉ</label>
        <input type="text" class="form-control" id="customerAddress" placeholder="Địa chỉ" required>
    </div>

    <div class="form-group">
        <label for="customerInput">Khách Hàng</label>
        <input type="text" id="customerInput" class="form-control" placeholder="Nhập tên khách hàng...">
        <div id="customerList" class="list-group mt-2"></div>
    </div>



    <input type="hidden" name="add_category" value="add_category">
    <button type="submit" class="btn btn-primary">Thêm</button>
</form>