<!-- <?php
        echo '<pre>';

        $url = $_SERVER['REQUEST_URI'];

        $urlNew = substr($url, strrpos($url, '?') + 1);
        $urlNew = explode('&', $urlNew);

        $arrLast = [];

        foreach ($urlNew as $item) {
            $itemNew = explode('=', $item);
            $arrLast[$itemNew[0]] = $itemNew[1];
        }
        ?> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <!-- Bootstrap core CSS -->
    <!-- Custom styles for this template -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        .background {
            background-image: url(<?= _PATH_IMG_PUBLIC . 'bia-vnpay.jpg' ?>);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

        }
    </style>
</head>

<body class="d-flex flex-column align-items-center justify-content-between background" style="height:100vh">
    <!-- <?php

            $vnp_HashSecret = "DHBYYHIKROSNLSXEKWLWCTCMRUFPWFJW"; //Chuỗi bí mật

            $startTime = date("YmdHis");
            $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
            $vnp_SecureHash = $_GET['vnp_SecureHash'];
            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }

            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            // echo $secureHash . '<br/>';
            // echo $vnp_SecureHash;
            // die();
            ?> -->
    <!--Begin display -->

    <div class="my-auto" style="border: 3px solid #037dff;
    border-radius: 5px !important; padding: 10px 30px; background-color: #ffffffe3">
        <div class="header clearfix">
            <h3 class="text-center" style="color: #037dff;">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>

                <label><?php echo $_GET['vnp_TxnRef'] ?></label>
            </div>
            <div class="form-group">

                <label>Số tiền:</label>
                <label><?php echo numberFormat($_GET['vnp_Amount'] / 100) ?></label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>

                <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label><?php echo $_GET['vnp_BankCode'] ?></label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label><?php echo date('H:i:s d/m/Y', strtotime($_GET['vnp_PayDate'])) ?></label>
            </div>
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                    <?php
                    if ($secureHash == $vnp_SecureHash) {
                        if ($_GET['vnp_ResponseCode'] == '00') {
                            $checked = 1;
                            echo "<span class='success_vnpay' style=  'color:blue'>Giao dịch thành công</span>";
                        } else {
                            $checked = 0;

                            echo "<span style='color:red'>Giao dịch không thành công</span>";
                        }
                    } else {
                        $checked = 0;

                        echo "<span style='color:red'>Chữ ký không hợp lệ!</span>";
                    }
                    ?>

                </label>
            </div>
            <?php
            if ($checked) {
            ?>
                <a href="<?= _WEB_ROOT . '/bill/redirectTo' ?>">Xem đơn hàng</a>

            <?php
            } else {
            ?>
                <a href="<?= _WEB_ROOT . '/checkout' ?>">Quay về trang thanh toán</a>

            <?php
            }
            ?>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; VNPAY <?php echo date('Y') ?></p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>

    <?php
    if (isset($data['js'])) {
        foreach ($data['js'] as $item) {
    ?>
            <script type="text/javascript" src="<?php echo _PATH_ROOT_PUBLIC . '/client/assets/js/' . $item . '.js' ?>"></script>
    <?php
        }
    }

    ?>
</body>

</html>