<?php
    require_once("config.php");
    $connect = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    if(!$connect){
        echo "Error: " . mysqli_connect_error();
        exit();
    }
    echo "Connection Success!<br><br>";

    $lux = $_GET["lux"];

    $sql1 = "UPDATE `sensor` SET `lux`='".$lux."' WHERE 1";

    $result1 = mysqli_query($connect, $sql1);
    if ($result != NULL) {
        echo "Data from ESP8266 was received<br>";
    }
    mysqli_close($connect);
?>
