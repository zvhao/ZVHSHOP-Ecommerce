<?php

class Statistical extends Controller
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
        $dateStart = date("Y-m") . '-01 00:00:01';
        $dateEnd = date("Y-m-d H:i:s");
        // $id = 0;
        $lastMonth = date("Y-m", strtotime('-1 month', strtotime(date('Y-m'))));

        $statisticalBillByMonth = $this->bills->getBillByMonth($lastMonth);
        $bestSellerByMonth = $this->bills->bestSellerByMonth($lastMonth);

        $statisticalBillByCurrentMonth = $this->bills->getBillByMonth(date("Y-m"));
        $bestSellerByCurrentMonth = $this->bills->bestSellerByMonth(date("Y-m"));



        // show_array($bestSellerByMonth);

        if (isset($_POST['btn-statistical'])) {
            if (empty($_POST['date_start']) || empty($_POST['date_end'])) {
                $_SESSION['msg'] = 'Vui lòng nhập ngày!';
            } else if ($_POST['date_start'] > date("Y-m-d") || $_POST['date_end'] > date("Y-m-d")) {
                $_SESSION['msg'] = 'Vui lòng nhập ngày không lớn hơn ngày hiện tại!';
            } else if (strtotime($_POST['date_start']) > strtotime($_POST['date_end'])) {
                $_SESSION['msg'] = 'Vui lòng nhập ngày bắt đầu nhỏ hơn ngày kết thúc!';
            } else {
                $dateStart = $_POST['date_start'];
                if ($_POST['date_end'] == date("Y-m-d"))
                    $dateEnd = date("Y-m-d H:i:s");
                else $dateEnd = $_POST['date_end'];
                unset($_SESSION['msg']);
            }
        }

        if (isset($_POST['btn-last-month'])) {
            $_POST['date_start'] = $lastMonth . '-01';
            $dateStart = $_POST['date_start'];
            $_POST['date_end'] = date("Y-m-t", strtotime($_POST['date_start']));
            $dateEnd = $_POST['date_end'] . ' 23:59:59';
        }
        if (isset($_POST['btn-current-month'])) {
            $_POST['date_start'] =  date("Y-m") . '-01';
            $dateStart = $_POST['date_start'];
            $_POST['date_end'] = date("Y-m-d");
            $dateEnd = date("Y-m-d H:i:s");
        }

        // $id = $_SESSION['idDetailBill'];

        $sumBillStatistical = $this->bills->sumBillStatistical($dateStart, $dateEnd);
        $countBillStatistical = $this->bills->countBillStatistical($dateStart, $dateEnd);
        $BillStatistical = $this->bills->BillStatistical($dateStart, $dateEnd);


        $billsNew = [];
        foreach ($BillStatistical as $bill) {
            $bill['detail'] = $this->bills->getDetailBill($bill['id']);
            if ($bill['user_id'] > 0) {
                $bill['email_user'] = $this->users->SelectUser($bill['user_id'])['email'];
                $bill['name_user'] = $this->users->SelectUser($bill['user_id'])['name'];
            } else {
                $bill['email_user'] = '';
                $bill['name_user'] = '';
                $bill['user_id'] = 'Không có tài khoản';
            }
            array_push($billsNew, $bill);
        }

        // show_array($detailBillStatistical);


        return $this->view('admin', [
            'title' => 'THỐNG KÊ DOANH THU',
            'page' => 'manager/statistical',
            'js' => ['statistical'],
            'sumBillStatistical' => $sumBillStatistical,
            'countBillStatistical' => $countBillStatistical,
            'billsNew' => $billsNew,
            // 'detailBillStatistical' => $detailBillStatistical,
            'statisticalBillByMonth' => $statisticalBillByMonth,
            'bestSellerByMonth' => $bestSellerByMonth,
            'statisticalBillByCurrentMonth' => $statisticalBillByCurrentMonth,
            'bestSellerByCurrentMonth' => $bestSellerByCurrentMonth,

        ]);
    }

    function show_detail()
    {
        if (isset($_POST['id']) && $_POST['id']) {
            $id_bill = $_POST['id'];
            $detailBillStatistical = $this->bills->detailBillStatistical($id_bill);
            $detailBillStatistical['detail'] = $this->bills->getDetailBill($id_bill);
            if ($detailBillStatistical['user_id'] > 0) {
                $detailBillStatistical['email_user'] = $this->users->SelectUser($detailBillStatistical['user_id'])['email'];
                $detailBillStatistical['name_user'] = $this->users->SelectUser($detailBillStatistical['user_id'])['name'];
            } else {
                $detailBillStatistical['email_user'] = '';
                $detailBillStatistical['name_user'] = '';
                $detailBillStatistical['user_id'] = 'Không có tài khoản';
            }
            // array_push($detailBillStatisticalNew, $detailBillStatistical);
            print_r(json_encode($detailBillStatistical));
        }
    }
}
