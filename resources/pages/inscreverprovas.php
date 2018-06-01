<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Inscrição de Atletas em Provas</h3>
<?php
$id_user_clube = $_SESSION['U_ID'];
$evento_id = $_GET["id"];


require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gereatleta.class.php');

$DAO = new GereClube();
$DAO2 = new GereEvento();
$DAO3 = new GereProva();
$DAO4 = new GereAtleta();


$clube = $DAO->obter_detalhes_clube_userid($id_user_clube);

$provas_do_evento = $DAO3->obter_todas_provas_eventoid($evento_id);

$atletas_do_clube = $DAO4->obter_todos_atletas_do_clube($clube->get_id());

//agora é fazer um card com a lista de provas e correspondente a lista de provas e escalao e sexo, aparecerem os atletas dispostos a poderem ser inscritos numa determinada prova!
//tambem é necessario consultar se um determinado atleta ja se encontra inscrito numa determinada prova ou nao

if($provas_do_evento == null){ ?>
  <h4>Não existem Provas neste Evento</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Provas Disponiveis</h4>
          <p class="card-category">Detalhes dos provas disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Escalão</th>
              <th>Distancia</th>
              <th>Hora</th>
              <th>Sexo</th>
              <th>Atletas</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($provas_do_evento);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$provas_do_evento[$i]->get_id()."</td>";
                  echo "<td>".$provas_do_evento[$i]->get_nome()."</td>";
                  echo "<td>".$provas_do_evento[$i]->get_escalao()."</td>";
                  echo "<td>".$provas_do_evento[$i]->get_distancia()."</td>";
                  echo "<td>".$provas_do_evento[$i]->get_hora()."</td>";
                  echo "<td>".$provas_do_evento[$i]->get_sexo()."</td>";
                  ?>
                  <td>
                    
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
<?php }

?>
