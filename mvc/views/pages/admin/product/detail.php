<div class="mx-4 my-2">
	<div class="row">
		<div class="col-2">
			<img style=" margin-top: 5px; max-width: 100%; object-fit: cover; object-position: center;" class="img-thumbnail" src="<?php echo _PATH_IMG_PRODUCT . $data['product']['image'] ?>"></td>
		</div>
		<div class="col-10 d-flex flex-column justify-content-around">
			<p class="font-weight-bold" name="id_pro">#<?= $data['product']['id'] ?></p>
			<p class="text-primary font-weight-bold" style="font-size: 1.4rem;"><?= $data['product']['name'] ?></p>
			<div class="">

				<span class="mr-3  text-primary"><?= $data['avgRating'] ?></span>
				<span class=" mr-5 text-primary">
					<?= getRatingStarRound($data['avgRating']) ?>
				</span>

				<span class="mr-5">
					<i class="text-primary fa-solid fa-heart px-2"></i>
					<span class=""><span class="text-primary"><?= $data['favorites'] ?></span> lượt thích</span>
				</span>
				<span class="mr-5"><span class="text-primary"><?= $data['sold'] ?></span> đã bán</span>
				<span class="mr-5"><span class="text-primary"><?= $data['countComment'] ?></span> đánh giá</span>
				<span class=""><span class="text-primary"><?= $data['product']['remaining'] ?></span>  sản phẩm có sẵn</span>
			</div>
			<p class="font-weight-bold text-primary" style="font-size: 1.4rem;"><?php numberFormat($data['product']['price']) ?></p>
		</div>
	</div>
	<div class="table-comments mt-4">
		<h4 class="text-primary text-center">ĐÁNH GIÁ BÌNH LUẬN</h4>
		<div class="row">
			<div class="col-3">
				<p class="mb-0 text-center lh-1"><span class="text-primary" style="font-size: 1.5rem;"><?= $data['avgRating'] ?></span> trên 5</p>
				<p class="icon-main text-center text-primary" style="font-size: 1.4rem;">
					<?= getRatingStarRound($data['avgRating']) ?>
				</p>
			</div>
			<div class="col-9 d-flex align-items-center">
				<span class=""><span class="text-primary"><?= $data['countComment'] ?></span> đánh giá</span>

			</div>
		</div>
		<hr>
		<?php
		if (isset($data['comments']) && $data['comments']) {
			foreach ($data['comments'] as $item) {
		?>
				<form action="<?= _WEB_ROOT . '/comment/reply_comment' ?>" method="POST" class="row form-reply-comment">
					<div class="col-6">
						<div class="row ">
							<div class="col-2">
								<img class=" rounded-circle" src="<?php if (!empty($item['avatar'])) {
																		echo _PATH_AVATAR . $item['avatar'];
																	} else echo _PATH_IMG_PUBLIC . '/profile.jpg'; ?> ?> " alt="" style="width: 60px; height: 60px; max-width: 100%; object-fit: cover; object-position: center; margin-bottom: 5px;">
							</div>
							<div class="col-10 ">
								<span class="" style="white-space: nowrap;"><?= $item['name'] ?></span>
								<p class="text-primary">
									<?php getRatingStar($item['rating']) ?>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<p class="" style="color: #666"><?= $item['created_at'] ?></p>
								<p class="pr-3"><?= $item['comment'] ?></p>
							</div>
						</div>
					</div>
					<fieldset class="col-6" data-id="<?= $item['id'] ?>" <?= $item['responded'] ? 'disabled' : '' ?>>
						<textarea class="form-control" name="reply_comment" id="" rows="3" data-id="<?= $item['id'] ?>"><?= getSampleComment($item['rating']) ?></textarea>
						<div class="d-flex justify-content-end align-items-center mt-3">
							<i class="mr-3 text-primary <?= $item['responded'] ? 'fa-regular fa-circle-check' : '' ?>" style="font-size: 1.8rem;" name="id-<?= $item['id'] ?>"></i>
							<button type="submit" class="btn btn-primary" name="btn_reply_cmt" data-id="<?= $item['id'] ?>"><?= $item['responded'] ? 'Đã phản hồi' : 'Gửi phản hồi' ?> </button>
						</div>
					</fieldset>
				</form>
				<hr>

		<?php
			}
		}
		?>

	</div>
</div>