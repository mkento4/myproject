<?php 
include('db.php');
if(isset($_POST['tousername'])){
	$tousername = h($_POST['tousername']);

	$select = "select * from users where user_name = '$tousername'";
	$stmt = $con->prepare($select);
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach ($result as $row) {
	  $touserid = $row['user_id'];
	}

    $update = "update active_chat set now_chat = '$touserid'";
    $stmt = $con->prepare($update);
    $stmt->execute();
}
?>
