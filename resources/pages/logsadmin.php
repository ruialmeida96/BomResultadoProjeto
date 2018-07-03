<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Ficheiro de Logs</h3>
<br>
<?php
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();
$DAO = new GereUtilizador();

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Logs"));

$todos_logs = $DAO10->obter_todos_logs();

if($todos_logs == null){ ?>
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
              <th>ID Utilizador</th>
              <th>Nome Utilizador</th>
              <th>Data</th>
              <th>Hora</th>
              <th>Descrição</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($todos_logs);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$todos_logs[$i]->get_id()."</td>";
                  if($todos_logs[$i]->get_userid()==0){
                    echo "<td>".$todos_logs[$i]->get_userid()."</td>";
                    echo "<td>Anónimo</td>";
                  }else{
                    echo "<td>".$todos_logs[$i]->get_userid()."</td>";
                    echo "<td>".$DAO->obter_nome_apartir_id($todos_logs[$i]->get_userid())."</td>";
                  }
                  echo "<td>".$todos_logs[$i]->get_data()."</td>";
                  echo "<td>".$todos_logs[$i]->get_hora()."</td>";
                  echo "<td>".$todos_logs[$i]->get_disc()."</td>";
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
