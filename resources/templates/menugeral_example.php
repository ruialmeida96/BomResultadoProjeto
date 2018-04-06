<div class="wrapper">
  <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

    Tip 2: you can also add an image using data-image tag
  -->
  <div class="sidebar-wrapper">
    <div class="logo">
      <a href="http://www.creative-tim.com" class="simple-text">
        Creative Tim
      </a>
    </div>
    <ul class="nav">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.html">
          <i class="nc-icon nc-chart-pie-35"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="./user.html">
          <i class="nc-icon nc-circle-09"></i>
          <p>User Profile</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="./table.html">
          <i class="nc-icon nc-notes"></i>
          <p>Table List</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="./typography.html">
          <i class="nc-icon nc-paper-2"></i>
          <p>Typography</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="./icons.html">
          <i class="nc-icon nc-atom"></i>
          <p>Icons</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="./maps.html">
          <i class="nc-icon nc-pin-3"></i>
          <p>Maps</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="./notifications.html">
          <i class="nc-icon nc-bell-55"></i>
          <p>Notifications</p>
        </a>
      </li>
      <li class="nav-item active active-pro">
        <a class="nav-link active" href="upgrade.html">
          <i class="nc-icon nc-alien-33"></i>
          <p>Upgrade to PRO</p>
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class=" container-fluid  ">
      <a class="navbar-brand" href="#pablo"> Dashboard </a>
      <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar burger-lines"></span>
        <span class="navbar-toggler-bar burger-lines"></span>
        <span class="navbar-toggler-bar burger-lines"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="nav navbar-nav mr-auto">
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="dropdown">
              <i class="nc-icon nc-palette"></i>
              <span class="d-lg-none">Dashboard</span>
            </a>
          </li>
          <li class="dropdown nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <i class="nc-icon nc-planet"></i>
              <span class="notification">5</span>
              <span class="d-lg-none">Notification</span>
            </a>
            <ul class="dropdown-menu">
              <a class="dropdown-item" href="#">Notification 1</a>
              <a class="dropdown-item" href="#">Notification 2</a>
              <a class="dropdown-item" href="#">Notification 3</a>
              <a class="dropdown-item" href="#">Notification 4</a>
              <a class="dropdown-item" href="#">Another notification</a>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nc-icon nc-zoom-split"></i>
              <span class="d-lg-block">&nbsp;Search</span>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#pablo">
              <span class="no-icon">Account</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="no-icon">Dropdown</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <div class="divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#pablo">
              <span class="no-icon">Log out</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->


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


<?php
require_once('./resources/templates/footer.html');
?>

</div>
</div>
