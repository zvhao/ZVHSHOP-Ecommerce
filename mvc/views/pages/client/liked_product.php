<?php
if (!isset($_SESSION['user'])) {
	redirectTo('');
}

?>

<div class="grid wide">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= _WEB_ROOT ?>">Trang chủ</a></li>

            <li class="breadcrumb-item ">
                <?php
                if (isset($_GET['cate']) || isset($_GET['search'])) {
                ?>
                    <a href="<?= _WEB_ROOT . '/product/show_product' ?>"><?= $data['title'] ?></a>
                <?php
                } else echo $data['title']
                ?>
            </li>
            <?php
            if (isset($_GET['cate'])) {
            ?>
                <li class="breadcrumb-item ">
                    <?= getNameCate($_GET['cate'])['name'] ?>
                </li>
            <?php
            }
            ?>
            <?php
            if (isset($_GET['search'])) {
            ?>
                <li class="breadcrumb-item ">
                    <?= $_GET['search'] ?>
                </li>
            <?php

            } ?>
        </ol>
    </nav>


    <div id="" class="product-main d-flex flex-wrap">
        <?php
        if (!empty($data['likedproductNew'])) {
            foreach ($data['likedproductNew'] as $item) {

        ?>
                <div class="product-item col-6 col-lg-3 ">
                    <a href="<?= _WEB_ROOT . '/detailproduct/product/' . $item['id'] ?>" class="home-product-item">
                        <div class="pro-product-item__img">
                            <img src="<?= _PATH_IMG_PRODUCT . $item['image'] ?>" alt="" srcset="">
                        </div>
                        <div class="home-product-item-body">
                            <h4 class="home-product-item__name"><?= $item['name'] ?></h4>
                            <div class="d-flex justify-content-between">

                                <span class="home-product-item__price-current"><?= numberFormat($item['price']) ?></span>
                                <span style="font-size: 16px;" class="home-product-item__favorite">
                                                            <i class="<?= $item['liked'] == 1?'fa-solid':'fa-regular' ?> fa-heart"></i>
                                                        </span>
                            </div>
                            <div style="font-size: 14px;" class="home-product-item__action">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="home-product-item__rating">
                                                            <?= getRatingStarRound($item['total_rating']) ?>
                                                            </div>
                                                            <div class="home-product-item__sold">Đã bán <?= $item['sold'] ?></div>
                                                        </div>
                                                    </div>

                        </div>
                    </a>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="text-center p-5 w-100">
                <span class="alert text-center">Không có sản phẩm bạn đang tìm kiếm, vui lòng nhập lại!</span>

            </div>
        <?php
        }
        ?>

    </div>





</div>