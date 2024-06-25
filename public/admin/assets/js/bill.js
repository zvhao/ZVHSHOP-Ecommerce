$(function () {
	var btn = document.querySelectorAll('.btn-update-status')

	btn.forEach(element => {
		$(element).click(function (e) {
			const idBill = e.target.dataset.id
			var status = $(`td[data-id='${idBill}']`)[0]
			// const href = e.attr('href');
			var href = $(`input[name="href-${idBill}"]`).val()
			if (e.target.nodeName == 'I') {
				var btnUpdate = e.target.parentElement
			}
			if (e.target.nodeName == 'BUTTON') {
				var btnUpdate = e.target
			}

			e.preventDefault();

			$.ajax({
				type: "POST",
				url: href,
				success: function (data) {

					if (data == 1) {
						var staText = 'Đang vận chuyển'
						status.innerHTML = staText

					}
					if (data == 2) {
						var staText = 'Đã giao'
						status.innerHTML = staText
						$(btnUpdate).attr("disabled", "");
					}
					Swal.fire({
						icon: 'success',
						title: 'Đơn hàng ' + staText,
						showConfirmButton: false,
						timer: 1500
					})
					// console.log(data);

				}
			});

		});

	});
});