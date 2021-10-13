<?php
require_once("config.php");
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT `temp`, `humid`, `lux` FROM `sensor` WHERE 1";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $temp = $row["temp"];
        $humid = $row["humid"];
        $lux = $row["lux"];
    }
}
echo '
    <div id="pure_temp" class="c100 p'.$temp.' orange">
        <span id="temp">'.$temp.'°C</span>
        <div class="slice">
            <div class="bar"></div>
            <div class="fill"></div>
        </div>
    </div>
';
?>