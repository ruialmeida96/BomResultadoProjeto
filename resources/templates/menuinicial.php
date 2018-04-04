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
      <a class="navbar-brand" href="#"> Bem Vindo </a>
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
      <!--dentro do painel principal-->

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

<div class="modal fade modal-primary" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h2 class="modal-title" id="exampleModalLabel">Efetuar Login</h2>
      </div>
      <div class="modal-body text-center">
        Email
        <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter email"><br>
        Password
        <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password">
      </div>
      <div class="modal-footer">
        <span></span>
        <button type="button" class="btn btn-success" >Entrar</button>
      </div>
    </div>
  </div>
</div>

<?php
require_once('./resources/templates/footer.html');
?>
</div>
</div>
