$(document).ready(function () {
  const form_vn_pay = $(".submit_vnpay");
  const img_vnpay = $(".vnpay_img");
  const formPayment = $(".form_checkout");

  img_vnpay.on("click", function (e) {
    const fullname = $('input[name="fullname"]').val();
    const tel = $('input[name="tel"]').val();
    const email = $('input[name="email"]').val();
    const address = $('input[name="address"]').val();
    const note = $("#note").val();
    const total = $('input[name="total"]').val();

    if (!fullname || !tel || !email || !address || !total) {
      alert("Thông tin chưa hợp lệ!!!");
    } else {
      const data_payment = {
        method: "Vn_pay",
        fullname,
        email,
        tel,
        address,
        note,
        total,
        add_bill: "add_bill",
      };
      localStorage.setItem("data_payment", JSON.stringify(data_payment));
      localStorage.setItem(
        "url_payment",
        JSON.stringify(formPayment.attr("action"))
      );
      form_vn_pay.submit();
    }
  });

  const success_vnpay = $(".success_vnpay");
  if (success_vnpay.length) {
    const data_payment = JSON.parse(localStorage.getItem("data_payment"));
    const url = JSON.parse(localStorage.getItem("url_payment"));
    if (data_payment && url) {
      $.ajax({
        type: "POST",
        url: url,
        data: data_payment,
        dataType: "text",
        success: function (data) {
          localStorage.removeItem("data_payment");
          localStorage.removeItem("url_payment");
          console.log("thanh cong");
        },
        error: function (e) {
          console.log(e);
        },
      });
    }
  }
});
