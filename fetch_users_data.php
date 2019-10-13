<?php
include('db.php');
session_start();
if(!isset($_SESSION['user_email'])){
  header("location: logout.php");
}
// login userの名前とIDを取得
$login_user_email = $_SESSION['user_email'];
$login_user = "select * from users where user_email = '$login_user_email'";
$stmt = $con->prepare($login_user);
$stmt->execute();
$result = $stmt->fetchAll();
foreach ($result as $row) {
  $login_user_id = $row['user_id'];
  $fromusername = $row['user_name'];
}

$fetch_active = "select * from active_chat";
$stmt = $con->prepare($fetch_active);
$stmt->execute();
$result = $stmt->fetchAll();
foreach ($result as $row) {
  $active_id = $row['now_chat'];
}

// フレンドを取得
$select = "select * from friend where friend1 = '$login_user_id' or friend2 = '$login_user_id'";
$stmt = $con->prepare($select);
$stmt->execute();
$result = $stmt->fetchAll();

$output = '';
foreach ($result as $row) {

  if($row['friend1'] != $login_user_id){
    $frined1_id = $row['friend1'];
    $active = ($frined1_id == $active_id) ? "active_chat" : '';
    $select = "select * from users where user_id = '$frined1_id'";
    $stmt = $con->prepare($select);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $row) {
      $tousername = $row['user_name'];
      $user_profile = $row['user_profile'];
      $login_state = $row['log_in'];
      $output .=  '
      <div class="chat_list start-chat '.$active.'" data-fromusername="'.$fromusername.'" data-tousername="'.$tousername.'">
      <div class="chat_people">
      <div class="chat_img">
      <a href="profile.php?user_name='.$tousername.' "><img src="'.$user_profile.'" alt="sunil"></a>
       </div>
      <div class="chat_ib">
      <h5>'.h($tousername).'
      <span data-touserid="'.$frined1_id.'" data-fromuserid="'.$login_user_id.'">
      <span class="'.$login_state.'">'.$login_state.'</span>
      </h5>
      </div>
      </div>
      </div>
      ';
    }

  }elseif($row['friend2'] != $login_user_id){
    $frined2_id = $row['friend2'];
    $active = ($frined2_id == $active_id) ? "active_chat" : '';
    $select = "select * from users where user_id = '$frined2_id'";
    $stmt = $con->prepare($select);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $row) {
      $tousername = $row['user_name'];
      $user_profile = $row['user_profile'];
      $login_state = $row['log_in'];
      $output .=  '
      <div class="chat_list start-chat '.$active.'" data-fromusername="'.$fromusername.'" data-tousername="'.$tousername.'">
      <div class="chat_people">
      <div class="chat_img">
      <a href="profile.php?user_name='.$tousername.' "><img src="'.$user_profile.'" alt="sunil"></a>
      </div>
      <div class="chat_ib">
      <h5>'.h($tousername).'
      <span data-touserid="'.$frined2_id.'" data-fromuserid="'.$login_user_id.'">

      <span class="'.$login_state.'">'.$login_state.'</span>
      </h5>
      </div>
      </div>
      </div>
      ';
    }

  }

}

echo $output;

?>
