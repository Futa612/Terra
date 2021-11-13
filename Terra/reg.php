<?php
    ob_start();
$magioithieu = $_POST['magioithieu'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['confirm-password'];

$dbmagioithieu = 'haui';
$date = date("Y-m-d H:i:s");


//TAO KET NOI DEN DATABASE
require_once("config.php");
$connect = new mysqli(HOSTNAME, USERNAME,PASSWORD,DATABASE ); 
//KIEM TRA KET NOI
if($connect->connect_error){
    echo('Fail to connect to SQL: ').$connect->connect_error;
    exit();
}
$connect-> set_charset('utf8');

//THUC HIEN TRUY VAN DU LIEU DE GHI VAO DATABASE:
if ($magioithieu != $dbmagioithieu) {
    $message = "Bạn cần có mã giới thiệu";
    echo "<script> var r = confirm('$message'); </script>";
    $connect->close();
    header( "Refresh:1; index.php", true, 303);
}
else {
    if ($password != $cpassword) {
        $message = "Mật khẩu nhập lại không trùng khớp";
        echo "<script> var r = confirm('$message'); </script>";
        $connect->close();
        header( "Refresh:1; index.php", true, 303);
    }
    else{
        $query = "INSERT INTO `account`(`name`, `email`, `password`) VALUES ('".$name."', '".$email."','".$password."')";
        
        mysqli_query($connect, $query);
        $connect->close();
        header('location: reg_success.php');
    }
    // //DONG KET NOI
    // $connect->close();
    // header('location: index.php');
    
}
ob_end_flush();
?>
