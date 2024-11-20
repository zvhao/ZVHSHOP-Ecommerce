// Lấy path của URL hiện tại
var location1 = window.location
var origin = window.location.origin;
var pathname = window.location.pathname;
var project_name = pathname.split("/")[1];
var path_root = origin
if(window.location.host == 'localhost') {
  path_root = origin + "/" + project_name;
}
// Hiển thị path
console.log(location1);
console.log(origin);
console.log(path_root);

// swiper_porduct
var swiper = new Swiper(".mySwiper", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 3,
  freeMode: true,
  direction: "vertical",

  watchSlidesProgress: true,
});
var swiper2 = new Swiper(".mySwiper2", {
  loop: true,
  spaceBetween: 10,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: swiper,
  },
});

// favorite like
$(function () {
  $(".icon-favorite").click(function (e) {
    e.preventDefault();
    var id_user = $('input[name="id_user"]').val();
    console.log(id_user);
    if (id_user) {
      if ($(this).hasClass("fa-regular")) {
        var formData = {
          id_pro: $('input[name="id_pro"]').val(),
        };

        $.ajax({
          type: "POST",
          url: path_root + "/DetailProduct/add_favorite",
          data: formData,
          // dataType: "dataType",
          success: function (data) {
            $(".icon-favorite").removeClass("fa-regular");
            $(".icon-favorite").addClass("fa-solid");
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Đã thêm sản phẩm yêu thích!",
              showConfirmButton: false,
              timer: 1000,
            });
            let favorites = document.querySelector(".favorites").innerHTML;
            console.log(favorites);
            let favoritesNew = parseInt(favorites) + 1;
            $(".favorites").text(favoritesNew);
          },
          error: function (xhr, ajaxOptions, throwError) {
            alert(xhr.status);
            alert(throwError);
          },
        });
      } else {
        formData = {
          id_pro: $('input[name="id_pro"]').val(),
        };
        $.ajax({
          type: "POST",
          url: path_root + "/DetailProduct/delete_favorite",
          data: formData,
          // dataType: "dataType",
          success: function (data) {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Đã xoá sản phẩm yêu thích!",
              showConfirmButton: false,
              timer: 1000,
            });
            let favorites = document.querySelector(".favorites").innerHTML;
            console.log(favorites);
            let favoritesNew = parseInt(favorites) - 1;
            $(".favorites").text(favoritesNew);

            $(".icon-favorite").removeClass("fa-solid");
            $(".icon-favorite").addClass("fa-regular");
          },
          error: function (xhr, ajaxOptions, throwError) {
            alert(xhr.status);
            alert(throwError);
          },
        });
      }
    }
  });
});

// Thu gọn detail_product
$(function () {
  const contentDetail = document.querySelector(".desc-short-product");
  const btn1 = document.getElementById("btn1");
  const btn2 = document.getElementById("btn2");
  // console.log(contentDetail);
  var offset = contentDetail.offsetHeight;

  // console.log(offset);

  if (offset > 300) {
    contentDetail.style.height = "300px";
    btn1.style.display = "none";
    btn2.style.display = "";
  } else {
    btn1.style.display = "none";
    btn2.style.display = "none";
  }

  btn1.onclick = function () {
    contentDetail.style.height = "300px";
    btn1.style.display = "none";
    btn2.style.display = "";
  };
  btn2.onclick = function () {
    contentDetail.style.height = "auto";
    btn1.style.display = "";
    btn2.style.display = "none";
  };
});

//submit form comment - detail product

var $url = window.location.href;
$(document).ready(function () {
  var $action = document.querySelector("form.form-comment").action;
  $(".form-comment").submit(function (event) {
    var formData = {
      stars: $("input[name=stars]").val(),
      id_user: $("input[name=id_user]").val(),
      id_pro: $("input[name=id_pro]").val(),
      comment: $("textarea[name=comment]").val(),
      btn_submit: $("button[name=btn_submit]").val(),
    };

    $.ajax({
      type: "POST",
      url: $action,
      data: formData,
      dataType: "json",
      encode: true,
      success: function (data) {
        Swal.fire({
          icon: "success",
          title: "Cảm ơn bạn đã đánh giá!",
          showConfirmButton: false,
          timer: 1500,
        });
        // var dataNew = JSON.parse(data)
        console.log(data);
        $(".avg-rating").text(data.avgRound);
        $(".count-comment").text(data.countComment);
        $(".form-comment").load($url + " .form-comment");
        $(".table-comments").load($url + " .table-comments");
      },
      error: function (xhr, ajaxOptions, throwError) {
        alert(xhr.status);
        alert(throwError);
      },
    });

    event.preventDefault();
  });
});

var inputRating = document.querySelector("input[name=stars]");
var rs = document.getElementsByClassName("icon-rating");
for (const [key, value] of Object.entries(rs)) {
  value.addEventListener("click", function () {
    // console.log(parseInt(key) + 1);
    var value = parseInt(key) + 1;
    inputRating.value = value;
    for (let index = 0; index < value; index++) {
      // console.log(rs[index].className);
      rs[index].classList.add("fa-solid");
      rs[index].classList.remove("fa-regular");
    }
    for (let j = 4; j >= value; j--) {
      // console.log(1);
      // console.log(rs[j].classList[parseInt(rs[j].classList.length) - 1]);
      if (rs[j].classList[parseInt(rs[j].classList.length) - 1] == "fa-solid") {
        rs[j].classList.remove("fa-solid");
        rs[j].classList.add("fa-regular");
        // console.log(Object.values(rs[j].classList).length);
      }
      // rs[j].className = rs[j].className === 'fa-solid' ? 'fa-regular' : 'fa-solid';
    }
  });
  //
}

var PATH_IMG_PRODUCT = path_root + "/upload/product/";
var PATH_ROOT = path_root + "/";
//add to cart
$(document).ready(function () {
  var $action = document.querySelector("form.form-add-to-cart").action;

  console.log($(".num-order").val());
  $("form.form-add-to-cart").submit(function (e) {
    var id = $('input[name="id_pro"]').val();
    var formData = {
      num_order: $(".num-order").val(),
      add_to_cart: $(".add-to-cart").val(),
      id: id,
    };

    $.ajax({
      type: "POST",
      url: $action,
      data: formData,
      // dataType: "json",
      // encode: true,
      success: function (data) {
        Swal.fire({
          icon: "success",
          title: "Thêm vào giỏ thành công!",
          showCancelButton: true,
          confirmButtonColor: "#037dff",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vào giỏ hàng!",
          cancelButtonText: "OK!",
          backdrop: `
						rgba(0,0,123,0.4)

					`,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = $(".btn-view-cart-header").attr("href");
          }
        });
        var dataNew = JSON.parse(data);
        // console.log(dataNew);
        $(".header-cart-notice").text(dataNew.info.num_order);
        // console.log(Object.entries(dataNew.buy).length);
        if (Object.entries(dataNew.buy).length > 0) {
          if ($(".header-no-cart").length == 1) {
            $(".header-no-cart").remove();
            document.querySelector(
              ".header-cart-list"
            ).innerHTML = `<div class="header-has-cart"><span class="header__cart-heading">Sản phẩm thêm mới</span><ul class="header__cart-list-item"></ul></div>`;
          }
          var hasCart = document.querySelector(".header-has-cart");
          // hasCart.innerHTML = ''
          document.querySelector(".header__cart-list-item").innerHTML = "";
          for (const [key, value] of Object.entries(dataNew.buy)) {
            document.querySelector(
              ".header__cart-list-item"
            ).innerHTML += `<li class="header__cart-item"  data-id="${
              value.id
            }" >
						<img src="${PATH_IMG_PRODUCT}${value.image}" alt="" class="header__cart-img">
						<div class="header__cart-item-info">
							<div class="header__cart-item-head">
								<h5 class="header__cart-item-name">${value.name}</h5>
								<div class="header__cart-item-price-wrap">
									<span class="header__cart-item-price" name="qty[${id}]">${
              value.price.toLocaleString("de-DE") + "₫"
            }</span>
									<span class="header__cart-item-multiply">x</span>
									<span class="header__cart-item-qnt"  data-id="${id}" >${value.qty}</span>
								</div>
							</div>
		
						</div>
					</li>`;
          }
          hasCart.innerHTML += `<div class="footer-has-cart d-flex justify-content-end m-3"></div>`;
          document.querySelector(".footer-has-cart").innerHTML = "";
          if (dataNew.no_user != 1) {
            document.querySelector(
              ".footer-has-cart"
            ).innerHTML += `<a class="text-color-main outline-main fs-4 p-2 me-4" href="${PATH_ROOT}bill/show_bill">Đơn hàng của tôi</a>`;
          }
          document.querySelector(
            ".footer-has-cart"
          ).innerHTML += `<a class="btn-view-cart-header text-color-main outline-main fs-4 p-2" href="${PATH_ROOT}cart">Xem giỏ hàng</a>`;
        }
      },

      error: function (xhr, ajaxOptions, throwError) {
        alert(xhr.status);
        alert(throwError);
        console.log(throwError);
      },
    });
    e.preventDefault();
  });
});

// $(function () {
// 	$(".minus-icon__product").click(function (e) {
// 		console.log(1);
// 	})
// 	$(".plus-icon__product").click(function (e) {
// 		console.log(2);
// 	})
// })
$(document).ready(function () {
  // Thêm sự kiện click cho icon trừ
  $(".minus-icon__product").click(function () {
    let currentValue = parseInt($(".num-order").val());
    if (currentValue > parseInt($(".num-order").attr("min"))) {
      $(".num-order").val(currentValue - 1);
    }
  });

  // Thêm sự kiện click cho icon cộng
  $(".plus-icon__product").click(function () {
    let currentValue = parseInt($(".num-order").val());
    if (currentValue < parseInt($(".num-order").attr("max"))) {
      $(".num-order").val(currentValue + 1);
    }
  });
});
