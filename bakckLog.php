<?php
session_start();
$log=$_SESSION['isLog'];
if(!$log || $log==false){
  header("Location: index.php");
}

?>