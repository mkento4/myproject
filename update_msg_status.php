<?php 
include('db.php');
if(isset($_POST['tousername']) && isset($_POST['fromusername'])){
	$tousername = h($_POST['tousername']);
	$fromusername = h($_POST['fromusername']);
    $update_state = "update users_chat set msg_status = 'read' where (sender_username = '$tousername') and 
    (receiver = '$fromusername') ";
    $stmt = $con->prepare($update_state);
    $stmt->execute();
}
?>
