$(function () {
	const formContact = $('.form-contact')
	const action = formContact.attr('action')

	$(formContact).submit(function (e) {
		var formData = {
			name: $('input[name="name"]').val(),
			phone: $('input[name="phone"]').val(),
			email: $('input[name="email"]').val(),
			content: $('textarea#comment').val(),
			send_contact: $('button[name="send_contact"]').val()

		}
		$.ajax({
			type: "POST",
			url: action,
			data: formData,
			// dataType: "dataType",
			success: function (data) {
				Swal.fire(
					'Thành công!',
					'Bạn đã gửi thành công!',
					'success'
				)


			}
		});
		e.preventDefault();


	});
});