<div class="wrapper">
  <div class="sidebar" data-color="azure" data-background-color="white" data-image="../img/sidebar-1.jpg">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="index.php" class="simple-text logo-normal">
      Bom Resultado
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item active ">
        <a class="nav-link" href="./index.php">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <a class="navbar-brand" href="#">Bem-Vindo</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">

        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#exampleModal" data-toggle="modal">
              <i class="material-icons">person</i>
              <p>
                <span class="d-lg-none d-md-block">Account</span>
              </p>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="content">
    <div class="container-fluid">

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Efetuar Login</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Email
              <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter email"><br>
              Password
              <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success">Entrar</button>
            </div>
          </div>
        </div>
      </div>


      <?php
      if(!empty($_GET['action'])){
        $action = basename($_GET['action']);
        if(!file_exists("resources/pages/$action.php")) $action="../../index";
        require_once("resources/pages/$action.php");
      }elseif(isset($_SESSION['U_TIPO'])){
        /*  switch($_SESSION['U_TIPO']){
        case "0": require_once('resources/pages/listargestores.php'); break;
        case "1": require_once('resources/pages/listaranunciosgestor.php'); break;
        case "2": require_once('resources/pages/listaranunciossenhorio.php'); break;
        case "3": require_once('resources/pages/anunciosaluno.php'); break;
        default: require_once('resources/templates/home.php'); break;
      }*/
    }else{
      /*
      require_once('resources/classes/utilizadordao.class.php');
      $DAO = new GereUtilizador();

      //Verificar se não existe Administrador (primeira execução do sistema)
      if(empty($DAO->obter_detalhes_utilizador_id(1)->get_id())){
      require_once('resources/pages/criaradministrador.php');
    }else{

    //Ver se a aplicação está desativada
    require_once('resources/configs/opcoes.php');
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query('SELECT 1 FROM opcao WHERE C_NOME=\''.$opcoes[0][0].'\' AND C_ESTADO=1');
    $bd->desligar_bd();
    if($STH->fetch(PDO::FETCH_ASSOC)){
    $_SESSION['active']=true;
  }

  if(!isset($_SESSION['active']) && !isset($_SESSION['U_TIPO'])){
  require_once('resources/pages/aplicacaodesativada.php');
}

//Por defeito
else{
require_once('resources/pages/home.php');
}
}
*/
require_once('resources/pages/home.php');
}

?>

</div>
</div>

<?php
require_once('./resources/templates/footer.html');
?>

</div>
</div>
