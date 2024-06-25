<?php
class User extends Controller
{
    private  $bills;
    private  $cart;
    private  $categories;
    private  $comment;
    private  $products;
    private  $user;
    private  $group;
    public function __construct()
    {
        $this->group = $this->model("GroupUserModel");
        $this->user = $this->model("UserModel");
        $this->categories = $this->model('CategoryModel');
		$this->cart = $this->model('CartModel');

    }

    public function index()
    {
        $keyword = '';
        if (isset($_GET['search']) && ($_GET['search'] != '')) {
            $keyword = $_GET['search'];
        }

        $users = $this->user->getAll($keyword, 0, 0);
        // show_array($users);
        return $this->view('admin', [
            'page' => 'user/list',
            'title' => 'NGƯỜI DÙNG',
            'users' => $users,
            'js' => ['deletedata', 'search'],
            'keyword' => $keyword

        ]);
    }

    public function add_user()
    {
        $msg = '';
        $type = '';
        $groups = $this->group->getAll();
        if (isset($_POST['add_user']) && ($_POST['add_user'])) {
            $name = $_POST['username'];
            $avatar = $this->processImg();
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_DEFAULT);
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $group = $_POST['group'];
            $desc = $_POST['description'];

            $created_at = date('Y-m-d H:i:s');
            $users = $this->user->getAll();
            $check = 0;
            foreach ($users as $user) {
                if ($user['name'] == $name) {
                    $check = 1;
                    break;
                } else {
                    $check = 0;
                }
            }

            if ($check == 1) {
                $type = 'danger';
                $msg = 'User name already exists';
            } else {
                $status = $this->user->insert($name, $avatar, $group, $email, $password, $phone, $address, $desc, $created_at);
                if ($status) {
                    $type = 'success';
                    $msg = 'Added user successfully';
                    $_SESSION['msg'] = $msg;
                    header('Location: ' . _WEB_ROOT . '/user/list');
                } else {
                    $type = 'danger';
                    $msg = 'System error';
                }
            }
        }
        return $this->view('admin', [
            'page' => 'user/add',
            'groups' => $groups,
            'msg' => $msg,
            'type' => $type,
            'title' => 'NGƯỜI DÙNG',
            'js' => ['uploadImg']
        ]);
    }

    function processImg()
    {
        if (isset($_FILES['avatar'])) {
            $date = new DateTimeImmutable();
            $fileNameArr = explode(".", $_FILES['avatar']['name']);
            $target_file = _UPLOAD . '/avt/' .  basename($date->getTimestamp() . "." . $fileNameArr[1]);

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
                return $date->getTimestamp() . "." . $fileNameArr[1];
            }
        }
    }

    function update_user($id)
    {
        $user = $this->user->SelectUser($id);
        $groups = $this->group->getAll();
        if (isset($_POST['update_user']) && ($_POST['update_user'])) {

            $name = $_POST['username'];
            $avatar = $this->processImg();

            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $group = $_POST['group'];
            $desc = $_POST['description'];
            $updated_at = date('Y-m-d H:i:s');
            $users = $this->user->getAll('', $id, 0);
            $check = 0;

            $header = 0;

                $status = $this->user->updateUser($id, $name, $avatar, $group, $phone, $address, $desc, $updated_at);
                if ($status) {
                    $header = 1;
                    $type = 'success';
                    $msg = 'Update user successfully';
                } else {
                    $header = 0;
                    $type = 'danger';
                    $msg = 'System error';
                }


            if ($header === 0) {
                return $this->view('admin', [
                    'page' => 'user/update',
                    'user' => $user,
                    'msg' => $msg,
                    'type' => $type,
                    'title' => 'NGƯỜI DÙNG',
                    'js' => ['uploadImg']
                ]);
            } else {
                $_SESSION['msg'] = $msg;
                header('Location: ' . _WEB_ROOT . '/user/list');
                return;
            }
        }
        if (!empty($user)) {
            return $this->view('admin', [
                'page' => 'user/update',
                'user' => $user,
                'groups' => $groups,
                'title' => 'NGƯỜI DÙNG',
                'js' => ['uploadImg']
            ]);
        }
    }

    function delete_user($id)
    {
        $status = $this->user->deleteUser($id);
        if ($status) {
            echo -1;
        } else {
            echo -2;
        }
    }

    function profile()
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
        if (isset($_SESSION['user'])) {
            $email = $_SESSION['user']['email'];
            $user = $this->user->SelectOneUser($email);
        }
        $categories = $this->categories->getAllCl();

        // show_array($user);
        return $this->view('client', [
            'page' => 'profile',
            'title' => 'HỒ SƠ',
            'css' => ['base', 'main'],
            'js' => ['main', 'profile'],
            'user' => $user,
            'categories' => $categories,
            'infoCart' => $infoCart,
            'detailCart' => $detailCart,

        ]);
    }

    function update_profile()
    {
        if (isset($_POST['update_profile']) && isset($_SESSION['user']) && ($_POST['update_profile'])) {
            $id = $_SESSION['user']['id'];
            $name = $_POST['name'];
            $avatar = $this->processImg();
            // show_array($avatar);
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $desc = $_POST['desc'];
            $updated_at = date('Y-m-d H:i:s');

            $status = $this->user->updateProfile($id, $name, $avatar, $phone, $address, $desc, $updated_at);
            if (isset($_SESSION['user'])) {
                $_SESSION['user'] = $this->user->SelectUser($id);
            }

            if ($status) {
                $_SESSION['msg'] = "Cập nhật hồ sơ thành công!";
            } else {
                $_SESSION['msg'] = "Cập nhật hồ sơ thất bại";
            }
        }

        redirectTo('user/profile');
    }
}
