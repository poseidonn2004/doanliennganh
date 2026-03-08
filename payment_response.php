<?php
session_start();

require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

$vnp_ResponseCode = $_GET['vnp_ResponseCode'];

if ($vnp_ResponseCode == "00") {

    $order_id = $_GET['vnp_TxnRef'];
    $trans_id = $_GET['vnp_TransactionNo'];

    // Update database
    $query = "UPDATE booking_order 
          SET trans_status='paid',
              booking_status='booked',
              trans_id='$trans_id'
          WHERE order_id='$order_id'";

    mysqli_query($con,$query);

    echo "
    <script>
        alert('Thanh toán thành công! Mã đơn hàng: $order_id');
        window.location.href='bookings.php';
    </script>
    ";

}
else{

    echo "
    <script>
        alert('Thanh toán thất bại!');
        window.location.href='bookings.php';
    </script>
    ";

}
?>