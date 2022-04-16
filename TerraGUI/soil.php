<?php
require_once("config.php");
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT `soil` FROM `sensor` WHERE 1";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $soil = $row["soil"];
    }
}
echo '
    <div id="pure_soil" class="c100 p'.$soil.' green">
        <span id="lux">'.$soil.'%</span>
        <div class="slice">
            <div class="bar"></div>
            <div class="fill"></div>
        </div>
    </div>
';
?>