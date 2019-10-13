<?php
include('db.php');
session_start();
if(isset($_GET['user_name'])){
  $user_name = $_GET['user_name'];
  $select = "select * from users where user_name = '$user_name'";
  $stmt = $con->prepare($select);
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach ($result as $row) {
    $profile_img = $row['user_profile'];
    $one_msg = $row['one_msg'];
    $user_gender = $row['$user_gender'];
    $user_id = $row['user_id'];
  }

  $login_user_email = $_SESSION['user_email'];
  $login_user = "select * from users where user_email = '$login_user_email'";
  $stmt = $con->prepare($login_user);
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach ($result as $row) {
    $login_user_id = $row['user_id'];
  }
}

 ?>
 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>User Profile</title>
     <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
     <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <!------ Include the above in your HEAD tag ---------->

     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
   </head>
   <body>
     <div class="col-md-4 mx-auto">
     <div class="card">
     <img src="<?php echo $profile_img; ?>" class="card-img-top" alt="...">
     <div class="card-body">
     <h5 class="card-title"><?php echo $user_name; ?></h5>
     <p class="card-text"><?php echo $one_msg;?></p>
     <a href="home.php" class="btn btn-secondary">HOME </a>

     <span data-touserid="<?php echo $user_id; ?>"  data-fromuserid="<?php echo $login_user_id; ?>" class="text-muted">フレンド削除
     <input type="submit" class="delete btn btn-sm btn-warning" name="" value="X"></span>
     </span>
     </div>
     </div>
     </div>
   </body>
   <script
   src="https://code.jquery.com/jquery-3.4.1.min.js"
   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
   crossorigin="anonymous"></script>
   <script>
   $(document).on('click','.delete',function(){
     var span = $(this).parent();
     var touserid = span.data('touserid');
     var fromuserid = span.data('fromuserid');
     console.log(touserid);
     console.log(fromuserid);
     delete_friend(touserid,fromuserid);
   });

   function delete_friend(touserid,fromuserid){
     $.ajax({
       url: 'delete_friend.php',
       method: 'post',
       data: {
         touserid:touserid,
         fromuserid,fromuserid
       }
     }).done(function(){
       window.location.href = "home.php";
     });
   }
   </script>
 </html>
