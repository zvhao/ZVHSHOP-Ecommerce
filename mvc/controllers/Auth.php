<?php

class Auth extends Controller
{

    private  $products;
    private  $categories;
    private  $users;
    private  $cart;

    function __construct()
    {
        $this->products = $this->model('ProductModel');
        $this->categories = $this->model('CategoryModel');
        $this->users = $this->model('UserModel');
        $this->cart = $this->model('CartModel');
    }

    public function login()
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
            if (!empty($this->products->getProImg($item['id']))) {
                $item['detail_img'] = $this->products->getProImg($item['id'])['image'];
            }
            array_push($productNew, $item);
        }

        $this->view("client", [
            'page' => 'login',
            'title' => 'Tài khoản',
            'css' => ['base', 'main'],
            'js' => ['main', 'jquery.validate', 'form_validate'],
            'categories' => $categories,
            'products' => $productNew,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,

        ]);
    }

    public function register()
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
            if (!empty($this->products->getProImg($item['id']))) {
                $item['detail_img'] = $this->products->getProImg($item['id'])['image'];
            }
            array_push($productNew, $item);
        }
        $this->view("client", [
            'page' => 'register',
            'title' => 'Đăng ký',
            'css' => ['base', 'main'],
            'js' => ['main', 'jquery.validate', 'form_validate'],
            'categories' => $categories,
            'products' => $productNew,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,

        ]);
    }

    function handleRegister()
    {

        if (isset($_POST['register']) && $_POST['register'] != '') {
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $created_at = date('Y-m-d H:i:s');
            $users = $this->users->getAll('', 0, 0);
            $checkEmail = false;
            $message = '';
            if (!empty($users)) {
                foreach ($users as $user) {
                    if ($user['email'] == $email) {
                        $checkEmail = true;
                        break;
                    }
                }
            } else {
                $checkEmail = false;
            }
            $checkLogin = false;
            if ($checkEmail) {
                $message = 'Email đã tồn tại!';
                $checkLogin = false;
                $_SESSION['msg'] = $message;
            } else {
                if ($password === $confirm_password) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $status = $this->users->InsertUser($name, $email, $password, $tel, $created_at);

                    $userNew = $this->users->SelectOneUser($email);
                    $id_user = $userNew['id'];
                    $this->cart->insertCart($id_user, 0, 0, $created_at);

                    if ($status) {

                        $emailHash = password_hash($email, PASSWORD_DEFAULT);
                        $linkActive = _WEB_ROOT . '/auth/verify_email/?email=' . $email . "&accessEmail=" . $emailHash;

                        $subject =  $name . ' vui lòng kích hoạt tài khoản';
                        $content = '<p>Chào ' . $name . '</p></br>';
                        $content .= '<p>Vui lòng click vào nút dưới đây để kích hoạt tài khoản: </p>';
                        $content .= "<p><a href='$linkActive'><button>KÍCH HOẠT TÀI KHOẢN</button></a></p></br>";
                        $content .= 'Trân trọng cảm ơn';
                        $statusMail = sendMail($email, $subject, $content);
                        if ($statusMail) {
                            $checkLogin = true;

                            $message = 'Đăng ký tài khoản thành công, vui lòng kiểm tra email: ' . $email . ' để xác thực';
                        } else {
                            $checkLogin = false;

                            $message = 'Gửi mail xác thực thất bại';
                        }
                    } else {
                        $message = 'Đã xảy ra sự cố với hệ thống, vui lòng thử lại sau';
                        $checkLogin = false;
                    }
                } else {
                    $message = 'Mật khẩu không đúng!';
                    $checkLogin = 0;
                }
            }


            if ($checkLogin) {
                $_SESSION['msg'] = $message;
                header('Location: ' . _WEB_ROOT . '/Auth/login');
            } else {

                header('Location: ' . _WEB_ROOT . '/Auth/register');
            }
        }
    }

    function handleLogin()
    {
        if (isset($_POST['login']) && $_POST['login']) {

            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->users->SelectOneUser($email);
            $message = '';

            if (!empty($user)) {
                if (password_verify($password, $user['password'])) {

                    if (!empty($user['email_verify'])) {
                        $_SESSION['user'] = $user;
                        if ((int)$user['gr_id'] ==  1) {
                            header('Location: ' . _WEB_ROOT . '/admin');
                        } else {
                            header('Location: ' . _WEB_ROOT . '/home');
                            unset($_SESSION['cart']);
                        }
                    } else {
                        $_SESSION['msglg'] = 'Vui lòng xác thực tài khoản!';
                        $_SESSION['typelg'] = 'danger';

                        header('Location: ' . _WEB_ROOT . '/Auth/login');
                    }
                } else {
                    $_SESSION['msglg'] = 'Mật khẩu không đúng';
                    $_SESSION['typelg'] = 'danger';

                    header('Location: ' . _WEB_ROOT . '/Auth/login');
                }
            } else {
                $_SESSION['msglg'] = 'Email không chính xác';
                $_SESSION['typelg'] = 'danger';

                header('Location: ' . _WEB_ROOT . '/Auth/login');
            }
        }
    }

    function logout()
    {
        unset($_SESSION['user']);
        header('Location: ' . _WEB_ROOT . '/Auth/login');
    }

    function enterEmail()
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
        $this->view("client", [
            'page' => 'enter_email',
            'title' => 'Kiểm tra tài khoản',
            'css' => ['base', 'main'],
            'js' => ['main', 'jquery.validate', 'form_validate'],
            'categories' => $categories,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,

        ]);
    }

    function checkEmail()
    {
        if (isset($_POST['email']) && $_POST['email']) {
            $email = $_POST['email'];
            $users = $this->users->getAll('', 0, 0);
            $checkEmail = false;
            $message = '';
            $fullName = '';
            if (!empty($users)) {
                foreach ($users as $user) {
                    if ($user['email'] == $email) {
                        $fullName = $user['name'];
                        $checkEmail = true;
                        break;
                    }
                }
            } else {
                $checkEmail = false;
            }

            if ($checkEmail) {
                $_SESSION['msg_true_email'] = "Bạn vui lòng check mail vừa được gửi tới gmail: $email";

                $emailHash = password_hash($email, PASSWORD_DEFAULT);
                $linkActive = _WEB_ROOT . '/auth/treatment_email/?email=' . $email . "&accessEmail=" . $emailHash;
                $linkContact = _WEB_ROOT . '/contact';

                $subject = 'Thay đổi mật khẩu';
                $content = '<p>Chào ' . $fullName . '</p></br>';
                $content .= '<p>Vui lòng click vào nút dưới đây để thay đổi mật khẩu: </p>';
                $content .= "<p><a href='$linkActive'><button>THAY ĐỔI MẬT KHẨU</button></a></p></br>";
                $content .= '<p>Nếu bạn không yêu cầu thay đổi mật khẩu, vui lòng bỏ qua mail này hoặc liên hệ ngay với chúng tôi qua link: ' . $linkContact . '</p>';

                $content .= '<p>Trân trọng cảm ơn</p>';
                $statusMail = sendMail($email, $subject, $content);
                if ($statusMail) {
                    $checkLogin = true;

                    $message = 'Đăng ký tài khoản thành công';
                } else {
                    $checkLogin = false;

                    $message = 'Gửi mail xác thực thất bại';
                }

                header('Location: ' . _WEB_ROOT . '/Auth/enterEmail');
            } else {
                $_SESSION['msg_false_email'] = "Email không thuộc tài khoản nào! Vui lòng nhập lại!";
                header('Location: ' . _WEB_ROOT . '/Auth/enterEmail');
            }
        }
    }



    function changePassword()
    {
        $email = $_GET['email'];
        $emailAccess = $_GET['accessEmail'];
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

        $this->view("client", [
            'page' => 'change_password',
            'title' => 'Thay đổi mật khẩu',
            'css' => ['base', 'main'],
            'js' => ['main', 'jquery.validate', 'form_validate'],
            'email' => $email,
            'emailAccess' => $emailAccess,
            'categories' => $categories,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,
        ]);
    }

    function verify_email()
    {
        $email = $_GET['email'];
        $emailAccess = $_GET['accessEmail'];
        if (password_verify($email, $emailAccess)) {
            $statusVerify =  $this->users->verifyEmail($email);
            $_SESSION['msglg'] = 'Xác thực thành công bạn có thể đăng nhâp ngay bay giờ';
            $_SESSION['typelg'] = 'success';
            header('Location: ' . _WEB_ROOT . '/Auth/login');
        } else {
            $_SESSION['msglg'] = 'Xác thực thất bại';
            $_SESSION['typelg'] = 'danger';
            header('Location: ' . _WEB_ROOT . '/Auth/register');
        }
    }

    function treatment_email()
    {
        $email = $_GET['email'];
        $emailAccess = $_GET['accessEmail'];
        if (password_verify($email, $emailAccess)) {

            header('Location: ' . _WEB_ROOT . "/Auth/changePassword?email=$email&accessEmail=$emailAccess");
        } else {
            $_SESSION['msg_false'] = 'Xác thực thất bại';
            $_SESSION['type_false'] = 'danger';
            header('Location: ' . _WEB_ROOT . '/Auth/enterEmail');
        }
    }

    function treatment_password()
    {
        if (isset($_POST['btn-submit'])) {
            $email = $_POST['email'];
            $emailAccess = $_POST['accessEmail'];
            if (password_verify($email, $emailAccess)) {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                if ($password === $confirm_password) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $status = $this->users->updatePassword($email, $password);
                    $_SESSION['msg'] = 'Thay đổi mật khẩu thành công, bạn có thể đăng nhập bằng mật khẩu mới';
                    if (isset($_SESSION['user'])) {
                        unset($_SESSION['user']);
                    }
                    header('Location: ' . _WEB_ROOT . "/Auth/login");
                } else {
                    $_SESSION['msg_false'] = 'Vui lòng nhập lại mật khẩu khác ';
                    $_SESSION['type_false'] = 'danger';
                    header('Location: ' . _WEB_ROOT . "/Auth/changePassword?email=$email&accessEmail=$emailAccess");
                }
            } else {
                $_SESSION['msg_false'] = 'Cập nhật thất bại, vui lòng lặp lại các bước!';
                $_SESSION['type_false'] = 'danger';
                header('Location: ' . _WEB_ROOT . '/Auth/enterEmail');
            }
        }
    }
}
