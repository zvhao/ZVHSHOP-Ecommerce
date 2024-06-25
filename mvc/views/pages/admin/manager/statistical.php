<?php
$lastMonth = date("Y-m", strtotime('-1 month', strtotime(date('Y-m'))));
?>

<div>
	<h4>THÁNG TRƯỚC</h4>
	<div class="row">
		<div class="col-3 mb-3 p-3">
			<form method="POST" action="" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-success">
				<button type="submit" class="bg-transparent" name="btn-last-month">
					<i class="display-3 fa-solid fa-coins text-light"></i>
				</button>
				<h5 class="display-5 m-0">DOANH THU <br>(<?php echo $lastMonth ?>)<p class="m-0 font-weight-bold"><?= numberFormat($data['statisticalBillByMonth']['sumBill']) ?></p>
					<p class="pt-2"><?= $data['statisticalBillByMonth']['countBill'] ?> ĐƠN HÀNG</p>
				</h5>
			</form>
		</div>
		<?php
		if (isset($data['bestSellerByMonth']) && !empty($data['bestSellerByMonth'])) {
			foreach ($data['bestSellerByMonth'] as $item) {
		?>
				<div class="col-3 mb-3 p-3">
					<a target="_blank" href="<?= _WEB_ROOT . '/product/detail_product_admin/' . $item['id_pro'] ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-danger">
						<i class="display-3 fa-solid fa-star text-warning"></i>
						<h5 class="display-5 m-0">
							<p>BESTSELLER</p>
							<p style="display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;"><?= $item['name_pro'] ?></p>
							<p class="m-0 pt-2">ĐÃ BÁN <?= $item['bestSeller'] ?></p>
						</h5>
					</a>

				</div>
		<?php
			}
		}
		?>

	</div>
</div>
<div>
	<h4>THÁNG NÀY</h4>
	<div class="row">
		<div class="col-3 mb-3 p-3">
			<form method="POST" action="" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-success">
				<button type="submit" class="bg-transparent" name="btn-current-month">
					<i class="display-3 fa-solid fa-coins text-light"></i>
				</button>
				<h5 class="display-5 m-0">DOANH THU <br>(<?php echo date("Y-m") ?>)<p class="m-0 font-weight-bold"><?= numberFormat($data['statisticalBillByCurrentMonth']['sumBill']) ?></p>
					<p class="pt-2"><?= $data['statisticalBillByCurrentMonth']['countBill'] ?> ĐƠN HÀNG</p>
				</h5>
			</form>
		</div>
		<?php
		if (isset($data['bestSellerByCurrentMonth']) && !empty($data['bestSellerByCurrentMonth'])) {
			foreach ($data['bestSellerByCurrentMonth'] as $item) {
		?>
				<div class="col-3 mb-3 p-3">
					<a target="_blank" href="<?= _WEB_ROOT . '/product/detail_product_admin/' . $item['id_pro'] ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-danger">
						<i class="display-3 fa-solid fa-star text-warning"></i>
						<h5 class="display-5 m-0">
							<p>BESTSELLER</p>
							<p style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;"><?= $item['name_pro'] ?></p>
							<p class="m-0 pt-2">ĐÃ BÁN <?= $item['bestSeller'] ?></p>
						</h5>
					</a>

				</div>
		<?php
			}
		}
		?>

	</div>
</div>

<form action="" method="post" class="mb-3">
	<div class="d-flex mt-3">
		<!-- <div class="mr-3">
			<label for="date_start" class="form-label">Chọn tháng thống kê</label>
			<input type="month" class="form-control" value="">
		</div> -->

		<div class="mr-3">
			<label for="date_start" class="form-label">Thời gian bắt đầu</label>
			<input type="date" name="date_start" id="date_start" class="form-control" value="<?php
																								if (isset($_POST['btn-statistical']) || isset($_POST['btn-last-month']) || isset($_POST['btn-current-month'])) {
																									echo $_POST['date_start'];
																								} else echo date("Y-m-01"); ?>">
		</div>

		<div class="mr-5">
			<label for="date_end" class="form-label">Thời gian kết thúc</label>
			<input type="date" name="date_end" id="date_end" class="form-control" value="<?php
																							if (isset($_POST['btn-statistical']) || isset($_POST['btn-last-month']) || isset($_POST['btn-current-month'])) {
																								echo $_POST['date_end'];
																							} else echo date("Y-m-d"); ?>">

		</div>
		<div class="d-flex align-items-end">

			<button type="submit" class="btn btn-primary px-5" name="btn-statistical">Thống kê</button>
			<span class="text-danger ml-4">* Chỉ thống kê các đơn hàng đã giao</span>
		</div>
	</div>
</form>





<?php
// show_array($_SESSION);
if (isset($_SESSION['msg'])) {
?>
	<div class="">
		<span class="ml-5 mb-4 text-danger"><?= $_SESSION['msg']; ?></span>
	</div>
<?php
}

if (isset($_POST['btn-statistical']) && !isset($_SESSION['msg']) || isset($_POST['btn-last-month']) || isset($_POST['btn-current-month'])) {
?>

	<div class="py-4 d-flex ">
		<h4 class=" mr-5"><?= 'Thống kê từ ngày ' . date("d-m-Y", strtotime($_POST['date_start'])) . ' đến ' . date("d-m-Y", strtotime($_POST['date_end'])) . ' có ' . $data['countBillStatistical'] . ' đơn hàng' ?> </h4>
		<h4>Tổng doanh thu là <b class="text-primary"><?= numberFormat($data['sumBillStatistical']) ?></b></h4>
	</div>


	<table class="table table-striped table_bill">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">TÀI KHOẢN</th>
				<th scope="col">THANH TOÁN</th>
				<th scope="col">TỔNG ĐƠN HÀNG</th>
				<th scope="col" colspan="2">THỜI GIAN TẠO</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($data['billsNew'])) {
				foreach ($data['billsNew'] as $bill) {

			?>
					<tr>
						<th scope="row" class="align-middle"><?php echo $bill['id'] ?></th>
						<td class="align-middle"><?= $bill['user_id'] . "</br>" ?>
							<p style="width:150px; overflow: hidden; white-space: wrap; text-overflow:ellipsis; margin: 0;"><?= $bill['email_user'] . "</br>" . $bill['name_user']; ?></p>
						</td>
						<td class="align-middle"><?= $bill['method'] ?></td>
						<td class="align-middle text-right pr-5"><?= numberFormat($bill['total']) ?></td>
						<td class="align-middle"><?php echo $bill['created_at'] ?></td>
						<td class="align-middle">
							<input type="hidden" name="bill" value="<?= $bill['id'] ?>">
							<button type="button" class="btn btn-primary btn-detail-bill" data-id="<?= $bill['id'] ?>" data-toggle="modal" data-target="#modal">Xem</button>




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


<?php
}
?>