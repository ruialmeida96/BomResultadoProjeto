<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Inscrição em Eventos</h3>


<?php

$id_user_clube = $_SESSION['U_ID'];
require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();


$DAO = new GereClube();
$DAO2 = new GereEvento();

$clube = $DAO->obter_detalhes_clube_userid($id_user_clube);

$associaçao_pretence = $clube->get_associd();


$eventos_assoc_disponiveis= $DAO2->obter_todos_eventos_assoc_especial_inscriçao($associaçao_pretence);

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Eventos que se pode inscrever Atletas"));

if($eventos_assoc_disponiveis == null){ ?>
  <h4>Não existem Eventos Disponiveis para Inscrição</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Eventos Disponiveis para Inscrição</h4>
          <p class="card-category">Detalhes dos eventos disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Data de Inicio</th>
              <th>Dias de Duração</th>
              <th>Tipo</th>
              <th>Local</th>
              <th></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($eventos_assoc_disponiveis);
              do{
                $data_hoje = date("Y-m-d");
                $dataprova = $eventos_assoc_disponiveis[$i]->get_data();

                $hoje = strtotime($data_hoje);
                $data =  strtotime($dataprova);

                if ($data > $hoje) {
                  ?>
                  <tr>
                    <?php
                    echo "<td>".$eventos_assoc_disponiveis[$i]->get_id()."</td>";
                    echo "<td>".$eventos_assoc_disponiveis[$i]->get_nome()."</td>";
                    echo "<td>".$dataprova."</td>";
                    echo "<td>".$eventos_assoc_disponiveis[$i]->get_dias()."</td>";
                    echo "<td>".$eventos_assoc_disponiveis[$i]->get_tipo()."</td>";
                    echo "<td>".$eventos_assoc_disponiveis[$i]->get_local()."</td>";
                    ?>
                    <td>
                      <button class="btn btn-primary" onclick="location.href='?action=inscreverprovas&id=<?php echo $eventos_assoc_disponiveis[$i]->get_id()?>'">Inscrever</button>
                    </td>
                  </tr>
                  <?php
                }
                $i++;
              }while ($i<$tamanho);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php }  ?>
