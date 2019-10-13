<?php
include('db.php');
session_start();
if(!isset($_SESSION['token2'])){
  $_SESSION['token2'] =  bin2hex(openssl_random_pseudo_bytes(16));
}


if(isset($_POST['signin'])){

   // CSRF対策
  if (!isset($_POST['token2']) || $_POST['token2'] !== $_SESSION['token2']) {
      echo "Invalid token2!";
      exit;
 }

  $email = h(trim($_POST['email']));
  $pass = h(trim($_POST['pass']));

  $select = "select * from users where user_email = '$email' and
  user_pass = '$pass'";
  $stmt = $con->prepare($select);
  $stmt->execute();
  $result = $stmt->fetchAll();
  if(count($result) > 0){
    $_SESSION['user_email'] = $email;
    $update_state = "update users set log_in = 'online' where user_email = '$email'";
    $stmt = $con->prepare($update_state);
    $stmt->execute();
    $get_user = "select * from users where user_email = '$email'";
    $stmt = $con->prepare($get_user);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
      $user_name = $row['user_name'];
    }
    header('location:home.php?user_name='.$user_name);
  }else{
    echo '<script>window.alert("パスワードかemailを確認してください。");</script>';
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
      <h1 class="text-muted">Sign In</h1>
      <!-- Login Form -->
      <form method="post">
        <input type="text" id="login"  name="email" placeholder="email" required>
        <input type="text" id="password" name="pass" placeholder="password" required>
        <input type="submit" name="signin" value="Log In">
        <input type="hidden" name="token2" value="<?php echo h($_SESSION['token2']); ?>">
      </form>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        <p>
          <a class="underlineHover" href="#">Forgot Password?</a>
        </p>
        <p class="text-muted">
          or
        </p>
        <p>
          <a class="underlineHover" href="signup.php">sign up</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
