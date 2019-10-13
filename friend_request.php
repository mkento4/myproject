<?php
include('db.php');
session_start();
if(!isset($_SESSION['user_email'])){
  header("location: logout.php");
}
$login_user_email = $_SESSION['user_email'];
$login_user = "select * from users where user_email = '$login_user_email'";
$stmt = $con->prepare($login_user);
$stmt->execute();
$result = $stmt->fetchAll();
foreach ($result as $row) {
  $login_user_id = $row['user_id'];
}

?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Friends Requests</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
  <div class="jumbotron mx-auot">
    <h1 class="display-3">Your friend?</h1>
    <p class="lead">you have friend requests</p>
    <hr class="my-2">
      <a href="home.php" class="btn btn-secondary">HOME</a>
  </div>
  <div style="width: 90%;" class="container">
    <div class="row justify-content-between mx-auto">

      <?php
      $requests = confirm_req($login_user_id,$con);
      $output = '';
      foreach ($requests as $row) {
        $output .= '
        <div class="col-md-4 mx-auto">
        <div class="card">
        <img src="'.$row['user_profile'].'" class="card-img-top" alt="...">
        <div data-othername="'.$row['user_name'].'" class="card-body">
        <h5 class="card-title">'.$row['user_name'].'</h5>
        <p class="card-text">一言メッセージ</p>
        <input class="btn btn-primary admit" type="button" name="" value="認証">
        <input class="btn btn-danger cancel" type="button" name="" value="拒否">
        </div>
        </div>
        </div>';
      }
      echo $output;
      ?>
    </div>
  </div>
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script>
    $(document).on('click','.admit',function(){
      var othername = $(this).parent().data('othername');
      make_friends(othername);
    });
    $(document).on('click','.cancel',function(){
      var othername = $(this).parent().data('othername');
      cancel_request(othername);
    });

    function make_friends(othername){
      $.ajax({
        url: 'make_friends.php',
        method: 'post',
        data: {othername:othername}
      }).done(function(){
        location.reload();
      });
    }
    function cancel_request(othername){
      $.ajax({
        url: 'cancel_request.php',
        method: 'post',
        data: {othername:othername}
      }).done(function(){
        location.reload();
      });
    }


  </script>
</body>
</html>
