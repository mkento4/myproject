<?php include('db.php');

$post_id = $_GET['post_id'];
$select = "select * from timeline where post_id = '$post_id'";
$stmt = $con->prepare($select);
$stmt->execute();
$result = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="css/timeline.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <style>
  .login_user {
    font-size: 10px;
  }
  </style>
</head>
<body>
  <?php

  foreach ($result as $row) {
    $tl_content = $row['tl_content'];
    $tl_title = $row['tl_title'];
    $user_name = $row['user_name'];
    $post_id = $row['post_id'];
    echo '<div class="card mx-auto" style="width: 30rem;">
      <div class="card-body">
        <h4 class="card-title">'.$tl_title.'<span class="login_user text-muted"> by '.$user_name.'</span></h4>
        <div class="card-text">'.$tl_content.'</div>
      </div>
    </div>';
  }



   ?>
   <br>

   <div class="display_area">

   </div>
<br>
  <form style="width: 30rem; margin: 0 auto;" method="post">
    <div class="form-group">
      <input name="tl_content" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter comment">
    </div>
    <a class="btn btn-secondary" href="home.php">HOME</a>
    <a class="btn btn-warning" href="timeline_home.php">Timeline</a>
    <input class="btn btn-primary" type="submit" name="tl_send" value="送信">
  </form>
</div>
<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script>
  function insert_comment(post_id,comment){
    $.ajax({
      url: 'insert_comment.php',
      method: 'post'
    }).done(function(done){
      $('.display_area').html(data);
    })
  }
</script>
</body>
</html>
