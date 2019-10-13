<?php
session_start();
include('db.php');

if(!isset($_SESSION['user_email'])){
  header("location: signin.php");
}

$user_email  =$_SESSION['user_email'];


if(isset($_POST['upload'])){
  $user_image = $_FILES['user_image']['name'];
  $image_tmp = $_FILES['user_image']['tmp_name'];
  $random_number = rand(1,100);

  if($user_image==''){
    echo "<script>alert('choose file!');</script>";
    header('location: upload.php');
  }else{

    move_uploaded_file($image_tmp,"image/$user_image.$random_number");


    $update = "update users set user_profile='image/$user_image.$random_number'
    where user_email='$user_email'";
    $stmt = $con->prepare($update);
    $stmt->execute();
    if($stmt->execute()){
      echo "<script>alert('成功しました。');</script>";
    }else{
      echo "<script>alert('失敗しました。');</script>";
    }
  }

}

?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Upload Profile</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
  <form  method="post"  enctype='multipart/form-data'>
    <div class="input-group">
      <div class="input-group-prepend">
        <button class="btn btn-outline-dark" type="submit" name="upload">Upload</button>
      </div>
      <div class="custom-file">
        <input type="file" name="user_image" class="custom-file-input" id="inputGroupFile01"
        aria-describedby="inputGroupFileAddon01">
        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
      </div>
    </div>
  </form>
  <a href="home.php">Home</a>

</body>
</html>
