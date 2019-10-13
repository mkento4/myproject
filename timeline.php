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

$sql = "select * from timeline";
$stmt = $con->prepare($sql);
if($stmt->execute()){
  $result = $stmt->fetchAll();
  $output = '';
  foreach ($result  as $row) {
    $tl_content = $row['tl_content'];
    $tl_title = $row['tl_title'];
    $post_id = $row['post_id'];
    $output .='
    <div class="card mx-auto" style="width: 30rem;">
      <div class="card-body">
        <h4 class="card-title">'.$tl_title.'<span class="login_user text-muted"> by '.$login_user_name.'</span></h4>
        <div class="card-text">'.$tl_content.'</div>
        <a class="btn btn-sm btn-warning" href="post_comment.php?post_id='.$post_id.'" class="card-link">コメントする</a>
      </div>
    </div>';
  }
}


echo $output;

?>
