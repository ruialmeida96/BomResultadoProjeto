<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<div class="wrapper">
  <?php
  $num = rand(2, 7);

  ?>

    <div class="sidebar" data-color="black" data-image="./img/run<?php echo $num?>.jpg">
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
      <li>
        <a class="nav-link" href="index.php">
          <i class="nc-icon nc-grid-45"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="?action=atletasclube">
          <i class="nc-icon nc-badge"></i>
          <p>Atletas</p>
        </a>
      </li>
      <li>
        <div class="dropdown">
          <a class="nav-link" href="#" data-toggle="dropdown">
            <i class="nc-icon nc-bullet-list-67"></i><p>Inscrição em Eventos</p><b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li class="nav-item ">
              <a  class="dropdown-item" href="?action=eventosclube">
                Inscrever Atletas
              </a>
            </li>
            <li class="nav-item ">
              <a  class="dropdown-item" href="?action=inscricaoprovas">
                Lista de Inscrições
              </a>
            </li>
          </ul>

        </div>
      </li>
      <li>
        <a class="nav-link" href="?action=resultadosclube">
          <i class="nc-icon nc-chart-bar-32"></i>
          <p>Resultados</p>
        </a>
      </li>

      <!--<li>
      <div class="dropdown">
      <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
      <i class="nc-icon nc-bank"></i><p>Listagens 2</p><b class="caret"></b>
    </a>
    <div class="dropdown-menu nav-link" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item " href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>
</li>-->
</ul>
</div>
</div>
<div class="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class=" container-fluid  ">
      <a class="navbar-brand" href="index.php">Clube</a>
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
            <a class="nav-link" href="?action=editainfo">
              <span class="nc-icon nc-circle-09"></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?action=logout">
              <span class="nc-icon nc-button-power"></span>
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
        if(!file_exists("./resources/pages/$action.php")) $action="../../index";
        require_once("./resources/pages/$action.php");
      }elseif(isset($_SESSION['U_TIPO'])){
        switch($_SESSION['U_TIPO']){
          //case "0": require_once('./resources/pages/admininicial.php'); break;
          //case "1": require_once('./resources/pages/associnicial.php'); break;
          case "2": require_once('./resources/pages/clubeinicial.php'); break;
          //case "3": require_once('./resources/pages/anunciosaluno.php'); break;
          default: require_once('./resources/templates/home.php'); break;
        }
      }else{
        require_once('./resources/pages/home.php');
      }
      ?>

    </div>
  </div>


  <?php
  require_once('./resources/templates/footer.php');
  ?>
</div>
</div>
