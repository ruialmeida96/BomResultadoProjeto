<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Resultados de Eventos</h3>

<p>Listagem de Resultados de Eventos</p>
<?php

require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();
$DAO = new GereEvento();
$DAO2= new GereProva();
$DAO3= new GereAssociacao();
echo "<h2>NAO ESTA FEITO</h2>";

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Resultados aos Clubes"));



if($eventoscominscrições == null){ ?>
  <h4>Não existem eventos com inscrições.</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Eventos com Inscrições</h4>
          <p class="card-category">Detalhes dos eventos disponiveis com inscrições na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Data de Inicio</th>
              <th>Localização</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($eventoscominscrições);
              do{

                $data_hoje = date("Y-m-d");
                $dataprova = $eventoscominscrições[$i]->get_data();

                $hoje = strtotime($data_hoje);
                $data =  strtotime($dataprova);

              //  if ($data < $hoje) {

                  ?>
                  <tr>
                    <?php
                    echo "<td>".$eventoscominscrições[$i]->get_id()."</td>";
                    echo "<td>".$eventoscominscrições[$i]->get_nome()."</td>";
                    echo "<td>".$eventoscominscrições[$i]->get_data();
                    echo "<td>".$eventoscominscrições[$i]->get_local()."</td>";
                    ?>
                    <td>
                      <button class="btn btn-primary" onclick="location.href='?action=atribuirresultadosprovas&id=<?php echo $eventoscominscrições[$i]->get_id()?>'" >Indicar Resultados</button><br>
                    </td>
                  </tr>

                  <?php
                //}
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
