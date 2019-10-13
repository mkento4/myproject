<?php
include('db.php');

if(isset($_POST['touserid'])){
  $touserid = $_POST['touserid'];
  $fromuserid = $_POST['fromuserid'];
  $delete_friends = "delete from friend where ( friend1 = '$touserid'  and friend2 = '$fromuserid') or (friend1 = '$fromuserid' and friend2 = '$touserid')";
  $delete_stmt = $con->prepare($delete_friends);
  $delete_stmt->execute();
}



 ?>
