<?php
include('db.php');
if(isset($_POST['post_id'])){
  $post_id = $_POST['post_id'];
  $user_name = $_POST['user_name'];
  $comment = $_POST['comment'];

  $insert = "insert into comment (post_id,user_name,comment) values
  ('$post_id','$user_name','$comment')";
  $stmt = $con->prepare($insert);
  $stmt->execute();
}
 ?>
