<div>
	<form action="" method="GET" class="d-flex mb-3">
		<select class="form-control w-25 mr-3" name="responded" id="">
			<option value="NULL" selected>Chưa phản hồi</option>
			<option value="NOT NULL" <?php if (isset($_GET['responded']) && $_GET['responded'] == 'NOT NULL') echo 'selected' ?>>Đã phản hồi</option>
		</select>
		<select class="form-control w-25 mr-5" name="order_by" id="">
			<option value="asc" selected>Cũ nhất</option>
			<option value="desc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'desc') echo 'selected' ?>>Mới nhất</option>
		</select>
		<button class="btn btn-primary px-4" name="btn-filter" value="yes">Lọc</button>
	</form>
	<div class="row font-weight-bold">
		<h4 class="col-6 font-weight-bold">Nội dung liên hệ</h4>

		<h4 class="col-6 font-weight-bold">Phản hồi liên hệ</h4>
	</div>
	<hr>
	<?php
	if (isset($_SESSION['msg_contact']) && $_SESSION['msg_contact'] != "") {
	?>
		<div id="message" class="alert alert-<?= $_SESSION['type_contact'] ?>"><?php echo  $_SESSION['msg_contact'] ?></div>
	<?php
		$_SESSION['msg_contact'] = '';
		$_SESSION['type_contact'] = '';
	}
	?>
	<?php
	if (isset($data['contacts']) && $data['contacts']) {
		foreach ($data['contacts'] as $contact) {
	?>
			<p style="color: #777"><?= $contact['created_at'] ?></p>
			<form action="<?= _WEB_ROOT . '/contact/respond' ?>" method="POST" data-id="<?= $contact['id'] ?>">
				<div class="row p-2">
					<div class="col-6">
						<div class=" mt-3">
							<div class="mb-2">
								<p class="row" style="word-wrap: break-word">
									<span class=" col-8">Khách hàng: <b class="user-select-all"><?= $contact['name'] ?></b></span>
									<span class="col">SĐT: <b class="user-select-all"><?= $contact['phone'] ?></b></span>
								</p>
								<p style="word-wrap: break-word">Email: <b class="user-select-all"><?= $contact['email'] ?></b> </p>
							</div>
							<div class="border-left border-primary p-3">
								<p class="user-select-all"><?= $contact['content'] ?></p>


							</div>
						</div>
					</div>
					<div class="col-6">
						<fieldset <?= $contact['responded'] ? 'disabled' : '' ?>>
							<p class="pl-3">Phản hồi đến email: <?= $contact['email'] ?></p>
							<textarea class="form-control" name="respond" id="" rows="3" data-id="<?= $contact['id'] ?>" required><?= $contact['responded'] ?? '' ?></textarea>
							<div class="d-flex justify-content-end align-items-center mt-3">
								<i class="mr-3 text-primary icon-check <?= $contact['responded'] ? 'fa-regular fa-circle-check' : '' ?>" style="font-size: 1.8rem;"></i>
								<input type="hidden" name="id_contact" value="<?= $contact['id'] ?>">
								<input type="hidden" name="email" value="<?= $contact['email'] ?>">
								<input type="hidden" name="name" value="<?= $contact['name'] ?>">
								<input type="hidden" name="content" value="<?= $contact['content'] ?>">
								<button type="submit" class="btn btn-primary" name="btn_respond" data-id="<?= $contact['id'] ?>"><?= $contact['responded'] ? 'Đã phản hồi' : 'Gửi phản hồi' ?></button>
							</div>
						</fieldset>

					</div>
				</div>
			</form>
			<hr>
	<?php
		}
	}
	?>

</div>