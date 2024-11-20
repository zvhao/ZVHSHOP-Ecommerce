<?php
$arr_name_project = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$project_name = $arr_name_project[0] ?? '';

define('_NAME_PROJECT', $project_name);

define('_WEB_ROOT', 'https://' . $_SERVER['HTTP_HOST']);
define('_WEB_ROOT_ADMIN', _WEB_ROOT . '/Admin');
define('_PATH_ROOT_PUBLIC', _WEB_ROOT . '/public');
define('_PATH_IMG_PUBLIC', _WEB_ROOT . '/public/client/assets/img/');
define('_VIEW_PATH', __DIR__ . '/views');
define('_UPLOAD', _WEB_ROOT . '/upload/');
define('_UPLOAD_LOCAL', $_SERVER['DOCUMENT_ROOT'] . '/upload/');

define('_PATH_AVATAR', _WEB_ROOT . '/upload/avt/');
define('_PUBLIC', _WEB_ROOT . '/public/');
define('_PATH_IMG_PRODUCT', _WEB_ROOT . '/upload/product/');


require_once "./mvc/util/sendMail.php";

// Process URL from browser
require_once "./mvc/core/App.php";

// How controllers call Views & Models
require_once "./mvc/core/Controller.php";




// Connect Database
require_once "./mvc/core/DB.php";

// helper
require_once './mvc/helper/getName.php';
require_once './mvc/helper/showArray.php';
require_once './mvc/helper/numberFormat.php';
require_once './mvc/helper/redirectTo.php';
require_once './mvc/helper/getStatusBill.php';
require_once './mvc/helper/getPaging.php';
require_once './mvc/helper/getMethodPayment.php';
require_once './mvc/helper/getRatingStar.php';
require_once './mvc/helper/avatarHeader.php';
require_once './mvc/helper/getSampleComment.php';
?>