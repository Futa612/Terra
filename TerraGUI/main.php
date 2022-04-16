<?php
include_once('esp-database.php');

$result = getAllOutputs();
$html_buttons = null;
$html_delete = null;
if ($result) {
    while ($row = $result->fetch_assoc()) {

        if ($row["state"] == "1") {
            $button_checked = "";
        } else {
            $button_checked = "checked";
        }

        $html_buttons .= '<div class="rec-padding">
            <div class="rec">
                <div class="content">
                    <p id="name">' . $row["name"] . '</p>
                    <div class="detail-content">
                        <p>' . 'Board' . $row["board"] . '</p>
                        <p>GPIO' . $row["gpio"] . '</p>
                        </div>
                    </div>
                    <label class="switch-padding">
                        <label class="switch">
                            <input type="checkbox" onchange="updateOutput(this)" id="' . $row["id"] . '" ' . $button_checked . '>
                            <span class="slider"></span>
                        </label>
                    </label>
                </div>
            </div>';

        $html_delete .= '<div class="rec-padding">
            <div class="rec">
                <div class="content">
                    <p id="name">' . $row["name"] . '</p>
                    <div class="detail-content">
                        <p>Board' . $row["board"] . '</p>
                        <br>
                        <p>GPIO' . $row["gpio"] . '</p>
                        </div>
                    </div>
                    <div class="delete">
                        <button onclick="deleteOutput(this)" href="javascript:void(0);" id="' . $row["id"] . '">
                        Xoá
                        </button>
                    </div>
                </div>
            </div>';
    }
}

$result2 = getAllBoards();
$html_boards = null;
if ($result2) {
    $html_boards .= '<h3>Boards</h3>';
    while ($row = $result2->fetch_assoc()) {
        $row_reading_time = $row["last_request"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));

        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 7 hours"));
        $html_boards .= '<p><strong>Board ' . $row["board"] . '</strong> - Yêu cầu lần cuối: ' . $row_reading_time . '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/terra3.ico"/>
    <title>Terra</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/pure.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="header">
        <div class="user-logo">
            <div class="round"></div>
        </div>

        <div class="welcome">
            <div>Xin chào,</div>
            <div>Nguyễn Phú Đạt</div>
        </div>
    </div>
    <div class="terra" onclick="terra_nav()">
        <i class="fas fa-leaf"></i>
    </div>
    <div class="main" id="home_page">
        <div class="sensor-padding">

            <div class="sensor">

                <div class="square">
                    <div id="pure_humid" class="c100 p0">
                        <span id="humid">0%</span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                </div>

                <div class="square">
                    <div id="pure_temp" class="c100 p0 orange">
                        <span id="temp">0°C</span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                </div>

                <div class="square">
                    <div id="pure_lux" class="c100 p0 yellow">
                        <span id="lux">0lux</span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="gpio">

            <?php echo $html_buttons; ?>

        </div>
    </div>

    <div class="main2" id="notification_page">

        <div class="thongbao">Thông báo: Cập nhật phiên bản mới nhất vào ngày 18/10/2021: Terra_v102</div><br>
        <div class="thongbao">Thông báo: Terra đã chính thức mở cửa sever quốc tế lúc 0h ngày 18/10/2021!!! </div><br>
        <div class="thongbao">Thông báo: Cập nhật phiên bản beta cho tester ngày 24/9/2021: Terra_v101</div><br>
        <div class="thongbao">Thông báo: Terra chuyển host về máy chủ Việt Nam tại 123HOST.VN từ ngày 7/12/2021</div>
        <?php echo $html_boards; ?>

    </div>

    <div class="main3" id="times_page">

        <div class="thongbao">Tính năng này chưa ra mắt trên phiên bản beta</div>

    </div>

    <div class="main4" id="users_page">

        <div class="user_info">
            <h3>Thông tin người dùng</h3>
            <label for="">Tên: Nguyễn Phú Đạt</label>
        </div>
        <br>
        <div class="create_gpio">
            <form onsubmit="return createOutput();" class="mod_gpio">
                <h3>Thêm thiết bị</h3>

                <div class="line">
                    <label for="outputName">Tên:</label>
                    <input type="text" name="name" id="outputName">
                </div><br>

                <div class="line">
                    <label for="outputBoard">Board ID:</label>
                    <input type="number" name="board" min="0" id="outputBoard">
                </div><br>

                <div class="line">
                    <label for="outputGpio">Số thứ tự GPIO:</label>
                    <input type="number" name="gpio" min="0" id="outputGpio">
                </div><br>

                <div class="line">
                    <label for="outputState">Trạng thái ban đầu của GPIO:</label>
                    <select id="outputState" name="state">
                        <option value="0">0 = OFF</option>
                        <option value="1">1 = ON</option>
                    </select>
                </div><br>

                <div class="GPIO_submit">
                    <button type="submit" value="Create Output">Tạo GPIO</button>
                </div>

                <p><strong>Chú ý:</strong> Ở một số thiết bị cần phải refresh lại trang để làm mới thái của các thiết bị.</p>

            </form>

        </div>

        <br>

        <?php echo $html_delete ?>

        <div class="user_info">
            <h3>Terra mode</h3>
            <label for="">Phiên bản: beta_101</label>
        </div>

        <br>

    </div>

    <div class="main5" id="terra_page">

        <br>
        <div class="gpio2">
            <div class="rec">
                <div class="content">
                    <p id="name">PID Pump</p>
                    <div class="detail-content">
                        <p></p>
                        <p></p>
                    </div>
                </div>
                <label class="switch-padding">
                    <label class="switch">
                        <input type="checkbox" onchange="">
                        <span class="slider"></span>
                    </label>
                </label>
            </div>
        </div>
        
        <div class="sensor-padding">
            <div class="square">
                <div id="pure_soil" class="c100 p0 green">
                    <span id="lux">0%</span>
                    <div class="slice">
                        <div class="bar"></div>
                        <div class="fill"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <br>



    </div>

    <div class="footer_nav">
        <div class="nav_icon" id="home" onclick="home_nav()">
            <i class="fas fa-home"></i>
            <span>Trang chủ</span>
        </div>

        <div class="nav_icon" id="notification" onclick="notification_nav()">
            <i class="fas fa-bell"></i>
            <span>Thông báo</span>
        </div>

        <div class="nav_icon" id="times" onclick="times_nav()">
            <i class="fas fa-stopwatch"></i>
            <span>Hẹn giờ</span>
        </div>

        <div class="nav_icon" id="users" onclick="users_nav()">
            <i class="fas fa-user"></i>
            <span>Cá nhân</span>
        </div>
    </div>
</body>
<script>
    function home_nav() {
        document.getElementById("home_page").style.display = "block";
        document.getElementById("notification_page").style.display = "none";
        document.getElementById("times_page").style.display = "none";
        document.getElementById("users_page").style.display = "none";
        document.getElementById("terra_page").style.display = "none";
    }

    function notification_nav() {
        document.getElementById("home_page").style.display = "none";
        document.getElementById("notification_page").style.display = "block";
        document.getElementById("times_page").style.display = "none";
        document.getElementById("users_page").style.display = "none";
        document.getElementById("terra_page").style.display = "none";
    }

    function times_nav() {
        document.getElementById("home_page").style.display = "none";
        document.getElementById("notification_page").style.display = "none";
        document.getElementById("times_page").style.display = "block";
        document.getElementById("users_page").style.display = "none";
        document.getElementById("terra_page").style.display = "none";
    }

    function users_nav() {
        document.getElementById("home_page").style.display = "none";
        document.getElementById("notification_page").style.display = "none";
        document.getElementById("times_page").style.display = "none";
        document.getElementById("users_page").style.display = "block";
        document.getElementById("terra_page").style.display = "none";
    }

    function terra_nav() {
        document.getElementById("home_page").style.display = "none";
        document.getElementById("notification_page").style.display = "none";
        document.getElementById("times_page").style.display = "none";
        document.getElementById("users_page").style.display = "none";
        document.getElementById("terra_page").style.display = "block";
    }
</script>
<script>
    function updateOutput(element) {
        var xhr = new XMLHttpRequest();
        if (element.checked) {
            xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=1", true);
        } else {
            xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=0", true);
        }
        xhr.send();
    }

    function deleteOutput(element) {
        var result = confirm("Bạn có chắc muốn xoá thiết bị này chứ? ");
        if (result) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "esp-outputs-action.php?action=output_delete&id=" + element.id, true);
            xhr.send();
            alert("Đã xoá thiết bị");
            setTimeout(function() {
                window.location.reload();
            });
        }
    }

    function createOutput(element) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "esp-outputs-action.php", true);

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                alert("Output created");
                setTimeout(function() {
                    window.location.reload();
                });
            }
        }
        var outputName = document.getElementById("outputName").value;
        var outputBoard = document.getElementById("outputBoard").value;
        var outputGpio = document.getElementById("outputGpio").value;
        var outputState = document.getElementById("outputState").value;
        var httpRequestData = "action=output_create&name=" + outputName + "&board=" + outputBoard + "&gpio=" + outputGpio + "&state=" + outputState;
        xhr.send(httpRequestData);
    }
</script>


<script>
    $(document).ready(function() { /// Wait till page is loaded
        setInterval(timingLoad, 3000);

        function timingLoad() {
            $('#pure_temp').load('temp.php #pure_temp', function() {
                /// can add another function here
            });

            $('#pure_humid').load('humid.php #pure_humid', function() {
                /// can add another function here
            });

            $('#pure_lux').load('lux.php #pure_lux', function() {
                /// can add another function here
            });
            $('#pure_soil').load('soil.php #pure_soil', function() {
                /// can add another function here
            });
        }
    }); //// End of Wait till page is loaded
</script>


</html>