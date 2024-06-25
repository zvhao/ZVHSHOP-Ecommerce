<?php
class Product extends Controller
{

    private  $bills;
    private  $cart;
    private  $categories;
    private  $comment;
    private  $products;
    private  $users;
    function __construct()
    {
        $this->bills = $this->model('BillModel');
        $this->cart = $this->model('CartModel');
        $this->categories = $this->model('CategoryModel');
        $this->comment = $this->model('CommentModel');
        $this->products = $this->model('ProductModel');
        $this->users = $this->model('UserModel');
    }

    function index()
    {
        $cate = 0;
        if (isset($_POST['cate'])) {

            $cate  = $_POST['cate'];
        }

        $categories = $this->categories->getAllCl();
        $productNew = [];

        $keyword = '';
        $cate = 0;
        if (isset($_GET['search'])) {
            $keyword = $_GET['search'];
            $cate = 0;
        } elseif (isset($_POST['cate'])) {

            $cate  = $_POST['cate'];
            $keyword = '';
        } elseif (isset($_GET['cate'])) {

            $cate  = $_GET['cate'];
            $keyword = '';
        }
        $products = $this->products->getAll($keyword, 0, $cate, '');

        $count_product = !empty($products) ? count($products) : 0;
        
        $num_per_page = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $num_per_page;
        $SelectProByPage = $this->products->SelectProByPage($start, $num_per_page, $keyword, 0, $cate, '');
        
        foreach ($SelectProByPage as $item) {
            if (!empty($this->products->soldPro($item['id']))) {
                $item['sold'] = $this->products->soldPro($item['id'])['sold'];
            } else $item['sold'] = 0;
            if (!empty($this->comment->countComment($item['id']))) {
                $item['countCmt'] = $this->comment->countComment($item['id']);
            } else $item['countCmt'] = 0;
            
            array_push($productNew, $item);
        }
        // show_array($productNew);
        return $this->view('admin', [
            'page' => 'product/list',
            'js' => ['deletedata', 'search'],
            'title' => 'SẢN PHẨM',
            'pagePag' => 'product',
            'products' => $products,
            'productNew' => $productNew,
            'categories' => $categories,
            'SelectProByPage' => $SelectProByPage,
            'keyword' => $keyword,
            'num_per_page' => $num_per_page,
            'cate' => $cate,
            'count_product' => $count_product,
            'keyword' => $keyword,

        ]);
    }

    function show_product()
    {
        $infoCart = [];
        $detailCart = [];
        $liked = 0;
        if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
            $id_user = $_SESSION['user']['id'];
            $detailCart = $this->cart->getAllDetailCart($id_user);
            $infoCart = $this->cart->SelectCart($id_user);
            // show_array($infoCart);
        }
        if (isset($_SESSION['cart']['buy'])) {
            $detailCart = $_SESSION['cart']['buy'];
            $infoCart = $this->cart->infoCart();
        }
        $cate = 0;
        if (isset($_GET['cate'])) {

            $cate  = $_GET['cate'];
        }

        $categories = $this->categories->getAllCl();
        $productNew = [];

        $keyword = '';
        $cate = 0;
        $price = '';
        if (isset($_GET['search'])) {
            $keyword = $_GET['search'];
            $cate = 0;
        } elseif (isset($_GET['cate'])) {

            $cate  = $_GET['cate'];
            $keyword = '';
        }
        if(isset($_GET['price'])) {
            $price = $_GET['price'];
        }
        $products = $this->products->getAll($keyword, 0, $cate, $price);


        $count_product = !empty($products) ? count($products) : 0;

        $num_per_page = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $num_per_page;
        $SelectProByPage = $this->products->SelectProByPage($start, $num_per_page, $keyword, 0, $cate, $price);
        // show_array($SelectProByPage);
        foreach ($SelectProByPage as $item) {
            $soldArr = $this->products->soldPro($item['id']);
            $item['sold'] = 0;
            $item['liked'] = 0;
            if ($soldArr) {
                $item['sold'] = $soldArr['sold'];
            }
            if (isset($_SESSION['user'])) {
                $likedPro = $this->products->checkLikedPro($id_user, $item['id']);
                // show_array($likedPro);
                if ($likedPro) {
                    $item['liked'] = 1;
                }
            }
            array_push($productNew, $item);
        }
        // show_array($productNew);
        return $this->view('client', [
            'page' => 'product',
            'css' => ['base', 'main'],
            'js' => ['main'],
            'title' => 'Sản phẩm',
            'products' => $products,
            'categories' => $categories,
            'SelectProByPage' => $productNew,
            'keyword' => $keyword,
            'num_per_page' => $num_per_page,
            'cate' => $cate,
            'count_product' => $count_product,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,
        ]);
    }

    function detail_product_admin($id) {
        $product = $this->products->SelectProduct($id);
        $img_product = $this->products->SelectProductImg($id);
        $products = $this->products->getAll();
        $categories = $this->categories->getAllCl();
        $nameCate = $this->categories->getNameCate($id);
        $avgRating = $this->products->getOneRating($id);
        $comments = $this->comment->getAllComment($id);
        $favorites = $this->products->countFavoritePro($id);
        $soldArr = $this->products->soldPro($id);
        $countComment = $this->comment->countComment($id);
        if($soldArr) {
            $sold = $soldArr['sold'];
        }  else $sold = 0;
        // show_array($sold);
        return $this->view('admin', [
            'page' => 'product/detail',
            'title' => 'CHI TIẾT SẢN PHẨM',
            'js' => ['comment'],
            'product' => $product,
            'products' => $products,
            'categories' => $categories,
            'product' => $product,
            'img_product' => $img_product,
            'nameCate' => $nameCate,
            'comments' => $comments,
            'avgRating' => $avgRating,
            'favorites' => $favorites,
            'sold' => $sold,
            'countComment' => $countComment,


        ]);
    }

    function liked_product()
    {
        $infoCart = [];
        $detailCart = [];
        if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
            $id_user = $_SESSION['user']['id'];
            $detailCart = $this->cart->getAllDetailCart($id_user);
            $infoCart = $this->cart->SelectCart($id_user);
            // show_array($infoCart);
        }
        if (isset($_SESSION['cart']['buy'])) {
            $detailCart = $_SESSION['cart']['buy'];
            $infoCart = $this->cart->infoCart();
        }

        $categories = $this->categories->getAllCl();

        $likedproduct = [];
        $likedproductNew = [];
        if (isset($_SESSION['user'])) {
            $id_user = $_SESSION['user']['id'];
            $getAllFavoriteByUser = $this->products->getAllFavoriteByUser($id_user);

            foreach ($getAllFavoriteByUser as $item) {
                $soldArr = $this->products->soldPro($item['id']);
                $item['sold'] = 0;
                $item['liked'] = 0;
                if ($soldArr) {
                    $item['sold'] = $soldArr['sold'];
                }
                $item['liked'] = 1;

                array_push($likedproductNew, $item);
            }
        }

        // show_array($likedproductNew);
        return $this->view('client', [
            'page' => 'liked_product',
            'css' => ['base', 'main'],
            'js' => ['main'],
            'title' => 'Sản phẩm yêu thích',
            'categories' => $categories,
            'likedproductNew' => $likedproductNew,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,

        ]);
    }

    function add_product()
    {
        $msg = '';
        $type = '';

        $categories = $this->categories->getAll();

        if (isset($_POST['add_product']) && ($_POST['add_product'])) {
            $image = $this->processImg($_FILES['product']['name'], $_FILES['product']['tmp_name']);
            $name = $_POST['productname'];
            $price = $_POST['price'];
            $remaining = $_POST['remaining'];
            $category = $_POST['category'];
            $desc = $_POST['description'];
            $detail_img = $_FILES['detail_image'];

            $created_at = date('Y-m-d H:i:s');
            $image_array = array();

            for ($i = 0; $i < count($detail_img['name']); $i++) {
                $img = $this->processImg($detail_img['name'][$i], $detail_img['tmp_name'][$i]);
                array_push($image_array, $img);
            }

            $idProduct = $this->products->insertPro($name, $image, $category, $price, $remaining, $desc, $created_at);
            if (!empty($image_array) && $image_array[0] != '') {
                foreach ($image_array as $name)
                    $this->products->addImageProduct($idProduct, $name, $created_at);
            }


            if ($idProduct) {
                $type = 'success';
                $msg = 'Added product successfully';
                $_SESSION['msg'] = $msg;
                header('Location: ' . _WEB_ROOT . '/product/list');
            } else {
                $type = 'danger';
                $msg = 'System error';
            }

            unset($_POST['add_product']);
        }
        return $this->view('admin', [
            'page' => 'product/add',
            'categories' => $categories,
            'msg' => $msg,
            'type' => $type,
            'title' => 'SẢN PHẨM',
            'js' => ['uploadImg']
        ]);
    }

    function update_product($id)
    {
        $msg = [];
        $type = [];

        $product = $this->products->SelectProduct($id);
        $productImg = $this->products->SelectProductImg($id);
        $categories = $this->categories->getAll();

        if (isset($_POST['update_product']) && ($_POST['update_product'])) {
            $image = "";
            $updated_at = date('Y-m-d H:i:s');
            $image_array = array();

            $name = $_POST['productname'];
            $price = $_POST['price'];
            $remaining = $_POST['remaining'];
            $category = $_POST['category'];
            $desc = $_POST['description'];

            $detail_img = $_FILES['detail_image'];

            if (!empty($detail_img))
                for ($i = 0; $i < count($detail_img['name']); $i++) {
                    $img = $this->processImg($detail_img['name'][$i], $detail_img['tmp_name'][$i]);
                    array_push($image_array, $img);
                }

            if (isset($_FILES['product']['name'])) {
                $image = $this->processImg($_FILES['product']['name'], $_FILES['product']['tmp_name']);
            }

            $status = $this->products->updateProduct($id, $name, $image, $category, $price, $remaining, $desc, $updated_at);
            // show_array($image_array);

            if (!empty($image_array['0'])) {
                $this->products->deleteImgPro($id);
                foreach ($image_array as $name) {
                    $this->products->addImageProduct($id, $name, $updated_at);
                }
            }

            if ($status) {
                $type = 'success';
                $msg = 'Updated product successfully';
                $_SESSION['msg'] = $msg;
                header('Location: ' . _WEB_ROOT . '/product/list');
            } else {
                $type = 'danger';
                $msg = 'System error';
            }

            unset($_POST['update_product']);
        }

        return $this->view('admin', [
            'page' => 'product/update',
            'product' => $product,
            'categories' => $categories,
            'productImg' => $productImg,
            'msg' => $msg,
            'type' => $type,
            'title' => 'SẢN PHẨM',
            'js' => ['uploadImg']
        ]);
    }

    function delete_product($id)
    {
        $this->products->deleteImgPro($id);
        $status = $this->products->deletePro($id);
        if ($status) echo -1;
        else echo -2;
    }



    function processImg($filesName, $tmpName)
    {
        if (isset($filesName) && !empty($filesName)) {
            $date = new DateTimeImmutable();
            $fileNameArr = explode(".", $filesName);
            $name = $date->getTimestamp() . random_int(100000000, 9999999999);
            $target_file = _UPLOAD . '/product/' .  basename($name . "." . $fileNameArr[1]);

            if (move_uploaded_file($tmpName, $target_file)) {
                return $name . "." . $fileNameArr[1];
            }
        }
    }
}
