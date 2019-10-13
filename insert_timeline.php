<?php
include('db.php');
session_start();

$login_user_email = $_SESSION['user_email'];
$login_user = "select * from users where user_email = '$login_user_email'";
$stmt = $con->prepare($login_user);
$stmt->execute();
$result = $stmt->fetchAll();
foreach ($result as $row) {
  $login_user_name = $row['user_name'];
}
if(isset($_POST['tl_title'])){
  $tl_title = $_POST['tl_title'];
  $tl_content = $_POST['tl_content'];
  $insert = "insert into timeline (user_name,tl_title,tl_content) values
  ('$login_user_name','$tl_title','$tl_content') ";
  $stmt = $con->prepare($insert);
  $stmt->execute();
}

 ?>
