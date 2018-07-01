<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
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
require_once('./resources/classes/gerenuts.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gerenuts.class.php');
require_once('./resources/classes/gereutilizador.class.php');

$DAO = new GereNuts();
$obter_todos_os_nuts = $DAO->obter_todos_nuts();

$DAO = new GereAssociacao();
$obter_todas_as_assoc = $DAO->obter_todas_assoc();

$DAO2 = new GereNuts();
$obter_todos_os_nuts = $DAO2->obter_todos_nuts();

$DAO3 = new GereUtilizador();

?>
<br>
<div class="row">
  <div class="col-md-4">
    <div class="card ">
      <div class="card-header ">
        <h4 class="card-title">Regiões</h4>
        <p class="card-category">Conjunto de Regiões</p>
      </div>
      <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
        <table class="table table-hover table-striped" >
          <thead>
            <th>ID</th>
            <th>Nome</th>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $tamanho = count($obter_todos_os_nuts);
            do{
              ?>
              <tr>
                <?php
                echo "<td>".$obter_todos_os_nuts[$i]->get_id()."</td>";
                echo "<td>".$obter_todos_os_nuts[$i]->get_regiao()."</td>";
                ?>
              </tr>
              <?php
              $i++;
            }while ($i<$tamanho);
            ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer ">
        <br>
        <hr>
        <a class="stats" href="?action=nuts">
          Mais informações >>
        </a>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card ">
      <div class="card-header ">
        <h4 class="card-title">Associações</h4>
        <p class="card-category">Conjunto de Associações</p>
      </div>
      <div class="card-body" style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
        <table class="table table-hover table-striped">
          <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Região</th>
            <th>Abreviatura</th>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $tamanho = count($obter_todas_as_assoc);
            do{
              ?>
              <tr>
                <?php
                echo "<td> <div class='form-check'>".$obter_todas_as_assoc[$i]->get_id()." </div></td>";
                echo "<td>".$DAO3->obter_nome_apartir_id($obter_todas_as_assoc[$i]->get_userid())."</td>";
                echo "<td>".$DAO2->obter_nome_apartir_id($obter_todas_as_assoc[$i]->get_nutsid())." (".$obter_todas_as_assoc[$i]->get_nutsid().")</td>";
                echo "<td>".$obter_todas_as_assoc[$i]->get_abreviatura()."</td>";
                ?>
              </tr>
              <?php
              $i++;
            }while ($i<$tamanho);
            ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer ">
        <br>
        <hr>
        <a class="stats" href="?action=associacoesadmin">
          Mais informações >>
        </a>
      </div>
    </div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-6">
    <div class="card ">
      <div class="card-header ">
        <h4 class="card-title">Atletas Recentes</h4>
        <p class="card-category">Conjunto de Atletas</p>
      </div>
      <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
        <table class="table table-hover table-striped" >
          <thead>
            <th>ID</th>
            <th>Nome</th>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $tamanho = count($obter_todos_os_nuts);
            do{
              ?>
              <tr>
                <?php
                echo "<td>".$obter_todos_os_nuts[$i]->get_id()."</td>";
                echo "<td>".$obter_todos_os_nuts[$i]->get_regiao()."</td>";
                ?>
              </tr>
              <?php
              $i++;
            }while ($i<$tamanho);
            ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer ">
        <br>
        <hr>
        <a class="stats" href="?action=atletasadmin">
          Mais informações >>
        </a>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card ">
      <div class="card-header ">
        <h4 class="card-title">Eventos Proximos</h4>
        <p class="card-category">Conjunto de Regiões</p>
      </div>
      <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
        <table class="table table-hover table-striped" >
          <thead>
            <th>ID</th>
            <th>Nome</th>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $tamanho = count($obter_todos_os_nuts);
            do{
              ?>
              <tr>
                <?php
                echo "<td>".$obter_todos_os_nuts[$i]->get_id()."</td>";
                echo "<td>".$obter_todos_os_nuts[$i]->get_regiao()."</td>";
                ?>
              </tr>
              <?php
              $i++;
            }while ($i<$tamanho);
            ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer ">
        <br>
        <hr>
        <a class="stats" href="?action=eventosadmin">
          Mais informações >>
        </a>
      </div>
    </div>
  </div>

</div>
