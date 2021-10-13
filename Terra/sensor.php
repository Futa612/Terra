<?php
    require_once("config.php");
    $connect = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    if(!$connect){
        echo "Error: " . mysqli_connect_error();
        exit();
    }
    echo "Connection Success!<br><br>";

    $temp = $_GET["temp"];
    $humid = $_GET["humid"];
    $lux = $_GET["lux"];

    // $temp = "20";
    // $humid = "43";
    // $lux = "54";

    $sql1 = "UPDATE `sensor` SET `temp`='.$temp.',`humid`='.$humid.',`lux`='.$lux.' WHERE 1";

    $result1 = mysqli_query($connect, $sql1);
    if ($result != NULL) {
        echo "Da nhan du lieu tu ESP8266<br>";
    }
    mysqli_close($connect);
?>
        