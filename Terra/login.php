<?php
ob_start();
$email = $_POST['Email'];
$password = $_POST['Password'];

// $email = '2fnamhoang@gmail.com';
// $password = '123';

//TAO KET NOI DEN DATABASE
require_once("config.php");
$connect = new mysqli(HOSTNAME, USERNAME,PASSWORD,DATABASE ); 
//KIEM TRA KET NOI
if($connect->connect_error){
    echo('Fail to connect to SQL: ').$connect->connect_error;
    exit();
}
$connect-> set_charset('utf8');

//THUC HIEN TRUY VAN VAO DATABASE DE LAY DU LIEU:
$query = "SELECT * FROM account WHERE email ='".$email."' AND password = '".$password."' ";
$result = mysqli_query($connect, $query);
$data = array();
while ($row = mysqli_fetch_array($result,1)) {
    $data[] = $row;
}
// var_dump($data);
//DONG KET NOI
$connect->close();

//KIEM TRA KET QUA VA THUC HIEN LOGIN
if ($data != NULL && count($data)>0) {
    echo "<script type='text/javascript'>
        document.getElementById('main-login').style.transform = 'translateX(-100%)';
        document.getElementById('main-login').style.opacity = '0%';
    
    </script>";
    header('location: main.php');
}
else{
    
}
ob_end_flush();
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="login2.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login2.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/terra3.ico"/>
    <title>Terra</title>
</head>
<body>
    <div class="main-login" id="main-login">
        <tieude style="text-align: center ;">
            Terra<i class="fas fa-leaf" id="leaff"></i>
        </tieude>
        
        <div class="saipass">
            <p>Password was incorrect, you can log-in again or sign-up at <a href="index.php">here</a></p>
        </div>

        <footer>
                <svg viewBox="0 0 120 28">
                <defs> 
                <mask id="xxx">
                    <circle cx="7" cy="12" r="40" fill="#fff" />
                </mask>
                
                <filter id="goo">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="2" result="blur" />
                    <feColorMatrix in="blur" mode="matrix" values="
                        1 0 0 0 0  
                        0 1 0 0 0  
                        0 0 1 0 0  
                        0 0 0 13 -9" result="goo" />
                    <feBlend in="SourceGraphic" in2="goo" />
                    </filter>
                    <path id="wave" d="M 0,10 C 30,10 30,15 60,15 90,15 90,10 120,10 150,10 150,15 180,15 210,15 210,10 240,10 v 28 h -240 z" />
                </defs> 
                
                <use id="wave3" class="wave" xlink:href="#wave" x="0" y="-2" ></use> 
                <use id="wave2" class="wave" xlink:href="#wave" x="0" y="0" ></use>
                
                <!-- <g class="topball">
                    <circle class="ball" cx="110" cy="8" r="4" stroke="none" stroke-width="0" fill="red" />
                  
                      <g class="arrow">
                      <polyline class="" points="108,8 110,6 112,8" fill="none"  />
                      <polyline class="" points="110,6 110,10.5" fill="none"  />
                      </g> -->

                <g class="gooeff">
                <circle class="drop drop1" cx="20" cy="2" r="1.8"  />
                <circle class="drop drop2" cx="25" cy="2.5" r="1.5"  />
                <circle class="drop drop3" cx="16" cy="2.8" r="1.2"  />
                    <use id="wave1" class="wave" xlink:href="#wave" x="0" y="1" />
                
                    <!-- g mask="url(#xxx)">
                    <path   id="wave1"  class="wave" d="M 0,10 C 30,10 30,15 60,15 90,15 90,10 120,10 150,10 150,15 180,15 210,15 210,10 240,10 v 28 h -240 z" />
                    </g>
                </g -->
                
                </svg>
            </footer>
    </div>

    <script>
        function login(){
            // document.getElementById("main-login").style.display = "none";
            document.getElementById("main-login").style.transform = "translateX(-100%)";
            document.getElementById("main-login").style.opacity = "0%";
        }
        </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="/script.js"></script>
</body>
</html>

