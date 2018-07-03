<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Clubes</h3>
<br>
<?php
require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereClube();
$obter_todos_os_clubes = $DAO->obter_todas_clubes();

$DAO2 = new GereAssociacao();
$obter_todas_as_assoc = $DAO2->obter_todas_assoc();

$DAO3 = new GereUtilizador();
$iduserassoc = $_SESSION['U_ID'];
$associacaoid=$DAO2->obter_detalhes_associação_apartir_userid($iduserassoc);

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Clubes"));

if($obter_todos_os_clubes == null){ ?>
  <h4>Não existem Clubes Disponiveis</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Clubes Disponiveis</h4>
          <p class="card-category">Detalhes dos clubes disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Associação</th>
              <th>Abreviatura</th>
              <th>Localização</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_clubes);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_clubes[$i]->get_id()."</td>";
                  echo "<td>".$DAO3->obter_nome_apartir_id($obter_todos_os_clubes[$i]->get_userid())."</td>";
                  echo "<td>".$DAO2->obter_nome_apartir_id($obter_todos_os_clubes[$i]->get_associd())."</td>";
                  echo "<td>".$obter_todos_os_clubes[$i]->get_abreviatura()."</td>";
                  echo "<td>".$obter_todos_os_clubes[$i]->get_localizacao()."</td>";
                  ?>
                </tr>
                <?php
                $i++;
              }while ($i<$tamanho);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
