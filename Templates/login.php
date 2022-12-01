<?php

@include 'config.php';

session_start();

//Register

if(isset($_POST['submit'])) {

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = md5($_POST['password']);
  $cpass = md5($_POST['cpassword']);
  $user_type = $_POST['user_type'];

  $select = " SELECT * FROM user_info WHERE  email='$email' && password='$pass' ";

  $result = mysqli_query($conn, $select);

  if(mysqli_num_rows($result) > 0) {

    $error[] = 'User already existed!';

  }
  
  else {

    if($pass != $cpass) {

      $error[] = 'The password is not matched!';  

    } 
    
    else {

      $insert = "INSERT INTO user_info(name, email, password, user_type) VALUES ('$name', '$email', '$pass', '$user_type')";
      mysqli_query($conn, $insert);
      header('location:homepage.php');

    }

  }

};

//Login



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS-->
    <link rel="stylesheet" href="css/login.css">

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="img/bg-img1.jpg" alt="">
        <div class="text">
          <span class="text-1">Every bid is a <br> new achievement</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="img/bg-img2.jpg" alt="">
        <div class="text">
          <span class="text-1">Get started bidding<br> with one click</span>
          <span class="text-2">Let's get you registered now</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <a href="homepage.php" style="text-decoration: none;"><h1 style="padding-bottom: 20px;">
            <img src="img/logo.jpg" style="height: 20%; width: 20%;">Auction4u</h1></a>
            <div class="title">Login</div>
          <form action="" method="POST">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Enter your email">
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Enter your password">
              </div>
              <div class="text"><a href="#">Forgot password?</a></div>
              <div class="input-box">

                <?php
                  if(isset($error)) {
                    foreach($error as $error) {
                      echo '<span class="error-msg">'.$error.'</span>';
                    }
                  };
                ?>

              </div>
              <div class="button input-box">
                <input type="submit" name="login" value="Login">
              </div>
              <div class="text sign-up-text">Don't have an account? <label for="flip">Register Now</label></div>
            </div>
        </form>
      </div>
        <div class="signup-form">
          <div class="title">Sign Up</div>
        <form action="" method="POST">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Enter your username">
              </div>
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Enter your email">
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password">
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="cpassword" placeholder="Re-enter your password">
              </div>
              <div class="input-box">
                <select name="user_type">
                  <option value="bidder">Bidder</option>
                  <option value="seller">Seller</option>
                  <option style="display: none;">-----------------------------------------</option>
                </select>
              </div>
              <div class="input-box">

                <?php
                  if(isset($error)) {
                    foreach($error as $error) {
                      echo '<span class="error-msg">'.$error.'</span>';
                    }
                  };
                ?>

              </div>
              <div class="button input-box">
                <input type="submit" name="submit" value="Register">
              </div>
              <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
            </div>
      </form>
    </div>
    </div>
    </div>
  </div>



  
</body>
</html>
