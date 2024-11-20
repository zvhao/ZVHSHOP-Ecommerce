<?php

class Contact extends Controller
{
    private  $bills;
    private  $cart;
    private  $categories;
    private  $comment;
    private  $products;
    private  $users;
    private  $contacts;
    function __construct()
    {
        $this->bills = $this->model('BillModel');
        $this->cart = $this->model('CartModel');
        $this->categories = $this->model('CategoryModel');
        $this->comment = $this->model('CommentModel');
        $this->products = $this->model('ProductModel');
        $this->users = $this->model('UserModel');
        $this->contacts = $this->model('ContactModel');
    }

    public function index()
    {
        $infoCart = [];
        $detailCart = [];
        $id_user = 0;
        $contacts = [];
        if (isset($_SESSION['user']) && $_SESSION['user']['id']) {
            $id_user = $_SESSION['user']['id'];
            $detailCart = $this->cart->getAllDetailCart($id_user);
            $infoCart = $this->cart->SelectCart($id_user);

            $contacts = $this->contacts->getAllContact('', '', $_SESSION['user']['email']);
            // show_array($contacts);
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




        $this->view("client", [
            'page' => 'contact',
            'title' => 'Liên hệ',
            'css' => ['base', 'main'],
            'js' => ['main', 'contact'],
            'categories' => $categories,
            'products' => $productNew,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,
            'contacts' => $contacts,
        ]);
    }

    public function admin()
    {
        $responded = 'NULL';
        $orderBy = '';

        if (isset($_GET['responded']) && $_GET['responded'] != '') {
            $responded = $_GET['responded'];
        }
        if (isset($_GET['order_by']) && $_GET['order_by'] != '') {
            $orderBy = $_GET['order_by'];
        }

        $contacts = $this->contacts->getAllContact($responded, $orderBy);



        return $this->view("admin", [
            'page' => 'contact/list',
            'title' => 'LIÊN HỆ',
            'js' => ['contact'],
            'contacts' => $contacts,
        ]);
    }

    public function send_contact()
    {
        if (isset($_POST['send_contact']) && $_POST['send_contact']) {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $content = $_POST['content'];
            $created_at = date("Y-m-d H:i:s");

            $status = $this->contacts->insertContact($name, $phone, $email, $content, $created_at);

            // // redirectTo('contact');
        }
    }

    public function respond()
    {
        if (isset($_POST['btn_respond']) && $_POST['respond'] != '') {
            $id_contact = $_POST['id_contact'];
            $email = $_POST['email'];
            $contentContact = $_POST['content'];
            $respond = $_POST['respond'];
            $name = $_POST['name'];



            $status = $this->contacts->respondContact($id_contact, $respond);
            if ($status) {

                $subject =  "ZVHSHOP phản hồi liên hệ";
                $content = "<p>Chào " . $name . "</p></br>";
                $content .= "<p>Cảm ơn bạn đã liên hệ với chúng tôi với nội dung: </p></br>";
                $content .= "<p>" . $contentContact . "</p></br></br>";
                $content .= "<p>Phản hồi từ quản trị viên:</p></br>";
                $content .= "<p>" . $respond . "</p></br></br>";
                $content .= "<p>Nếu có mọi thắc mắc, phản hồi nào cần ZVHSHOP giải đáp, vui lòng reply mail này.</p></br>";
                $content .= "<p>Trân trọng cảm ơn</p>";
                $statusMail = sendMail($email, $subject, $content);
                if ($statusMail) {
                    $checkLogin = true;

                    $message = 'Phản hồi thành công';
                    $type_contact = 'success';
                } else {
                    $checkLogin = false;
                    $type_contact = 'danger';
                    $message = 'Phản hồi thất bại thất bại';
                }
            } else {
                $message = 'Đã xảy ra sự cố với hệ thống, vui lòng thử lại sau';
                $checkLogin = false;
            }

            $_SESSION['msg_contact'] = $message;
            $_SESSION['type_contact'] = $type_contact;
            header('Location: ' . _WEB_ROOT . '/contact/admin');
        }
    }
}
