<?php

function redirectTo($file)
{
	if (isset($file)) {
		header("Location: " . _WEB_ROOT . '/' . $file);
		exit;
	}
};


function redirectToDetailBill($array, $dataPhone = '', $getPhone = '')
{
	$arr = explode("/", $_GET["url"]);
	$idBillGet = end(($arr));

	if (!isset($_SESSION['user']) && isset($_SESSION['bill_new']) && $_SESSION['bill_new'] == $idBillGet || isset($_SESSION['user']) && array_key_exists($idBillGet, $array) || $dataPhone == $getPhone) {
	} else {
		redirectTo('');
	}
}
