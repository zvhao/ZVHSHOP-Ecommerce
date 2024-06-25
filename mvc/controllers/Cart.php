<?php

class Cart extends Controller
{
	private BillModel $bills;
	private CartModel $cart;
	private CategoryModel $categories;
	private CommentModel $comment;
	private ProductModel $products;
	private UserModel $users;
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
        $products = $this->products->getAll('', 0, $cate, '');

        $productNew = [];
        foreach ($products as $item) {
            // $item['detail_img'] = $this->products->getProImg($item['id'])['image'];
            array_push($productNew, $item);
        }



        // show_array($_SESSION);

        $this->view("client", [
            'page' => 'cart',
            'title' => 'Giỏ hàng',
            'css' => ['base', 'main'],
            'js' => ['main', 'cart'],
            'categories' => $categories,
            'products' => $productNew,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,
        ]);
    }


    public function add_cart()
    {
        $qty = 0;
        $id = 0;
        $num_order = 0;
        $total = 0;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (isset($_POST['add_to_cart']) && isset($_SESSION['cart']['buy'][$id])) {
            $qty = $_POST['num_order'] + $_SESSION['cart']['buy'][$id]['qty'];
        } else if (isset($_POST['add_to_cart'])) {
            $qty = $_POST['num_order'];
        }

        $select = "SELECT * FROM products WHERE id = '$id'";

        $product = $this->products->pdo_query_one($select);

        $id_pro = $product['id'];
        $image = $product['image'];
        $name = $product['name'];
        $price = $product['price'];
        $remaining = $product['remaining'];
        $dated_at = date('Y-m-d H:i:s');
        $sub_total = $product['price'] * $qty;

        if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
            $id_user = $_SESSION['user']['id'];
            $cart = $this->cart->SelectCart($id_user);
            $id_cart = $cart['id'];
            // show_array($_POST);

            $detail_cart = $this->cart->getDetailCart(0, $id_cart, $id_pro);

            if (isset($_POST['num_order']) && $detail_cart) {
                $qty = $_POST['num_order'] + $detail_cart[0]['qty'];
                // show_array($detail_cart);
                $price = $detail_cart[0]['price'];
                $sub_total = $price * $qty;
                if ($detail_cart[0]['id'] > 0) {
                    $this->cart->updateDetailCart($detail_cart[0]['id'], $qty, $sub_total);
                }
            } else if (isset($_POST['num_order'])) {
                $qty = $_POST['num_order'];
                $sub_total = $price * $qty;
                $this->cart->insertDetailCart($id_cart, $id_pro, $image, $name, $price, $remaining, $qty, $sub_total, $dated_at);
            }
            $detailCart = $this->cart->getAllDetailCart($id_user);

            foreach ($detailCart as $item) {
                $num_order += $item['qty'];
                $total += $item['sub_total'];
            }
            $this->cart->updateCart($id_user, $num_order, $total);
            $data = array(
                'info' => array(
                    'num_order' => $num_order,
                    'total' => $total,
                ),
                'no_user' => 0,
                'buy' => $detailCart,
            );
            print_r(json_encode($data));            
        } else {
            $_SESSION['cart']['buy'][$id] = array(
                'id' => $product['id'],
                'image' => $product['image'],
                'name' => $product['name'],
                'price' => $product['price'],
                'remaining' => $product['remaining'],
                'qty' => $qty,
                'dated_at' => date('Y-m-d H:i:s'),
                'sub_total' => $product['price'] * $qty,
            );
            foreach ($_SESSION['cart']['buy'] as $item) {
                $num_order += $item['qty'];
                $total += $item['sub_total'];
            }

            $_SESSION['cart']['info'] = array(
                'num_order' => $num_order,
                'total' => $total,
            );
            $_SESSION['cart']['no_user'] = 1;
            $data = array(
                'image' => $product['image'],
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => $qty,
                'num_order' => $num_order,
                'total' => $total,
            );
            print_r(json_encode($_SESSION['cart']));
        }


        // $this->update_cart();

        // redirectTo('cart');
    }

    public function update_cart()
    {
        if (isset($_SESSION['cart'])) {
            $num_order = 0;
            $total = 0;

            foreach ($_SESSION['cart']['buy'] as $item) {
                $num_order += $item['qty'];
                $total += $item['sub_total'];
            }

            $_SESSION['cart']['info'] = array(
                'num_order' => $num_order,
                'total' => $total,
            );
        }

        if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
            $id_user = $_SESSION['user']['id'];
            $num_order = 0;
            $total = 0;
            $detailCart = $this->cart->getAllDetailCart($id_user);
            foreach ($detailCart as $item) {
                $num_order += $item['qty'];
                $total += $item['sub_total'];
            }
            $this->cart->updateCart($id_user, $num_order, $total);

            print_r($total);
        }
        $data = array(
            'num_order' => $num_order,
            'total' => $total,
        );
        print_r(json_encode($data));
    }



    public function update()
    {
        if (isset($_SESSION['cart']) && isset($_POST['qty'])) {
            $id = $_POST['id'];
            $qty = $_POST['qty'];
            $product = $this->products->SelectProduct($id);
            $_SESSION['cart']['buy'][$id]['qty'] = $qty;
            $_SESSION['cart']['buy'][$id]['sub_total'] = $qty * $product['price'];
            $num_order = 0;
            $total = 0;

            foreach ($_SESSION['cart']['buy'] as $item) {
                $num_order += $item['qty'];
                $total += $item['sub_total'];
            }

            $_SESSION['cart']['info'] = array(
                'num_order' => $num_order,
                'total' => $total,
            );
            $sub_total = $_SESSION['cart']['buy'][$id]['sub_total'];
        }

        if (isset($_SESSION['user']) && isset($_POST['qty']) && isset($_POST['id'])) {
            $detailCart = $this->cart->getOneDetailCart($_POST['id']);
            $price = $detailCart['price'];
            $sub_total = $_POST['qty'] * $price;
            $this->cart->updateDetailCart($_POST['id'], $_POST['qty'], $sub_total);
            // $this->update_cart();
            if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
                $id_user = $_SESSION['user']['id'];
                $num_order = 0;
                $total = 0;
                $detailCart = $this->cart->getAllDetailCart($id_user);
                foreach ($detailCart as $item) {
                    $num_order += $item['qty'];
                    $total += $item['sub_total'];
                }
                $this->cart->updateCart($id_user, $num_order, $total);
            }
        }
        $total = array(
            'qty' => $_POST['qty'],
            'num_order' => $num_order,
            'sub_total' => $sub_total,
            'total' => $total,

        );
        print_r(Json_encode($total));

        // redirectTo('cart');
        // }
    }


    public function delete_cart()
    {
        $id = 0;
        $checkEmpty = 0;
        $check_user = 0;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (isset($_SESSION['cart'])) {
            if (!empty($id)) {
                unset($_SESSION['cart']['buy'][$id]);
                $num_order = 0;
                $total = 0;
                foreach ($_SESSION['cart']['buy'] as $item) {
                    $num_order += $item['qty'];
                    $total += $item['sub_total'];
                }

                $_SESSION['cart']['info'] = array(
                    'num_order' => $num_order,
                    'total' => $total,
                );
            }
            if (!empty($id) && empty($_SESSION['cart']['buy'])) {
                unset($_SESSION['cart']);
                $checkEmpty = 1;
                $num_order = 0;
                $total = 0;
            }
        }
        if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
            $detail_cart = $this->cart->getDetailCart($id, 0, 0);
            if (isset($detail_cart) && !empty($detail_cart)) {
                // show_array($detail_cart);
                $this->cart->deleteDetailCart($id, 0);
            }
            $id_user = $_SESSION['user']['id'];
            $num_order = 0;
            $total = 0;

            $detailCart = $this->cart->getAllDetailCart($id_user);
            if (empty($detailCart)) {
                $checkEmpty = 1;
            }
            foreach ($detailCart as $item) {
                $num_order += $item['qty'];
                $total += $item['sub_total'];
            }
            $this->cart->updateCart($id_user, $num_order, $total);
            $check_user = 1;
        }
        $data = array(
            'check_user' => $check_user,
            'checkEmpty' => $checkEmpty,
            'num_order' => $num_order,
            'total' => $total,
        );
        print_r(json_encode($data));


        // $this->update_cart();

        // redirectTo('cart');
    }
}
