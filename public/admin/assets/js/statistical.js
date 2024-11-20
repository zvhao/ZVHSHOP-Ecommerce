var location1 = window.location;
var origin = window.location.origin;
var pathname = window.location.pathname;
var project_name = pathname.split("/")[1];
var path_root = origin;
if (window.location.host == "localhost") {
  path_root = origin + "/" + project_name;
}
$(function () {
  var btnDetailBill = document.querySelectorAll(".btn-detail-bill");
  btnDetailBill.forEach(
    (element) =>
      (element.onclick = function (e) {
        var idDetailBill = e.target.dataset.id;
        e.preventDefault();
        console.log(idDetailBill);
        var formData = {
          id: idDetailBill,
        };

        $.ajax({
          type: "POST",
          url: path_root + "/statistical/show_detail",
          data: formData,
          // dataType: "dataType",
          success: function (data) {
            dataNew = JSON.parse(data);
            console.log(dataNew);
            var statusBill;

            if (dataNew.status == 0) {
              statusBill = "Đang xác nhận";
            }
            if (dataNew.status == 1) {
              statusBill = "Đang vận chuyển";
            }
            if (dataNew.status == 2) {
              statusBill = "Đã giao";
            }

            $("#modalLabel").text("ĐƠN HÀNG #" + idDetailBill);

            document.querySelector(".bill-info-user").innerHTML = `
						<div>
							<div class="checkout-heading mb-3 text-primary font-weight-bold" style="font-size: 1.6rem;">Thông tin khách
								hàng</div>
							<div class="pl-5">
								<p>Họ và tên: <span class="">${dataNew.fullname}</span></p>
								<p>Số điện thoại: <span class="">${dataNew.tel}</span> </p>
								<p>Email: <span class="">${dataNew.email}</span> </p>
								<p>Địa chỉ nhận hàng: <span class="">${dataNew.address}</span> </p>
								<p>Ghi chú: ${dataNew.note}</p>
							</div>
						</div>
						<div>
							<div class="checkout-heading mb-3 text-primary font-weight-bold" style="font-size: 1.6rem;">Thông tin tài
								khoản</div>
							<div class="pl-5">
								<p>ID: <span class="">${dataNew.user_id}</span></p>
								<p>Họ và tên: <span class="">${dataNew.name_user}</span></p>
								<p>Email: <span class="">${dataNew.email_user}</span> </p>
				
							</div>
						</div>
					`;
            document.querySelector(".bill-info-pro-list").innerHTML = "";
            dataNew.detail.forEach((e) => {
              document.querySelector(".bill-info-pro-list").innerHTML += `
						<div class="row checkout-item-pro" style="width: 95%!important;">
							<p class="col-2 m-0"><img width="60px" height="60px" src="${path_root}/upload/product/${
                e.image
              }" alt="" style="object-fit: cover; object-position: center;" ></p>
							<div class="col-7">
					
								<p class="checkout-item-name">${e.name_pro}</p>
								<strong> x ${e.qty}</strong>
							</div>
							<p class="m-0 col-3 d-flex justify-content-end align-items-center font-weight-bold text-primary">${
                e.price.toLocaleString("de-DE") + "₫"
              }</p>
						</div>
						`;
            });

            document.querySelector(".bill-info-bill").innerHTML = `
							<div class="col">
								<p>Thời gian tạo: <span class="text-primary">${dataNew.created_at}</span></p>
								<p>Trạng thái đơn hàng: <span class="text-primary">${statusBill}</p>
							</div>
							<div class="col text-right">
								<p class="font-weight-bold text-primary" style="font-size:1.2rem">Tổng giá: ${
                  dataNew.total.toLocaleString("de-DE") + "₫"
                }</p>
								<p class="">Phương thức thanh toán: <span class="text-primary">${
                  dataNew.method
                }</span></p>
							</div>

						`;
          },
        });
      })
  );
});
