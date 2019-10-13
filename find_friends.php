<?php

include('db.php');
session_start();
include('find_friends_function.php');
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Find Friends!!</title>


  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="css/find_friends.css">
</head>
<body>
  <div class="container">
    <br/>
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <form action="" method="post" class="card card-sm">
          <div class="card-body row no-gutters align-items-center">
            <div class="col-auto">
              <i class="fas fa-search h4 text-body"></i>
            </div>

            <div class="col">
              <input name="search_content" class="form-control form-control-lg form-control-borderless" type="text" placeholder="Search name of friends or keywords">
            </div>

            <div class="col-auto">
              <button name="search" class="btn btn-lg btn-secondary" type="submit">Search</button>
              <a href="home.php" class="btn btn-lg btn-danger">HOME</a>
            </div>
            
            <input type="hidden" name="token4" value="<?php echo h($_SESSION['token4']); ?>">

          </div>
        </form>
      </div>
    </div>
  </div>

  <div style="width: 90%;" class="container">
    <div class="row justify-content-between mx-auto">
      <?php

      $login_user_email = $_SESSION['user_email'];
      $login_user = "select * from users where user_email = '$login_user_email'";
      $stmt = $con->prepare($login_user);
      $stmt->execute();
      $result = $stmt->fetchAll();
      foreach ($result as $row) {
        $login_user_id = $row['user_id'];
      }
      search_friends($login_user_id,$con);
       ?>
    </div>
  </div>

  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script>
    $(document).on('click','.follow',function(){
      var receiver = $(this).parent().data('receiver');
      $(this).val('Followed');
      $(this).removeClass('btn-primary');
      $(this).addClass('btn-danger');
      send_request(receiver);
    });

    function send_request(receiver){
      $.ajax({
        url: 'send_request.php',
        method: 'post',
        data: {receiver:receiver}
      }).done(function(){
        // location.reload();
      });
    }


  </script>
</body>
</html>
