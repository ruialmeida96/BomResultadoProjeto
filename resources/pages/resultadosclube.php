<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Resultados de Eventos</h3>
<br>
<?php
require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gereatletaprova.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();
$DAO = new GereClube();
$DAO2 = new GereEvento();
$DAO3 = new GereAtleta();
$DAO5 = new GereProva();
$DAO4 = new GereAtletaProva();
$clube = $DAO->obter_detalhes_clube_userid($_SESSION['U_ID']);
$associacaoid = $clube->get_associd();
$obter_todos_os_eventos=$DAO2->obter_todos_eventos_assoc_concluidos($associacaoid);

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Resultados aos Clubes"));

if($obter_todos_os_eventos == null){ ?>
  <h4>Não existem eventos concluidos disponiveis.</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Eventos Concluidos</h4>
          <p class="card-category">Detalhes dos eventos concluidos disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Data de Inicio</th>
              <th>Dias de Duração</th>
              <th>Tipo</th>
              <th>Localização</th>
              <th>Organizadores</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_eventos);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_eventos[$i]->get_id()."</td>";
                  echo "<td>".$obter_todos_os_eventos[$i]->get_nome()."</td>";
                  echo "<td>".$obter_todos_os_eventos[$i]->get_data();
                  echo "<td>".$obter_todos_os_eventos[$i]->get_dias()."</td>";
                  echo "<td>".$obter_todos_os_eventos[$i]->get_tipo()."</td>";
                  echo "<td>".$obter_todos_os_eventos[$i]->get_local()."</td>";
                  echo "<td>".$obter_todos_os_eventos[$i]->get_organizadores()."</td>";
                  ?>
                  <td>
                    <button class="btn btn-primary" onclick="location.href='?action=verresultadoseventoclube&id=<?php echo $obter_todos_os_eventos[$i]->get_id()?>'" >Ver Resultados</button><br>

                  </td>
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
