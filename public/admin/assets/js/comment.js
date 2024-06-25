$(function () {
	var btnReplyCmt = document.querySelectorAll('button[name=btn_reply_cmt]')
	var action = $('.form-reply-comment')[0].action

	btnReplyCmt.forEach(element => {
		$(element).click(function (e) {
			e.preventDefault();
			var idCmt = e.target.dataset.id
			var content = $(`textarea[data-id=${idCmt}]`).text()
			// console.log(idCmt);

			var data = {
				id_cmt: idCmt,
				reply_comment: content,
				btn_reply_cmt: 1
			}

			$.ajax({
				type: "POST",
				url: action,
				data: data,
				// dataType: "dataType",
				success: function (data) {
					var dataNew = JSON.parse(data)
					// console.log(dataNew);
					$(`fieldset[data-id=${idCmt}]`).attr('disabled', 'disabled');
					$(`i[name=id-${idCmt}]`).addClass('fa-regular fa-circle-check');
					Swal.fire({
						icon: 'success',
						title: 'Phản hồi thành công!',
						showConfirmButton: false,
						timer: 1500
					})

				}
			});
		});

	});
});