<?php

class Home extends Controller
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

    public function index()
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
        $cate = 0;
        $products = $this->products->getAll('', 0, $cate ,'');

        $cate_id = 0;

        $getProductByCate = $this->products->getProductByCate($cate_id);

        $productNew = [];
        foreach ($getProductByCate as $item) {
            $soldArr = $this->products->soldPro($item['id']);            
            $item['sold'] = 0;
            $item['liked'] = 0;
            if($soldArr) {
                $item['sold'] = $soldArr['sold'];
            }
            if (isset($_SESSION['user'])) {
                $likedPro = $this->products->checkLikedPro($id_user, $item['id']);
                // show_array($likedPro);
                if ($likedPro) {
                    $item['liked'] = 1;
                }
            }
        //     if (!empty($this->products->getProImg($item['id']))) {
        //         $item['detail_img'] = $this->products->getProImg($item['id'])['image'];
        //     }
            array_push($productNew, $item);
        }




        // show_array($infoCart);
        $this->view("client", [
            'page' => 'home',
            'title' => 'Trang chủ',
            'css' => ['base', 'main'],
            'js' => ['main'],
            'categories' => $categories,
            'productNew' => $productNew,
            'cate_id' => $cate_id,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,


        ]);
    }
}
