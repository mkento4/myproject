<?php
include('db.php');
session_start();
$email = $_SESSION['user_email'];
$update_state = "update users set log_in = 'offline' where user_email = '$email'";
$stmt = $con->prepare($update_state);
$stmt->execute();

session_destroy();
header('location:signin.php');
 ?>
