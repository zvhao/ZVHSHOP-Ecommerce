<div>
	<div class="row">
		<div class="col-3 mb-3 p-3">
			<a href="<?= _WEB_ROOT . '/user' ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-success">
				<i class="display-3 fa-solid fa-users-line"></i>
				<h5 class="display-5 m-0"><?= $data['countUser'] ?> USER</h5>
			</a>
		</div>
		<div class="col-3 mb-3 p-3">
			<a href="<?= _WEB_ROOT . '/category' ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-info">
				<i class="display-3 fa-brands fa-elementor"></i>
				<h5 class="display-5 m-0"><?= $data['countCate'] ?> DANH MỤC SP</h5>
			</a>
		</div>
		<div class="col-3 mb-3 p-3">
			<a href="<?= _WEB_ROOT . '/product' ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-warning">
				<i class="display-3 fa-solid fa-boxes-stacked"></i>
				<h5 class="display-5 m-0"><?= $data['countPro'] ?> SẢN PHẨM</h5>
			</a>
		</div>
		<!-- <div class="col-3 mb-3 p-3">
			<a href="<?= _WEB_ROOT . '/bill' ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-danger">
				<i class="display-3 fa-solid fa-list-check"></i>
				<h5 class="display-5 m-0"><?= $data['countBill'] ?> ĐƠN HÀNG</h5>
			</a>
		</div>
		<div class="col-3 mb-3 p-3">
			<a href="<?= _WEB_ROOT . '/statistical' ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-warning">
				<i class="display-3 fa-solid fa-coins"></i>
				<h5 class="display-5 m-0">DOANH THU <p class="m-0"><?= numberFormat($data['sumBill']) ?></p>
				</h5>
			</a>
		</div> -->
		<div class="col-3 mb-3 p-3">
			<a href="<?= _WEB_ROOT . '/bill' ?>" style="height: 200px;" class="d-flex p-3 align-items-center justify-content-around rounded-pill  text-center bg-danger">
				<i class="display-3 fa-solid fa-star"></i>
				<h5 class="display-5 m-0">
					<p>BESTSELLER</p>
					<p style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;"><?= $data['bestSellerAll']['name_pro'] ?></p>
					<p class="m-0">ĐÃ BÁN <?= $data['bestSellerAll']['tong'] ?></p>
				</h5>
			</a>

		</div>
	</div>

	<div class="row">
		<div class="col-6">
			<div class=" border border-primary m-3 p-3" style="border-radius: 20px">
				<h4 class="mb-3 text-success text-center font-weight-bold">TOP 5 BÁN NHIỀU NHẤT</h4>
				<ul class="">
					<?php
					if (isset($data['top5BestSellerNew']) && !empty($data['top5BestSellerNew'])) {
						foreach ($data['top5BestSellerNew'] as $item) {
					?>
							<li class="d-flex m-3 justify-content-between">
								<div class="d-flex align-items-center flex-grow">
									<img style="width: 80px; height: 80px; margin-top: 5px; max-width: 100%; object-fit: cover; object-position: center;" class="img-thumbnail" src="<?php echo _PATH_IMG_PRODUCT . $item['image'] ?>" width="60px">
									<div class="d-flex flex-column justify-content-center px-3">
										<span style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 270px;"><?= $item['name_pro'] ?></span>
										<p class="d-flex">
											<span class="text-warning"><?= getRatingStarRound($item['total_rating']) ?></span>
											<span class="pl-3">

												<span class=""><span class="text-primary"></span><?= $item['favorites'] ?> <i class="text-danger fa-solid fa-heart"></i></span>
											</span>
										</p>
									</div>

								</div>
								<a href="<?php echo _WEB_ROOT . '/product/detail_product_admin/' . $item['id_pro'] ?>" style="width: 100px; height: 100px; font-size: 1.1rem" class="rounded-pill bg-success d-flex justify-content-center align-items-center">Đã bán <?= $item['sold'] ?></a>

							</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
		<div class="col-6">
			<div class=" border border-primary m-3 p-3" style="border-radius: 20px">
				<h4 class="mb-3 text-warning text-center font-weight-bold">TOP 5 YÊU THÍCH NHẤT</h4>
				<ul class="">
					<?php
					if (isset($data['top5FavoritesNew']) && !empty($data['top5FavoritesNew'])) {
						foreach ($data['top5FavoritesNew'] as $item) {
					?>
							<li class="d-flex m-3 justify-content-between">
								<div class="d-flex align-items-center flex-grow">
									<img style="width: 80px; height: 80px; margin-top: 5px; max-width: 100%; object-fit: cover; object-position: center;" class="img-thumbnail" src="<?php echo _PATH_IMG_PRODUCT . $item['image'] ?>" width="60px">
									<div class="d-flex flex-column justify-content-center px-3">
										<span style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 270px;"><?= $item['name'] ?></span>
										<p class="d-flex">
											<span class="text-warning"><?= getRatingStarRound($item['total_rating']) ?></span>
											<span class="pl-3">

												<span class="">Đã bán <?= $item['sold'] ?></span>
											</span>
										</p>
									</div>

								</div>
								<a href="<?php echo _WEB_ROOT . '/product/detail_product_admin/' . $item['id_pro'] ?>" style="width: 100px; height: 100px; font-size: 1.8rem" class="rounded-pill bg-warning d-flex justify-content-center align-items-center"><?= $item['favorites'] ?><i class="pl-2 text-danger fa-solid fa-heart"></i></a>

							</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
		</div>

	</div>
</div>