<?php
include('db.php');
session_start();
if(isset($_POST['tousername'])){
  $tousername = $_POST['tousername'];
  $fromusername = $_POST['fromusername'];
  echo fetch_chat_history($tousername,$fromusername,$con);
}

?>
