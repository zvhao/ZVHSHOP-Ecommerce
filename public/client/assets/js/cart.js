var $url = window.location.href;
var origin = window.location.origin;
var pathname = window.location.pathname;
var project_name = pathname.split("/")[1];
var path_root = origin + "/" + project_name;
console.log(path_root);
var PATH_ROOT = path_root + "/";
var PATH_IMG_PRODUCT = path_root + "/upload/product/";

$(function () {
  // update num_order cart

  //block press enter
  $(".num-order").keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

  // $(".num-order").change(function (e) {
  //   var action = document.querySelector("form.form-update-cart").action;
  //   // e.preventDefault();
  //   var id = $(this).attr("data-id");
  //   var qty = $(this).val();
  //   var remainingVal = $(`input[id=remaining-${id}]`).val();

  //   var remaining = $(`span[data-name=remaining-${id}]`);
  //   $(remaining).text(remainingVal - qty);
  //   if ($(remaining).text() == 0) {
  //     $(remaining).addClass("text-danger");
  //   } else if ($(remaining).hasClass("text-danger")) {
  //     $(remaining).removeClass("text-danger");
  //   }
  //   var formPost = {
  //     id: id,
  //     qty: qty,
  //   };
  //   $.ajax({
  //     type: "POST",
  //     url: action,
  //     data: formPost,
  //     success: function (data) {
  //       var dataNew = JSON.parse(data);
  //       // console.log(dataNew);
  //       $("#sub_total-" + id).text(
  //         dataNew.sub_total.toLocaleString("de-DE") + "₫"
  //       );
  //       $("#total-cart").text(dataNew.total.toLocaleString("de-DE") + "₫");
  //       $(".header-cart-notice").text(dataNew.num_order);
  //       $(`span[data-id='${id}']`).text(dataNew.qty);
  //     },
  //   });
  //   e.preventDefault();
  // });

  // detele cart
  var headerCart = document.querySelector(".header-cart-list");
  // console.log(headerCart.innerHTML);
  $(".del-product").click(function (e) {
    e.preventDefault();
    var href = $(this).attr("href");
    var id = $(this).attr("data-id");
    // console.log(id);
    $.ajax({
      type: "GET",
      url: href,
      data: id,
      // dataType: "dataType",
      success: function (data) {
        var dataNew = JSON.parse(data);
        $("#total-cart").text(dataNew.total.toLocaleString("de-DE") + "₫");
        $(`tr[data-id='${id}']`).remove();
        $(`li[data-id='${id}']`).remove();
        $(".header-cart-notice").text(dataNew.num_order);
        console.log(dataNew);
        if (dataNew.checkEmpty == 1) {
          document.querySelector(
            ".section-render"
          ).innerHTML = `<span class="fs-3">Không có sản phẩm nào trong giỏ hàng, click <a href="home">vào đây</a> để về trang chủ</span>`;
          $(".header-has-cart").remove();
          headerCart.innerHTML = `<div class="header-no-cart">
					<img src="${path_root}/public/client/assets/img/no-cart.png" alt="" class="header-no-cart-img">
					<span class="header-no-cart-msg">
						Chưa có sản phẩm
					</span></div>`;

          if (dataNew.check_user == 1) {
            document.querySelector(
              ".header-no-cart"
            ).innerHTML += `<div class="d-flex justify-content-center mb-3"><a class="outline-main p-3 fs-4" href="${PATH_ROOT}bill/show_bill">ĐƠN HÀNG CỦA TÔI</a></div>`;
          }
        }
      },
    });
  });

  $(".btn-view-cart-header").click(function (e) {
    e.preventDefault();
  });

  // tang giam number cart

  $('[name^="minus-"], [name^="plus-"]').click(function () {
    var input = $(this).siblings("input.num-order");
    var currentValue = parseInt(input.val());
    var maxValue = parseInt(input.attr("max"));

    if ($(this).attr("name").startsWith("minus-") && currentValue > 1) {
      input.val(currentValue - 1).trigger("change");
    } else if (
      $(this).attr("name").startsWith("plus-") &&
      currentValue < maxValue
    ) {
      input.val(currentValue + 1).trigger("change");
    }
  });

  $(".num-order").change(function (e) {
    var action = document.querySelector("form.form-update-cart").action;
    var id = $(this).attr("data-id");
    var qty = $(this).val();
    var remainingVal = $(`input[id=remaining-${id}]`).val();

    var remaining = $(`span[data-name=remaining-${id}]`);
    $(remaining).text(remainingVal - qty);
    if ($(remaining).text() == 0) {
      $(remaining).addClass("text-danger");
    } else if ($(remaining).hasClass("text-danger")) {
      $(remaining).removeClass("text-danger");
    }

    var formPost = {
      id: id,
      qty: qty,
    };

    $.ajax({
      type: "POST",
      url: action,
      data: formPost,
      success: function (data) {
        var dataNew = JSON.parse(data);
        $("#sub_total-" + id).text(
          dataNew.sub_total.toLocaleString("de-DE") + "₫"
        );
        $("#total-cart").text(dataNew.total.toLocaleString("de-DE") + "₫");
        $(".header-cart-notice").text(dataNew.num_order);
        $(`span[data-id='${id}']`).text(dataNew.qty);
      },
    });
    e.preventDefault();
  });
});


