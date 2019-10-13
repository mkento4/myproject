<?php
session_start();
include('db.php');
if(!isset($_SESSION['user_email'])){
  header("location: signin.php");
}
$login_user_email = $_SESSION['user_email'];
$login_user = "select * from users where user_email = '$login_user_email'";
$stmt = $con->prepare($login_user);
$stmt->execute();
$result = $stmt->fetchAll();
foreach ($result as $row) {
  $login_user_name = $row['user_name'];
}
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Home</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/home.css">
</head>
<body>
  <div class="container">
    <h3 class=" text-center">Message <span class="small text-muted">- <?php echo  $login_user_name;?>  -</span>
      <a class="btn btn-sm btn-dark" href="account_settings.php">account</a> -
      <a class="btn btn-sm btn-danger" href="logout.php"> Logout</a>
  </h3>
    <div class="messaging">
      <div class="inbox_msg">


        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>
                <a class="btn btn-sm btn-secondary" href="friend_request.php">フレンド申請</a>
              </h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <a href="find_friends.php" class="search-bar text-muted">search</a>
              </div>
            </div>
          </div>
          <!-- friends area -->

          <div class="inbox_chat">
               <!--
            <div class="chat_list timeline" data-fromusername="'.$fromusername.'" data-tousername="'.$tousername.'">
            <div class="chat_people">
            <div class="chat_ib">
            <h5 class="text-center">
            TIME LINE
            </h5>
            </div>
            </div>
            </div>
            -->

            <div class="chat_user">

            </div>

          </div>
        </div>

        <!-- message area  -->
        <div class="mesgs">
          <div id="msg_history" class="msg_history">
          </div>
          <div class="type_msg" id="type_msg">
          <div data-fromusername="'.$fromusername.'" data-tousername="'.$tousername.'" class="user_class input_msg_write">
          <form  class="input_msg_write">
          <input name="msg_content" type="text" class="write_msg" placeholder="Type a message" />
          <button type="submit" class="msg_send_btn">
            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
          </button>
          </form>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- jquery library -->
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script>
  $(function(){
    fetch_users_data();
    setInterval(function(){
      fetch_users_data();
      update_chat_history();
    },5000);

    $(document).on('click','.chat_list',function(){
      $('.chat_list').removeClass('active_chat');
      $(this).addClass('active_chat');
      $('.msg_history').scrollTop(1000000);
      var tousername = $(this).data('tousername');
      active_chat(tousername);
      console.log(tousername);
    });

    $(document).on('click','.start-chat',function(){
      var tousername = $(this).data('tousername');
      var fromusername = $(this).data('fromusername');
      
      fetch_chat_history(tousername,fromusername);

      try {
        setInterval(function(){
          update_msg_status(tousername,fromusername);
        },5000);
      }catch(e){
        // exit;
      }

    });



    $(document).on('click','.msg_send_btn',function(){
      var tousername = $('.active_chat').data('tousername');
      // var fromusername = div.data('fromusername');
      var msg_content = $(this).parent().find('.write_msg').val()
      insert_chat_history(tousername,msg_content);
      $(this).parent().find('.write_msg').val('');
      return false;
    });


    function insert_chat_history(tousername,msg_content){
      $.ajax({
        url: 'insert_chat_history.php',
        method: 'post',
        data: {
          tousername:tousername,
          // fromusername:fromusername,
          msg_content: msg_content
        }
      }).done(function(data){
        $('.msg_history').html(data);
        $('.msg_history').scrollTop(1000000);
      })
    }

    function fetch_chat_history(tousername,fromusername){
      $.ajax({
        url: 'fetch_chat_history.php',
        method: 'post',
        data: {
          tousername:tousername,
          fromusername:fromusername
        }
      }).done(function(data){
        $('.msg_history').html(data);
        $('.msg_history').scrollTop(1000000);
      });
    }


     $(document).on('click','.timeline',function(){
        window.location.href = 'timeline_home.php';
     });


    function fetch_users_data(){
      $.ajax({
        url: 'fetch_users_data.php',
        method: 'post'
      }).done(function(data){
        $('.chat_user').html(data);
      });
    }


    function update_chat_history(){
      var active_chat = $('.active_chat');
        var fromusername = active_chat.data('fromusername');
        var tousername =  active_chat.data('tousername');
        fetch_chat_history(tousername,fromusername);
    }

    function update_msg_status(tousername,fromusername){
      $.ajax({
        url: 'update_msg_status.php',
        method: 'post',
        data: {
          tousername:tousername,
          fromusername:fromusername
        }
      }).done(function(){

      });
    }

    function active_chat(tousername){
      $.ajax({
        url: 'update_active.php',
        method: 'post',
        data: {tousername:tousername}
      }).done(function(){

      });
    }

  });
  </script>
</body>
</html>
