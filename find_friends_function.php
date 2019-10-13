<?php

if(!isset($_SESSION['user_email'])){
  header("location: logout.php");
}

if(!isset($_SESSION['token4'])){
  $_SESSION['token4'] =  bin2hex(openssl_random_pseudo_bytes(16));
}


function search_friends($login_user_id,$con){
  if(isset($_POST['search'])){

      // CSRF対策
  if (!isset($_POST['token4']) || $_POST['token4'] !== $_SESSION['token4']) {
      echo "Invalid token4!";
      exit;
   }

    $search = $_POST['search_content'];
    $select = "select * from users where user_name like '%$search%' OR
    user_country like '%$search%'";
  }

  $stmt = $con->prepare($select);
  $stmt->execute();
  $result = $stmt->fetchAll();
  $output = '';
  foreach ($result as $row) {
    if ($login_user_id !== $row['user_id']) {
      if(is_already_friend($login_user_id,$row['user_id'],$con)){
        continue;
      }else{
        $output .= '
        <div class="col-md-4 mx-auto">
        <div class="card">
        <img src="'.$row['user_profile'].'" class="card-img-top" alt="...">
        <div data-receiver="'.$row['user_name'].'" class="card-body">
        <h5 class="card-title">'.$row['user_name'].'</h5>
        <p class="card-text">一言メッセージ</p>
        <input class="btn btn-primary follow" type="button" name="" value="Follow">
        </div>
        </div>
        </div>';
      }
    }
  }

  echo $output;
}

?>
