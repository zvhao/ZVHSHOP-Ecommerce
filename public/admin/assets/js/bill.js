var location1 = window.location;
var origin = window.location.origin;
var pathname = window.location.pathname;
var project_name = pathname.split("/")[1];
var path_root = origin;
if (window.location.host == "localhost") {
  path_root = origin + "/" + project_name;
}

$(function () {
  var btn = document.querySelectorAll(".btn-update-status");

  btn.forEach((element) => {
    $(element).click(function (e) {
      const idBill = e.target.dataset.id;
      var status = $(`td[data-id='${idBill}']`)[0];
      // const href = e.attr('href');
      var href = $(`input[name="href-${idBill}"]`).val();
      if (e.target.nodeName == "I") {
        var btnUpdate = e.target.parentElement;
      }
      if (e.target.nodeName == "BUTTON") {
        var btnUpdate = e.target;
      }

      e.preventDefault();

      $.ajax({
        type: "POST",
        url: href,
        success: function (data) {
          if (data == 1) {
            var staText = "Đang vận chuyển";
            status.innerHTML = staText;
          }
          if (data == 2) {
            var staText = "Đã giao";
            status.innerHTML = staText;
            $(btnUpdate).attr("disabled", "");
          }
          Swal.fire({
            icon: "success",
            title: "Đơn hàng " + staText,
            showConfirmButton: false,
            timer: 1500,
          });
          // console.log(data);
        },
      });
    });
  });
});

$(document).ready(function () {
  let isCustomerSelected = false; // Biến để kiểm tra xem đã chọn khách hàng chưa

  $("#customerInput").on("keyup", function () {
    let query = $(this).val();
    isCustomerSelected = false; // Reset biến khi người dùng bắt đầu nhập lại
    $("#customerEmail").prop("readonly", false); // Cho phép chỉnh sửa email

    if (query !== "") {
      $.ajax({
        url: path_root + "/user/get_user",
        method: "POST",
        data: { query: query },
        success: function (data) {
          $("#customerList").fadeIn();
          $("#customerList").html(data);
        },
      });
    } else {
      $("#customerList").fadeOut();
      $("#customerList").html("");
    }
  });

  $(document).on("click", ".customer-item", function (e) {
    e.preventDefault();
    isCustomerSelected = true; // Đánh dấu đã chọn khách hàng

    // Điền thông tin vào các ô nhập liệu
    $("#customerName").val($(this).data("name"));
    $("#customerPhone").val($(this).data("phone"));
    $("#customerEmail").val($(this).data("email"));
    $("#customerAddress").val($(this).data("address"));
    $("#customerInput").val($(this).text());

    // Khóa ô email
    $("#customerEmail").prop("readonly", true);
    $("#customerList").fadeOut();
  });

  // Khi người dùng thay đổi giá trị của ô email
  $("#customerEmail").on("input", function () {
    if (!isCustomerSelected) {
      $(this).prop("readonly", false); // Cho phép thay đổi nếu chưa chọn khách hàng
    }
  });
});
