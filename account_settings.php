<?php
session_start();

if(!isset($_SESSION['token3'])){
  $_SESSION['token3'] =  bin2hex(openssl_random_pseudo_bytes(16));
}

include('db.php');
if(!isset($_SESSION['user_email'])){

  header("location: signin.php");

}

$user_email = $_SESSION['user_email'];
$select = "select * from users where user_email = '$user_email'";
$stmt = $con->prepare($select);
$stmt->execute();
$result = $stmt->fetchAll();
foreach ($result as $row) {
  $user_name = $row['user_name'];
  $user_email = $row['user_email'];
  $user_country = $row['user_country'];
  $user_gender = $row['user_gender'];
  $one_msg = $row['one_msg'];
}
if(isset($_POST['update'])){

 // CSRF対策
  if (!isset($_POST['token3']) || $_POST['token3'] !== $_SESSION['token3']) {
      echo "Invalid token3!";
      exit;
 }

  $new_user_name = $_POST['user_name'];
  $new_user_email = $_POST['user_email'];
  $new_user_country = $_POST['user_country'];
  $new_user_gender = $_POST['user_gender'];
  $new_one_msg = $_POST['one_msg'];

  $update = "update users set user_name='$new_user_name',user_email='$new_user_email',
  user_country='$new_user_country',user_gender='$new_user_gender',one_msg = '$new_one_msg' where user_email='$user_email'";
  $stmt = $con->prepare($update);
  if($stmt->execute()){
    echo "<script>alert('成功しました。');</script>";
  }else{
    echo "<script>alert('失敗しました。');</script>";
  }
}



 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Account</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/account_settings.css">
</head>
<body>
  <div class="wrapper">
    <div id="formContent">
      <br>
      <h1 class="text-muted">settings</h1>
      <!-- Login Form -->
      <form method="post">
        <input type="text" value="<?php echo $user_name; ?>" name="user_name" placeholder="change your username" required>
        <input type="text" value="<?php echo $user_email; ?>" name="user_email" placeholder="change your email" required>
        <input type="text" value="<?php echo $user_country; ?>" name="user_country" placeholder="change your country" required>
        <input type="text" value="<?php echo $user_gender; ?>" name="user_gender" placeholder="male/female/others" required>
        <input type="text" value="<?php echo $one_msg; ?>" name="one_msg" placeholder="one message">
        <div id="formFooter">
          <p>
            <a class="underlineHover" href="upload.php">change profile</a>
          </p>
        </div>
        <div id="formFooter">
          <p>
            <a class="underlineHover" href="change_password.php">change password</a>
          </p>
        </div>
        <input type="submit" name="update" value="update">
                <input type="hidden" name="token3" value="<?php echo h($_SESSION['token3']); ?>">

      </form>
      <div id="formFooter">
        <p>
          <a class="underlineHover" href="home.php">finish</a>
        </p>
      </div>


    </div>
  </div>
</body>
</html>
