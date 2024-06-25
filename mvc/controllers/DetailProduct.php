<?php

class DetailProduct extends Controller
{
    private  $products;
    private  $categories;
    private  $cart;
    private  $bills;
    private  $comment;
    function __construct()
    {
        $this->products = $this->model('ProductModel');
        $this->categories = $this->model('CategoryModel');
        $this->cart = $this->model('CartModel');
        $this->bills = $this->model('BillModel');
        $this->comment = $this->model('CommentModel');
    }

    function product($id)
    {

        $infoCart = [];
        $detailCart = [];
        $liked = 0;
        $sold =0;
        if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
            $id_user = $_SESSION['user']['id'];
            $detailCart = $this->cart->getAllDetailCart($id_user);
            $infoCart = $this->cart->SelectCart($id_user);
        }
        if (isset($_SESSION['cart']['buy'])) {
            $detailCart = $_SESSION['cart']['buy'];
            $infoCart = $this->cart->infoCart();
        }
        $product = $this->products->SelectProduct($id);
        $img_product = $this->products->SelectProductImg($id);
        $products = $this->products->getAll();
        $categories = $this->categories->getAllCl();
        // show_array($id);
        $nameCate = $this->categories->getNameCate($product['cate_id']);
        $avgRating = $this->products->getOneRating($id);
        $comments = $this->comment->getAllComment($id);
        $favorites = $this->products->countFavoritePro($id);
        $soldArr = $this->products->soldPro($id);
        $countComment = $this->comment->countComment($id);
        if($soldArr) {
            $sold = $soldArr['sold'];
        }  
        // show_array($sold);


        if (isset($_SESSION['user'])) {
            $likedPro = $this->products->checkLikedPro($id_user, $id);
            // show_array($likedPro);
            if ($likedPro) {
                $liked = 1;
            }
        }
        $commentsNew = [];
        foreach($comments as $comment) {
            if($this->comment->getOneComment($comment['id'])) {
                $comment['respond_content'] = $this->comment->getOneComment($comment['id'])['responded'];
            } else {
                $comment['respond_content'] = '';
            }
            array_push($commentsNew, $comment);
        }


        if (isset($_SESSION['user'])) {
            $boughtById = $this->bills->boughtById($_SESSION['user']['id'], $id);
            $evaluated = $this->comment->getComment($_SESSION['user']['id'], $id);
            // show_array($evaluated);
            if ($boughtById && empty($evaluated)) {
                $isBuy = '';
                $_SESSION['msg_check_is_buy'] = "Hãy chia sẻ những điều bạn thích về sản phẩm này với những người mua khác nhé.";
            } else if ($boughtById && $evaluated) {
                $isBuy = 'disabled';
                $_SESSION['msg_check_is_buy'] = "Bạn đã đánh giá.";
            } else {
                $isBuy = 'disabled';
                $_SESSION['msg_check_is_buy'] = "Chưa hoàn thành đơn hàng nào có sản phẩm này!";
            }
        } else {
            $isBuy = 'disabled';
            $_SESSION['msg_check_is_buy'] = "Vui lòng đăng nhập để được đánh giá!";
        }

        // show_array($avgRating);

        return $this->view("client", [
            'page' => 'detail_product',
            'title' => 'Chi tiết sản phẩm',
            'css' => ['base', 'main'],
            'js' => ['main', 'detail_product'],
            'products' => $products,
            'categories' => $categories,
            'product' => $product,
            'img_product' => $img_product,
            'nameCate' => $nameCate,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,
            'comments' => $commentsNew,
            'isBuy' => $isBuy,
            'avgRating' => $avgRating,
            'liked' => $liked,
            'favorites' => $favorites,
            'sold' => $sold,
            'countComment' => $countComment,

        ]);
    }

    function add_favorite()
    {
        if (isset($_POST['id_pro']) && isset($_SESSION['user']['id'])) {
            $id_pro = $_POST['id_pro'];
            $id_user = $_SESSION['user']['id'];
            $created_at = date('Y-m-d H:i:s');

            $status = $this->products->insertFavorite($id_user, $id_pro, $created_at);
        }
        if ($status) {
            echo json_encode($status);
        }
    }

    function delete_favorite()
    {
        if (isset($_POST['id_pro']) && isset($_SESSION['user']['id'])) {
            $id_pro = $_POST['id_pro'];
            $id_user = $_SESSION['user']['id'];
            $likedPro = $this->products->checkLikedPro($id_user, $id_pro);
            if ($likedPro) {
                $this->products->deleteFavorite($id_user, $id_pro);
                $status = 1;
            }
        }
        if ($status) {
            echo json_encode($status);
        }
    }
}
