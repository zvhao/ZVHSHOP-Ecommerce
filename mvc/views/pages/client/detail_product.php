<div class="grid wide">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= _WEB_ROOT . '/home' ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= _WEB_ROOT . '/product/show_product' ?>">Sản phẩm</a></li>
            <?php
            // show_array($data['nameCate']);
            ?>
            <li class="breadcrumb-item"><a href="<?= _WEB_ROOT . '/product/show_product?cate=' . $data['product']['cate_id'] ?>"><?php echo getNameCate($data['product']['cate_id'])['name'] ?></a></li>

            <li class="breadcrumb-item "><?= $data['product']['name'] ?></li>
        </ol>
    </nav>

    <div class="detail-product">
        <?php
        ?>
        <div class="info-product row">
            <div class="left-product col-lg-6 d-flex" data-aos="fade-right">
                <div thumbsSlider="" class="col-lg-3 left-product__thum swiper mySwiper">
                    <div class="swiper-wrapper d-flex">
                        <div class="swiper-slide swiper-slide-l">
                            <img class="w-100" style="width: 120px; height: 120px; max-width: 100%; object-fit: cover; object-position: center;" src="<?= _PATH_IMG_PRODUCT . $data['product']['image'] ?>" />
                        </div>
                        <?php
                        if (isset($data['img_product']) && $data['img_product'] != '') {
                            foreach ($data['img_product'] as $img_product) {
                        ?>
                                <div class="swiper-slide swiper-slide-l">
                                    <img class="w-100" style="width: 120px; height: 120px; max-width: 100%; object-fit: cover; object-position: center;" src="<?= _PATH_IMG_PRODUCT . $img_product['image'] ?>" />

                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="col-12 col-lg-9 swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide swiper-slide-r">
                            <img class="col w-100" style="width: 380px; height: 380px; max-width: 100%; object-fit: cover; object-position: center;" src="<?php echo _PATH_IMG_PRODUCT . $data['product']['image'] ?>" alt="">
                        </div>
                        <?php
                        if (isset($data['img_product']) && $data['img_product'] != '') {
                            foreach ($data['img_product'] as $item) {
                        ?>
                                <div class="swiper-slide swiper-slide-r">
                                    <img class="col w-100" style="width: 380px; height: 380px; max-width: 100%; object-fit: cover; object-position: center;" src="<?php echo _PATH_IMG_PRODUCT . $item['image'] ?>" alt="">

                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

            </div>
            <div class="right-product col-lg-6 p-3" data-aos="fade-left">

                <form class="form-add-to-cart" action="<?= _WEB_ROOT . '/cart/add_cart?id=' . $data['product']['id'] ?>" method="post">
                    <input type="hidden" name="id_pro" value="<?= $data['product']['id'] ?>">
                    <input type="hidden" name="id_user" value="<?php if (isset($_SESSION['user']['id'])) echo $_SESSION['user']['id'] ?>">
                    <p class="title-product"><?= $data['product']['name'] ?></p>
                    <div class="info-product-short d-none__mobile my-3">
                        <span>
                            <span class="me-3 text-color-main fs-3"><?= $data['avgRating'] ?></span>
                            <span class="icon-main text-center font-size-14 me-5">
                                <?= getRatingStarRound($data['avgRating']) ?>
                            </span>

                        </span>
                        <span class="home-product-item__favorite me-5">
                            <?php if ($data['liked'] == 1) {
                            ?>
                                <i class="icon-favorite fs-2 fa-solid fa-heart px-2"></i>
                            <?php
                            } else {
                            ?>
                                <i class="icon-favorite fs-2 fa-regular fa-heart px-2"></i>
                            <?php } ?>
                            <span class="fs-3"><span class="favorites"><?= $data['favorites'] ?></span> lượt thích</span>
                        </span>
                        <span class="fs-3 me-5"><span class="text-color-main"><?= $data['sold'] ?></span> đã bán</span>
                        <span class="fs-3"><span class="text-color-main"><?= $data['countComment'] ?></span> đánh giá</span>
                    </div>
                    <div class="d-none__desktop row">
                        <span class="col-6 ">
                            <span class="me-3 text-color-main fs-3"><?= $data['avgRating'] ?></span>
                            <span class="icon-main text-center font-size-14">
                                <?= getRatingStarRound($data['avgRating']) ?>
                            </span>

                        </span>
                        <span class="col-6 home-product-item__favorite">
                            <?php if ($data['liked'] == 1) {
                            ?>
                                <i class="icon-favorite fs-2 fa-solid fa-heart"></i>
                            <?php
                            } else {
                            ?>
                                <i class="icon-favorite fs-2 fa-regular fa-heart"></i>
                            <?php } ?>
                            <span class="fs-3"><span class="favorites"><?= $data['favorites'] ?></span> lượt thích</span>
                        </span>
                        <span class="col-6 fs-3"><span class="text-color-main"><?= $data['sold'] ?></span> đã bán</span>
                        <span class="col-6 fs-3"><span class="text-color-main"><?= $data['countComment'] ?></span> đánh giá</span>
                    </div>
                    <p class="price-product fs-1"><?php numberFormat($data['product']['price']) ?></p>
                    <div class="num-order-product">
                        <span>Số lượng:</span>
                        <span class="price-product__box">
                            <i class="fa-solid fa-minus minus-icon__product"></i>
                            <input type="number" name="num_order" value="1" min="1" max="<?= $data['product']['remaining'] ?>" class="num-order mb-3 ">
                            <i class="fa-solid fa-plus plus-icon__product"></i>
                        </span>
                        <span><?= $data['product']['remaining'] ?> sản phẩm có sẵn</span>
                        <p><input type="submit" name="add-to-cart" href="" title="" class="add-to-cart mt-3 me-3" value="Thêm vào giỏ hàng"></p>

                </form>
            </div>
        </div>




    </div>
    <div class="content-detail">
        <p class="mb-5 heading-detail-section">CHI TIẾT SẢN PHẨM</p>
        <div class="desc-short-product" style="height: auto; overflow: hidden;">
            <p><?= $data['product']['description'] ?></p>
        </div>
    </div>


    <div class="" style="text-align: center;margin: 20px 0 40px 0;">
        <button type="button" class="btn btn-outline-primary border-radius-main p-3" style="width: 100px; font-size: 1.4rem" id="btn1">Thu Gọn</button>
        <button type="button" class="btn btn-outline-primary border-radius-main p-3" style="width: 100px; font-size: 1.4rem" id="btn2">Xem thêm</button>
    </div>


    <div class="comment-detail-product">
        <p class="mb-5 heading-detail-section">ĐÁNH GIÁ SẢN PHẨM</p>
        <div class="row">
            <div class="col-8 col-lg-3 fs-2">
                <p class="mb-0 text-color-main text-center lh-1"><span class="avg-rating" style="font-size: 4rem;"><?= $data['avgRating'] ?></span> trên 5</p>
                <p class="icon-main text-center">
                    <?= getRatingStarRound($data['avgRating']) ?>
                </p>
            </div>
            <div class="col-4 col-lg-9 d-flex align-items-center">
                <span class="fs-3"><span class="text-color-main count-comment"><?= $data['countComment'] ?></span> đánh giá</span>

            </div>
            <hr>
        </div>
        <div class="comments p-3">

            <form action="<?= _WEB_ROOT . '/comment/add_comment' ?>" method="post" class="form-comment row">

                <div class="col-1">
                    <img class="rounded-circle" src="<?php if (!empty($_SESSION['user']['avatar'])) {
                                                            echo _PATH_AVATAR . $_SESSION['user']['avatar'];
                                                        } else echo _PATH_IMG_PUBLIC . '/profile.jpg'; ?>" alt="" style="width: 60px; height: 60px; max-width: 100%; object-fit: cover; object-position: center; margin-bottom: 5px;">

                </div>
                <fieldset class="col-11 font-size-14 mb-5" <?= $data['isBuy'] ?>>
                    <div class="icon-detail">
                        <span class="fs-4">Chất lượng sản phẩm:</span>
                        <div class="rating">
                            <label>
                                <input type="radio" name="stars" class="d-none" value="5" />
                                <i class="icon-rating text-color-main icon fa-star fa-solid"></i>

                                <i class="icon-rating text-color-main icon fa-star fa-solid"></i>

                                <i class="icon-rating text-color-main icon fa-star fa-solid"></i>

                                <i class="icon-rating text-color-main icon fa-star fa-solid"></i>

                                <i class="icon-rating text-color-main icon fa-star fa-solid"></i>

                            </label>
                        </div>
                    </div>
                    <div class="d-flex align-items-end">
                        <textarea name="comment" class="form-control w-75 me-5" rows="3" placeholder="<?php if (isset($_SESSION['msg_check_is_buy'])) echo $_SESSION['msg_check_is_buy'] ?>"></textarea>
                        <input type="hidden" name="id_user" value="<?= isset($_SESSION['user']) ? $_SESSION['user']['id'] : 0 ?>">
                        <input type="hidden" name="id_pro" value="<?= $data['product']['id'] ?>">
                        <button type="submit" name="btn_submit" class="btn btn-main border-radius-main py-3" style="width: 80px; font-size: 1.4rem" value="yes">GỬI</button>
                    </div>
                </fieldset>
            </form>

            <div class="table-comments">
                <?php
                if (isset($data['comments']) && $data['comments']) {
                    foreach ($data['comments'] as $item) {
                ?>
                        <div class="detail-comment">
                            <div class="row header-detail-comment">
                                <div class="col-1">
                                    <img class=" rounded-circle" src="<?php if (!empty($item['avatar'])) {
                                                                            echo _PATH_AVATAR . $item['avatar'];
                                                                        } else echo _PATH_IMG_PUBLIC . '/profile.jpg'; ?> ?> " alt="" style="width: 60px; height: 60px; max-width: 100%; object-fit: cover; object-position: center; margin-bottom: 5px;">
                                </div>
                                <div class="col-11 ">
                                    <span class="fs-3" style="white-space: nowrap;"><?= $item['name'] ?></span>
                                    <p class="icon-detail">
                                        <?php getRatingStar($item['rating']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row content-detail-comment font-size-14">
                                <div class="col-1"></div>
                                <div class="col-11">
                                    <p class="" style="color: #666"><?= $item['created_at'] ?></p>
                                    <p class=""><?= $item['comment'] ?></p>
                                </div>
                            </div>
                            <?php
                            if ($item['respond_content']) {
                            ?>
                                <div class="row reply-comment font-size-14 mt-4">
                                    <div class="col-1"></div>
                                    <div class="col-11 ps-5">
                                        <p class="text-color-main" style="color: #666">PHẢN HỒI TỪ ZVHSHOP</p>
                                        <p class="bg-form-control p-3"><?= $item['respond_content'] ?></p>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <hr>
                        </div>

                <?php
                    }
                }
                ?>

            </div>




        </div>

    </div>

</div>