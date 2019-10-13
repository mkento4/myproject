<?php
include('db.php');
session_start();
if(isset($_POST['receiver'])){
  $receiver = $_POST['receiver'];
  $login_user_email = $_SESSION['user_email'];
  $login_user = "select * from users where user_email = '$login_user_email'";
  $stmt = $con->prepare($login_user);
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach ($result as $row) {
    $login_user_id = $row['user_id'];
  }

  $other_user = "select * from users where user_name = '$receiver'";
  $stmt = $con->prepare($other_user);
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach ($result as $row) {
    $others_id = $row['user_id'];
  }

  $insert = "insert into friend_request (sender,receiver)
  values ('$login_user_id','$others_id') ";
  $stmt = $con->prepare($insert);
  $stmt->execute();

}
 ?>
