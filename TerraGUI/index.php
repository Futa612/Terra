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
        <div id="logreg-forms">
            <form class="form-signin" action="login.php"  method="POST">
                <h1 class="h3 mb-3 font-weight-normal"> Sign in</h1>
                <!-- <div class="social-login">
                    <button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign in with Facebook</span> </button>
                    <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign in with Google+</span> </button>
                </div> -->
                <!-- <p style="text-align:center"> OR  </p> -->
                <input type="email" id="inputEmail" name="Email" class="form-control" placeholder="Email address" required="" autofocus="">
                <input type="password" id="inputPassword" name="Password" class="form-control" placeholder="Password" required="">
                
                <button class="btn btn-success btn-block" type="submit" onclick=""><i class="fas fa-sign-in-alt"></i> Sign in</button>
                <a href="#" id="forgot_pswd" >Forgot password?</a>
                <hr>
                <!-- <p>Don't have an account!</p>  -->
                <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i> Sign up New Account</button>
                </form>
    
                <form action="/reset/password/" class="form-reset">
                    <input type="email" id="resetEmail" class="form-control" placeholder="Email address" required="" autofocus="">
                    <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                    <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
                </form>
                
            <form class="form-signup" action="reg.php" method="POST" >
                <!-- <div class="social-login">
                    <button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign up with Facebook</span> </button>
                </div>
                <div class="social-login">
                    <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign up with Google+</span> </button>
                </div> -->
                
                <!-- <p style="text-align:center">OR</p> -->

                <input type="text" id="ma_gioi_thieu" name="magioithieu" class="form-control" placeholder="Preminum code" required="" autofocus="">
                <input type="text" id="user-name" name="name" class="form-control" placeholder="Full name" required="" autofocus="">
                <input type="email" id="user-email" name="email" class="form-control" placeholder="Email address" required autofocus="">
                <input type="password" id="user-pass" name="password" class="form-control" placeholder="Password" required autofocus="">
                <input type="password" id="user-repeatpass" name="confirm-password" class="form-control" placeholder="Confirm password" required autofocus="">
                <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Sign Up</button>
                <a href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Back</a>
            </form>
                <br>
                
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

