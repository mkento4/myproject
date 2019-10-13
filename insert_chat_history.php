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
if(isset($_POST['msg_content'])){
  $msg = h($_POST['msg_content']);
  // $sender = $_POST['fromusername'];
  $receiver = h($_POST['tousername']);
  $msg_content = h($_POST['msg_content']);
  if($msg == ""){
    echo "<script>alert('enter message');</script>";
  }else if(strlen($msg) > 100){
    echo "<script>alert('	Message is Too long! Use only 100 characters');</script>";
  }else{
    $insert = "insert into users_chat
    (sender_username,receiver,msg_content,msg_status,msg_date) values
    ('$login_user_name','$receiver','$msg_content',
    'unread',NOW())";
    $stmt = $con->prepare($insert);
    $stmt->execute();
  }

  echo fetch_chat_history($receiver,$login_user_name,$con);
}
 ?>
