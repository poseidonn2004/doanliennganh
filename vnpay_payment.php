<?php
session_start();

if(!isset($_SESSION['order_id'])){
    header("Location: index.php");
    exit();
}

$order_id = $_SESSION['order_id'];
$amount = $_SESSION['room']['price']; // hoặc tổng tiền booking

$vnp_TmnCode = "T1SIN6CG"; 
$vnp_HashSecret = "CHNU83K2VHGF5QGIINQ8MUQ8MTN0NR2U";

$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/doanliennganh/payment_response.php";

$vnp_TxnRef = $order_id;
$vnp_OrderInfo = "Thanh toan dat phong";
$vnp_OrderType = "billpayment";
$vnp_Amount = $amount * 100;
$vnp_Locale = "vn";
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef
);

ksort($inputData);

$query = "";
$hashdata = "";

foreach ($inputData as $key => $value) {
    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$hashdata = ltrim($hashdata, "&");

$vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

$vnp_Url = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;

header("Location: ".$vnp_Url);
exit();
?>