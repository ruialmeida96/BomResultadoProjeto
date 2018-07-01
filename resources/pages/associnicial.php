<?php
//Proteção da página

if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}

$time = date("H");

if ($time < "12") {
  echo "<h3>Bom dia,</h3>";
} else  if ($time >= "12" && $time < "17") {
  echo "<h3>Boa tarde,</h3>";
} else if ($time >= "17") {
  echo "<h3>Boa noite,</h3>";
}
?>
