<?php
session_start();
ob_start();
// đặt múi giờ mặc định
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once "./mvc/Bridge.php";
require_once "./mvc/mailer/Exception.php";
require_once "./mvc/mailer/PHPMailer.php";
require_once "./mvc/mailer/SMTP.php";



$myApp = new App();
?>