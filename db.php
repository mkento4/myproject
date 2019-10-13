<?php
ini_set("display_errors", 1);
$con = new PDO('mysql:dbname=mychat;host=localhost','root','root');
date_default_timezone_set('Asia/Tokyo');


function h($s){
  return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

function fetch_chat_history($tousername,$fromusername,$con){
  // fetch user info login in
  $total_msg = "select * from users_chat where
  (sender_username = '$fromusername' AND
  receiver = '$tousername' ) OR
  (sender_username = '$tousername' AND
  receiver = '$fromusername')";
  $stmt = $con->prepare($total_msg);
  $stmt->execute();
  $result = $stmt->fetchAll();
  $output = '';
  foreach ($result as $row) {
    $sender_username = $row['sender_username'];
    $receiver_username = $row['receiver'];
    $msg_content = $row['msg_content'];
    $msg_status = ($row['msg_status'] == "read") ? "既読":"未読";
    $msg_date = $row['msg_date'];
    if($sender_username == $fromusername  AND $receiver_username == $tousername){
      $output .='
      <div class="outgoing_msg">
      <div class="sent_msg">
      <p>'.$msg_content.'
      </p>
      <span class="time_date">'.date("H:i",strtotime($msg_date)).'   |    '.date("m/d",strtotime($msg_date)).'   |  '.$msg_status.'
      </span>
      </div>
      </div>';
    }else{
      $output .='
      <div class="incoming_msg">
      <div class="incoming_msg_img">
      <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
      </div>
      <div class="received_msg">
      <div class="received_withd_msg">
      <p>'.$msg_content.'</p>
      <span class="time_date">'.date("H:i",strtotime($msg_date)).'   |    '.date("m/d",strtotime($msg_date)).'</span>
      </div>
      </div>
      </div>';
    }
  }
  // $output .= '
  // <div class="type_msg" id="type_msg">
  // <div data-fromusername="'.$fromusername.'" data-tousername="'.$tousername.'" class="user_class input_msg_write">
  // <form  class="input_msg_write">
  // <input name="msg_content" type="text" class="write_msg" placeholder="Type a message" />
  // <button type="submit" class="msg_send_btn">
  // <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
  // </button>
  // </form>
  // </div>
  // </div>
  // ';
  return $output;
}

function confirm_req($login_user_id,$con){
  $sql = "select user_name,user_profile from friend_request join
  users on friend_request.sender = users.user_id where receiver = '$login_user_id'";
  $stmt = $con->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
}

function make_friends($login_user_id,$others_id,$con){
  $delete_request = "delete from friend_request where (sender = '$login_user_id' and
  receiver = '$others_id') OR (sender = '$others_id' AND receiver = '$login_user_id')";
  $delete_stmt = $con->prepare($delete_request);
  if($delete_stmt->execute()){
      $sql = "insert into friend (friend1,friend2) values ('$login_user_id','$others_id')";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      header('Location: home.php');
  }
}

function cancel_request($login_user_id,$others_id,$con){
  $sql = "delete from friend_request where (sender = '$login_user_id' and receiver = '$others_id')
  or (sender =  '$others_id' and receiver = '$login_user_id')";

            $stmt = $con->prepare($sql);
            $stmt->execute();
            header('Location: home.php');
}

function is_already_friend($login_user_id,$others_id,$con){
  $sql = "select * from friend where (friend1 = '$login_user_id'
  and friend2 = '$others_id') or (friend1 = '$others_id'
  and friend2 = '$login_user_id')";
  $stmt = $con->prepare($sql);
  $stmt->execute();
  if($stmt->rowCount() == 1){
    return true;
  }else{
    return false;
  }
}

?>
