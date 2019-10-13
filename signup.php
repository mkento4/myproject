<?php
include('db.php');
session_start();
if(!isset($_SESSION['token1'])){
  $_SESSION['token1'] =  bin2hex(openssl_random_pseudo_bytes(16));
}


   
if(isset($_POST['signup'])){

  // CSRF対策
  if (!isset($_POST['token1']) || $_POST['token1'] !== $_SESSION['token1']) {
      echo "Invalid token1!";
      exit;
 }

  $name = h($_POST['user_name']);
  $pass = h($_POST['user_pass']);
  $email = h($_POST['user_email']);
  $country = h($_POST['user_country']);
  $gender = h($_POST['user_gender']);
  $rand = rand(1,2);

  if(strlen($pass) < 8){
    echo '<script>alert("パスワードは8文字以上入力してください。");</script>';
    header('location:signup.php');

  }

  $check_email = "select * from users where user_email = '$email'";
  $stmt = $con->prepare($check_email);
  $stmt->execute();
  $result = $stmt->fetchAll();
  if($result>0){
    echo '<script>alert("すでに存在しています。");</script>';
    header('location:signup.php');
  }

  if($rand == 1){
    $profile_pic = 'image/profile1.jpg';
  }else{
    $profile_pic = 'image/profile2.jpg';
  }

  $insert = "insert into users
  (user_name,user_pass,user_email,user_profile,user_country,user_gender,log_in) values
  ('$name','$pass','$email','$profile_pic','$country','$gender','offline')";
  $stmt = $con->prepare($insert);
  if($stmt->execute()){
    echo '<script>window.alert("成功しました。");</script>';
    header('location:signin.php');
  }else{
    echo '<script>window.alert("失敗しました。");</script>';
  }



}

?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/signin.css">
</head>
<body>
  <div class="wrapper">
    <div id="formContent">
      <br>
      <h1 class="text-muted">Sign Up</h1>
      <!-- Login Form -->
      <form method="post">
        <input type="text" class="fadeIn second" name="user_name" placeholder="username" required>
        <input type="text" class="fadeIn third" name="user_pass" placeholder="password" required>
        <input type="text" class="fadeIn third" name="user_email" placeholder="email" required>
        <div style="width: 86%;" class="form-group mx-auto">

          <select class="form-control" name="user_country" required="required">
            <option disabled="" selected>Select a Country</option>
            <option>United States of America</option>
            <option>India</option>
            <option>UK</option>
            <option>France</option>
            <option>Japan</option>
            <option>Others</option>
          </select>
          <select class="form-control" name="user_gender" required="required">
            <option disabled="disabled" selected>Select a Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Others</option>
          </select>
        </div>
        <input type="submit" name="signup" value="Sign Up">
        <input type="hidden" name="token1" value="<?php echo h($_SESSION['token1']); ?>">
      </form>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        <p>
          <a class="underlineHover" href="signin.php">sign in</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
