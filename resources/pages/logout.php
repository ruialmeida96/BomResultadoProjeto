<?php
//Proteção da página
if(!isset($_SESSION['U_ID'])){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}

//Destruir sessão
$_SESSION = array();
if(isset($_COOKIE[session_name()])){
  setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();
echo '<script>document.location.href = "?";</script>';
?>
