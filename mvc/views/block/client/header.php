<!-- header -->
<header class="header">
    <div class="grid wide">
        <div class="box-header">
            <div class="row align-items-center">
                <div class="header-left-mobile col-4">
                    <span class="box-icon icon-menu__mobile">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                    <span class="box-icon icon-search__mobile">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                </div>
                <div class="header-logo col-4 col-lg-2">
                    <a href="<?= _WEB_ROOT . '/home' ?>" class="logo-link text-center">
                        <img src="<?= _PATH_IMG_PUBLIC ?>logo-removebg.png" alt="" class="logo-img">
                    </a>
                </div>
                <div class="header-mid col-4 col-lg-8">
                    <div class="menu-top">
                        <ul class="list-top d-flex p-2 list-unstyled">
                            <li class="list-top-item header-hotline">
                                <i class="fa-solid fa-phone"></i>
                                <span class="font-weight-bold">HOTLINE:</span>
                                <a href="tel:0987123654">0987123654</a>
                            </li>
                            <li class="list-top-item header-search">
                                <form action="<?= _WEB_ROOT . '/product/show_product' ?>" method="GET" class="header-search-form input-group">
                                    <input type="text" class="input-search form-control" placeholder="Tìm sản phẩm..." name="search" required>
                                    <button class="btn-search btn" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>

                                    <!-- history search -->
                                    <div class="header-search-history">
                                        <h3 class="header-search-history-heading">TÌM KIẾM NHIỀU NHẤT</h3>
                                        <ul class="header-search-history-list">
                                            <li class="header-search-hisroty-item">
                                                <a href="http://localhost/ZVHSHOP/product/show_product?cate=1">Vợt cầu lông</a>
                                            </li>
                                            <li class="header-search-hisroty-item">
                                                <a href="">Quả cầu lông</a>
                                            </li>
                                            <li class="header-search-hisroty-item">
                                                <a href="">Quấn cán cầu lông</a>
                                            </li>
                                        </ul>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="header-right d-flex justify-content-center col-4 col-lg-2">
                    <div class="header-item header-account">
                        <a href="#" class="a-header-right header-account-link">
                            <span class="box-icon">
                                <?= avatarHeader() ?>

                            </span>
                            <span class="item-title text-uppercase"><?= isset($_SESSION['user']) ? getLastName($_SESSION['user']['name']) : 'TÀI KHOẢN' ?></span>
                            <ul class="header-account-option">
                                <?php
                                if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                                ?>
                                    <li class="option-select">
                                        <?php if ($_SESSION['user']['gr_id'] == 1) {
                                        ?>
                                            <a href="<?= _WEB_ROOT . '/admin' ?>" class="a-option d-flex m-0 justify-content-center">
                                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                                <span class="" style="white-space: nowrap;">TRANG QUẢN TRỊ</span>
                                            </a>

                                        <?php

                                        } else {
                                        ?>
                                            <a href="<?= _WEB_ROOT . '/user/profile' ?>" class="a-option d-flex m-0 justify-content-center">
                                                <i class="fa-solid fa-user-check"></i>
                                                <span class="" style="white-space: nowrap;">Hồ sơ</span>
                                            </a>
                                        <?php } ?>
                                    </li>
                                    <li class="option-select">
                                        <a class="a-option" href="<?= _WEB_ROOT . '/product/liked_product' ?>">
                                            <i class="fa-solid fa-heart"></i>
                                            Yêu thích</a>
                                    </li>
                                    <li class="option-select">
                                        <a class="a-option heading-regis" href="<?= _WEB_ROOT . '/Auth/logout' ?>">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                            Đăng xuất</a>
                                    </li>
                                <?php
                                } else {
                                ?>

                                    <li class="option-select">
                                        <a class="a-option " href="<?= _WEB_ROOT . '/Auth/login' ?>">
                                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                            Đăng nhập</a>
                                    </li>
                                    <li class="option-select">
                                        <a class="a-option heading-regis" href="<?= _WEB_ROOT . '/Auth/register' ?>">
                                            <i class="fa-solid fa-user-plus"></i>
                                            Đăng ký</a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </a>
                    </div>
                    <div class="header-item header-cart">
                        <a href="<?= _WEB_ROOT . '/cart' ?> " class="a-header-right header-cart-link">
                            <span class="box-icon">
                                <i class="fa-solid fa-cart-arrow-down"></i>
                            </span>
                            <span class="item-title">GIỎ HÀNG</span>

                            <span class="header-cart-notice">
                                <?php
                                if (isset($data['infoCart']) && $data['infoCart']) {
                                    echo $data['infoCart']['num_order'];
                                } else echo 0;
                                ?></span>


                        </a>
                        <div class="header-cart-list">
                            <?php
                            if (isset($data['detailCart']) && !empty($data['detailCart'])) {
                            ?>
                                <div class="header-has-cart">
                                    <span class="header__cart-heading">Sản phẩm thêm mới</span>

                                    <ul class="header__cart-list-item">
                                        <?php
                                        foreach ($data['detailCart'] as $item) {
                                        ?>

                                            <!-- cart -->
                                            <li class="header__cart-item" data-id="<?= $item['id'] ?>">
                                                <img src="<?= _PATH_IMG_PRODUCT . $item['image'] ?>" alt="" class="header__cart-img">
                                                <div class="header__cart-item-info">
                                                    <div class="header__cart-item-head">
                                                        <h5 class="header__cart-item-name"><?= $item['name'] ?></h5>
                                                        <div class="header__cart-item-price-wrap">
                                                            <span class="header__cart-item-price" name="qty[<?= $item['id'] ?>]"><?= numberFormat($item['price']) ?></span>
                                                            <span class="header__cart-item-multiply">x</span>
                                                            <span class="header__cart-item-qnt" data-id="<?= $item['id'] ?>"><?= $item['qty'] ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </li>



                                        <?php
                                        }
                                        ?>
                                    </ul>

                                    <div class="footer-has-cart d-flex justify-content-end m-3">
                                        <?php
                                        if (!empty($_SESSION['user']['gr_id'])) {
                                        ?>
                                            <a class="text-color-main outline-main fs-4 p-2 me-4" href="<?= _WEB_ROOT . '/bill/show_bill' ?>">Đơn hàng của tôi</a>
                                        <?php
                                        }
                                        ?>
                                        <a class="btn-view-cart-header text-color-main outline-main fs-4 p-2" href="<?= _WEB_ROOT . '/cart' ?>">Xem giỏ hàng</a>

                                    </div>

                                </div>


                            <?php

                            } else {

                            ?>
                                <!-- No cart .header-no-cart-->
                                <div class="header-no-cart">
                                    <img src="<?= _PATH_IMG_PUBLIC ?>no-cart.png" alt="" class="header-no-cart-img">
                                    <span class="header-no-cart-msg">
                                        Chưa có sản phẩm
                                    </span>
                                    <?php
                                    if (!empty($_SESSION['user']['gr_id'])) {
                                    ?>
                                        <div class="d-flex justify-content-center mb-3"><a class="outline-main p-3 fs-4" href="<?= _WEB_ROOT . '/bill/show_bill' ?>">ĐƠN HÀNG CỦA TÔI</a></div>
                                    <?php } ?>
                                </div>

                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- navbar -->
    <nav class="main-menu bg-main d-none__mobile">
        <div class="container">
            <ul class="nav-list list-unstyled d-flex justify-content-around">
                <li class="nav-item">
                    <a class="nav-link" href="<?= _WEB_ROOT . '/home' ?>">TRANG CHỦ</a>
                </li>
                <li class="nav-item header-has-menu-product">
                    <a class="nav-link <?php
                                        if ($data['page'] == 'product') echo 'active-header-nav' ?>" href="<?= _WEB_ROOT . '/product/show_product' ?>">SẢN PHẨM
                        <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <!-- menu-product -->
                    <div class="header-menu-product fadein-list">
                        <!-- <div class="header-menu-product-list"> -->
                        <ul class="">
                            <?php
                            foreach ($data['categories'] as $category) {
                            ?>
                                <li class=" ">
                                    <a class="header-heading-product" href="<?php echo _WEB_ROOT . '/product/show_product?cate=' . $category['id_cate'] ?>"><?= $category['name'] ?></a>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>
                        <!-- </div> -->
                    </div>

                </li>
                <li class="nav-item has-menu-guide">
                    <a class="nav-link <?php
                                        if ($data['page'] == 'guide') echo 'active-header-nav' ?>" href="<?= _WEB_ROOT . '/guide?post=1' ?>">HƯỚNG DẪN
                        <i class="fa-solid fa-angle-down"></i>
                    </a>

                    <div class="guide-list fadein-list">
                        <ul>
                            <li><a class="" href="<?= _WEB_ROOT . '/guide?post=1' ?>">Hướng dẫn chọn vợt cầu lông phù hợp</a></li>
                            <li><a class="" href="<?= _WEB_ROOT . '/guide?post=2' ?>">Hướng dẫn mua hàng và thanh toán</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link 
                        <?php
                        if ($data['page'] == 'introduce') echo 'active-header-nav' ?>" href="<?= _WEB_ROOT . '/introduce' ?>">GIỚI THIỆU</a></li>
                <li class="nav-item"><a class="nav-link 
                        <?php
                        if ($data['page'] == 'contact') echo 'active-header-nav' ?>" href="<?= _WEB_ROOT . '/contact' ?>">LIÊN HỆ</a></li>
            </ul>
        </div>
    </nav>


    <nav class="hidden "></nav>
</header>