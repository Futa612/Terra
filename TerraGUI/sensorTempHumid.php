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

    //Update 2 parameters 
    $sql1 = "UPDATE `sensor` SET `temp`='".$temp."',`humid`='".$humid."' WHERE 1";

    $result1 = mysqli_query($connect, $sql1);
    if ($result != NULL) {
        echo "Data from ESP8266 was received<br>";
    }
    mysqli_close($connect);
?>
        