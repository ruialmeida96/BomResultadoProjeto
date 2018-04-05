<div class="wrapper">
  <div class="sidebar" data-color="black" data-image="./img/run2.jpg">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

    Tip 2: you can also add an image using data-image tag
  -->
  <div class="sidebar-wrapper">
    <div class="logo">
      <a href="index.php" class="simple-text" data-color"black">
        Bom Resultado
      </a>
    </div>
    <ul class="nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="nc-icon nc-grid-45"></i>
          <p>Dashboard</p>
        </a>
      </li>

    </ul>
  </div>
</div>
<div class="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class=" container-fluid  ">
      <a class="navbar-brand" href="#"> Bem Vindo xd </a>
      <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar burger-lines"></span>

      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="nav navbar-nav mr-auto">
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="dropdown">
              <span class="d-lg-none">Dashboard</span>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a data-color"black">
              <i class="nc-icon nc-single-02"  data-toggle="modal" data-target="#myModal1"> </i>

            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="content">
    <div class="container-fluid">
<?php
//main
if(!empty($_GET['action'])){
  $action = basename($_GET['action']);
  if(!file_exists("resources/pages/$action.php")) $action="../../index";
  require_once("resources/pages/$action.php");
}elseif(isset($_SESSION['U_TIPO'])){
  switch($_SESSION['U_TIPO']){
    case "0": require_once('./resources/pages/admininicial.php'); break;
    case "1": require_once('./resources/pages/listaranunciosgestor.php'); break;
    case "2": require_once('./resources/pages/listaranunciossenhorio.php'); break;
    case "3": require_once('./resources/pages/anunciosaluno.php'); break;
    default: require_once('./resources/templates/home.php'); break;
  }
}else{
  require_once('./resources/pages/home.php');
}
?>
</div>
</div>
<?php


//Footer
require_once('./resources/templates/footer.html');
 ?>


<div class="modal fade modal-primary" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h2 class="modal-title" id="exampleModalLabel">Efetuar Login</h2>
        <!--arranjar outra maneira para sair sem ter de clicar com botao, para a parte do mobile-->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
          <form method="POST" id="loginForm" action="">

        Email
        <input type="email" class="form-control" id="emaillogin"  name="emaillogin" aria-describedby="emailHelp" placeholder="example@email.com"><br>
        Password
        <input type="password" class="form-control" id="passlogin" name="passlogin" placeholder="password...">
      </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember" id="remember" name="remember"> Lembrar-me
          </label>
        </div>
        <button type="submit" class="btn btn-success" name="btnLogin" >Entrar</button>

        </form>

    </div>
  </div>
</div>


</div>
</div>

<?php
if($_SERVER['REQUEST_METHOD']==='POST'){

  //Login
  if(isset($_POST['btnLogin'])){
    if(isset($_POST['emaillogin'],$_POST['passlogin']) && !empty($_POST['emaillogin']) && !empty($_POST['passlogin'])){

        require_once('resources/classes/gereutilizador.class.php');
        $DAO=new GereUtilizador();
        if($DAO->password_correta($_POST['emaillogin'],$_POST['passlogin'])){
          if($DAO->conta_ativa($_POST['emaillogin'])){
            if(isset($_POST['remember']) && !empty($_POST['remember'])){
              setcookie('PHPSESSID', $_COOKIE['PHPSESSID'], time()+(60*60*24*7), "/");
            }
            echo '<script>document.location.href = "";</script>';
          }else{
            unset($_SESSION['U_ID'],$_SESSION['U_TIPO']);
            echo '<script>alert("A sua conta esta desativa. Poderá contactar-nos via e-mail para esclarecimentos.");</script>';
          }
        }else{
          echo '<script>alert("O e-mail ou a palavra-passe inseridos não se encontram correctos.");</script>';
        }


    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
    }
  }
}


 ?>
