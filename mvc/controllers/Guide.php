<?php

class Guide extends Controller
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

		return $this->view("client", [
			'page' => 'guide',
			'title' => 'Hướng dẫn',
			'css' => ['base', 'main'],
			'js' => ['main'],
			'categories' => $categories,
			'infoCart' => $infoCart,
            'detailCart' => $detailCart,


		]);
	}
}
