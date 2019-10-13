<?php
include('db.php');
session_start();
if(isset($_POST['othername'])){
  $othername = $_POST['othername'];

  $login_user_email = $_SESSION['user_email'];
  $login_user = "select * from users where user_email = '$login_user_email'";
  $stmt = $con->prepare($login_user);
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach ($result as $row) {
    $login_user_id = $row['user_id'];
  }

  $other_user = "select * from users where user_name = '$othername'";
  $stmt = $con->prepare($other_user);
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach ($result as $row) {
    $others_id = $row['user_id'];
  }
  cancel_request($login_user_id,$others_id,$con);
}

 ?>
