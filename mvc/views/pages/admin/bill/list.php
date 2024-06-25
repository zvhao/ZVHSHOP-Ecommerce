<div class="mb-3 row gap-3">

	<form class="col-4" action="<?= _WEB_ROOT . '/bill' ?>" method="POST">
		<select name="status" class="custom-select mb-2">
			<option value="-1" selected>Chọn trạng thái...</option>
			<option value="0" <?= selectedStatusBill('status', 0) ?> >Đang xác nhận</option>
			<option value="1" <?= selectedStatusBill('status', 1) ?> >Đang vận chuyển</option>
			<option value="2" <?= selectedStatusBill('status', 2) ?> >Đã giao</option>
		</select>
		<button type="submit" class="btn btn-outline-primary mb-2">Lọc trạng thái</button>

	</form>

	<div class="col-8">
		<form action="<?= _WEB_ROOT . '/bill' ?>" method="get">
			<input type="text" class="form-control" placeholder="Tìm kiếm đơn hàng" name="search" value="<?= $data['keyword'] ?>">
		</form>
	</div>
</div>

<?php
if (!empty($_SESSION['msg'])) {
	echo '<div class="alert alert-success" id="toast-success">' . $_SESSION['msg'] . '</div>';
	$_SESSION['msg'] = '';
}
?>
<div class="d-flex justify-content-between">
	<h4>Số đơn hàng hiện có là <?= $data['count_product'] ?></h4>

	<?php
	getPagingAdmin($data['count_product'], $data['num_per_page'], $data['pagePag']);
	?>
</div>
<table class="table table-striped table_bill">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">TÀI KHOẢN</th>
			<th scope="col">THÔNG TIN KHÁCH HÀNG</th>
			<th scope="col">THÔNG TIN SẢN PHẨM</th>
			<th scope="col">TRẠNG THÁI</th>
			<th scope="col">THANH TOÁN</th>
			<th scope="col">THỜI GIAN TẠO</th>
			<th class="text-center" scope="col">THAO TÁC</th>
		</tr>
	</thead>
	<tbody style="font-size: 14px">
		<?php
		if (!empty($data['billsNew'])) {
			foreach ($data['billsNew'] as $bill) {
		?>
				<tr>
					<th scope="row" class="align-middle"><?php echo $bill['id'] ?></th>
					<td class="align-middle"><?= $bill['user_id'] . "</br>" ?>
						<p style="width:150px; overflow: hidden; white-space: wrap; text-overflow:ellipsis"><?= $bill['email_user'] . "</br>" . $bill['name_user']; ?></p>
					</td>
					<td class="align-middle" style="width: 200px">
						<?= $bill['fullname'] ?><br>
						<?= $bill['tel'] ?><br>
						<?= $bill['email'] ?><br>
						<?= $bill['address'] ?><br>
					</td>
					<td class="align-middle" class="text-color-main">
						<span><?php
								foreach ($bill['detail'] as $item) {
									echo 'ID sản phẩm: ' . $item['id_pro'] . ' x ' . $item['qty'] . '<br>';
								}  ?></span>
						<p class="m-0">Tổng tiền: <?= $this->numberFormat($bill['total']) ?></p>
					</td>
					<td class="align-middle" data-id="<?= $bill['id'] ?>"><?= $this->getStatusBill($bill['status']) ?></td>
					<td class="align-middle"><?= $bill['method'] ?></td>
					<td class="align-middle"><?php echo $bill['created_at'] ?></td>
					<td class="text-center align-middle">
						<input type="hidden" name="href-<?= $bill['id'] ?>" value="<?php echo _WEB_ROOT . '/bill/update_bill/' . $bill['id'] ?>">
						<button type="button" class="btn btn-primary btn-detail-bill mr-2" data-id="<?= $bill['id'] ?>" data-toggle="modal" data-target="#modal">Xem</button>
						<button class="btn btn-outline-primary btn-update-status" href="<?php echo _WEB_ROOT . '/bill/update_bill/' . $bill['id'] ?>" data-id="<?= $bill['id'] ?>" <?php if ($bill['status'] == 2) echo 'disabled' ?> title="Vận chuyển">
							<i class="fa-solid fa-dolly" data-id="<?= $bill['id'] ?>"></i>
						</button>
						<a class="handle_delete btn btn-outline-danger ml-2" href="<?php echo _WEB_ROOT . '/bill/delete_bill/' . $bill['id'] ?>">
							<i class="fas fa-trash-alt"></i>
						</a>
					</td>
				</tr>
			<?php
			}
		} else {
			?>
			<tr>
				<td colspan="8" class="text-center">KHÔNG CÓ DỮ LIỆU</td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" style="max-width: 75%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">ĐƠN HÀNG</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row" style="font-size: 1rem;">
				<div class="d-flex flex-column col-5 bill-info-user">
				</div>

				<div class="col-7 bill-info-product">
					<div class="checkout-heading mb-3 text-primary font-weight-bold" style="font-size: 1.6rem;">Thông tin đơn hàng</div>
					<div class="bill-info-pro-list" style=" max-height: 40vh; overflow-y: auto;">

					</div>
					<div class="bill-info-bill row border-top border-primary pt-3 pr-3">

					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>