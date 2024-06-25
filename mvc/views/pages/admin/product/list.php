<a class="mb-2 btn btn-primary" href="<?php echo _WEB_ROOT . '/product/add_product' ?>">Thêm sản phẩm</a>

<div class="row w-100">
    <div class="col-4">
        <form class="" action="<?= _WEB_ROOT . '/product' ?>" method="POST">

            <select name="cate" class="custom-select mb-2">
                <option value="">Chọn danh mục sản phẩm....</option>
                <?php
                foreach ($data['categories'] as $category) {
                ?>
                    <option value="<?= $category['id_cate'] ?>" <?php if (isset($_POST['cate']) && $_POST['cate'] == $category['id_cate'] || isset($_GET['cate']) && $_GET['cate'] == $category['id_cate']) {
                                                                    echo 'selected';
                                                                } ?>><?= $category['name'] ?></option>
                <?php
                }
                ?>
            </select>

            <button type="submit" class="btn btn-outline-primary mb-3">Lọc danh mục</button>
        </form>
    </div>
    <div class="col-8">
        <form action="<?= _WEB_ROOT . '/product' ?>" method="get">
            <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm" name="search" value="<?= $data['keyword'] ?>">
        </form>
    </div>

</div>


<?php
if (!empty($_SESSION['msg'])) {
    echo '<div class="alert alert-success" id="toast-success">' . $_SESSION['msg'] . '</div>';
    $_SESSION['msg'] = '';
}
?>
<?php
if (!empty($data['products'])) {
    $count_product = count($data['products']);
?>
    <div class="d-flex justify-content-between">
        <h4>Số sản phẩm hiện có là <?= $count_product ?></h4>
        <?php
        getPagingAdmin($data['count_product'], $data['num_per_page'], $data['pagePag']);
        ?>

    </div>
    <table class="table table-striped table_product">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">TÊN SẢN PHẨM</th>
                <th scope="col">ẢNH</th>
                <th scope="col">DANH MỤC</th>
                <th scope="col">GIÁ</th>
                <th scope="col">PHỔ BIẾN</th>
                <th class="text-center" scope="col">THAO TÁC</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['productNew'] as $product) {
            ?>
                <tr>
                    <td class="align-middle" scope="row"><b><?php echo $product['id'] ?></b></td>
                    <td class="align-middle" style="width:150px; overflow: hidden; white-space: nowrap; text-overflow:ellipsis; margin: 0;"><?php echo $product['name'] ?></td>
                    <td class="align-middle"><img style="width: 70px; height: 70px; margin-top: 5px; max-width: 100%; object-fit: cover; object-position: center;" class="img-thumbnail" src="<?php echo _PATH_IMG_PRODUCT . $product['image'] ?>" width="60px"></td>
                    <td class="align-middle"><?php echo getNameCate($product['cate_id'])['name'] ?></td>
                    <td class="align-middle">
                        <span class=""><?php echo  numberFormat($product['price']) ?></span>
                    </td>
                    <td class="align-middle">
                        <p class="m-0"><?= $product['total_rating']. ' sao' ?></p>
                        <p class="m-0"><?= $product['sold']. ' đã bán' ?></p>
                        <p class="m-0">còn lại <span class="text-primary"><?= $product['remaining'] ?></span></p>
                        <p class="m-0"><?= $product['countCmt']. ' đánh giá' ?></p>
                       
                </td>
                    <td class="align-middle text-center">
                        <a class="btn btn-primary btn-detail-bill mr-2" href="<?php echo _WEB_ROOT . '/product/detail_product_admin/' . $product['id'] ?>" data-id="<?= $product['id'] ?>">Xem</a>
                        <a class="btn btn-outline-primary mr-2" href="<?php echo _WEB_ROOT . '/product/update_product/' . $product['id'] ?>">
                            <i class="far fa-edit"></i>
                        </a>
                        <a class="btn btn-outline-danger delete_product handle_delete" href="<?php echo _WEB_ROOT . '/product/delete_product/' . $product['id'] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="8" class="text-center">KHÔNG CÓ DỮ LIỆU</td>
            </tr>
        <?php
        }
        ?>
        </tbody>

    </table>


    <?php
