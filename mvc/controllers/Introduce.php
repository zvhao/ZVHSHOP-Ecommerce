<?php

class Introduce extends Controller
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
        $detailCart= [];
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
        $products = $this->products->getAll('',0,$cate, '');
        

        $this->view("client", [
            'page' => 'introduce',
            'title' => 'Giới thiệu',
            'css' => ['base', 'main'],
            'js' => ['main'],
            'categories' => $categories,
            'products' => $products,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,
        ]);
    }
}
