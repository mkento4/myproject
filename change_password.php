<?php
include('db.php');
session_start();
if(!isset($_SESSION['user_email'])){

  header("location: signin.php");

}

$user_email = $_SESSION['user_email'];
$select = "select * from users where user_email = '$user_email'";
$stmt = $con->prepare($select);
$stmt->execute();
$result = $stmt->fetchAll();
foreach ($result as $row) {
  $user_pass = $row['user_pass'];
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
      <h1 class="text-muted">Change Password</h1>
      <!-- Login Form -->
      <form method="post">
        <input type="text" name="old_pass" placeholder="old password" required>
        <input type="text" name="pass1" placeholder="new password" required>
        <input type="text" name="pass2" placeholder="confirm password" required>
        <input type="submit" name="new_pass" value="update">
      </form>
      <?php
      if(isset($_POST['new_pass'])){
        $old_pass = $_POST['old_pass'];
        if($old_pass == $user_pass){
          $pass1 = $_POST['pass1'];
          $pass2 = $_POST['pass2'];
          if($pass1 == $pass2){
            if(strlen($pass1) > 8){
              $update = "update users set user_pass = '$pass1' where user_email = '$user_eamail'";
              $stmt = $con->prepare($update);
              if($stmt->execute()){
                echo "<script>alert('成功しました。');</script>";
              }else{
                echo "<script>alert('失敗しました。');</script>";
              }
            }else{
              echo "<script>alert('password should be more than 8 chars ');</script>";
            }
          }else{
            echo "<script>alert('new pass not eqaul confirm pass ');</script>";
          }
        }else {
          echo "<script>alert('confirm passowrd!!');</script>";
        }
      }
       ?>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        <p>
          <a class="underlineHover" href="account_settings.php">settings</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
