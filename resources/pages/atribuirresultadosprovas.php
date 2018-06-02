<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Indicar os Resultados</h3>
<?php

$eventoid = $_GET["id"];
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereatletaprova.class.php');

$DAO = new GereEvento();
$DAO2 = new GereProva();
$DAO3 = new GereAtletaProva();
$DAO4 = new GereAtleta();

$provasevento = $DAO2->obter_todas_provas_eventoid($eventoid);


$eventoinfo=$DAO->obter_info_evento($eventoid);
$nome = $eventoinfo->get_nome();
$data =  $eventoinfo->get_data();
$local =  $eventoinfo->get_local();

?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Info Evento</h4>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-5 pr-1">
        <label>Nome</label><br>
        <?php  echo $nome;  ?>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 pr-1">
        <label>Data do Evento</label><br>
        <?php  echo $data;  ?>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 pr-1">
        <label>Local do Evento</label><br>
        <?php  echo $local;  ?>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <label>Provas</label><br>
        <?php
        if($provasevento == null){ ?>
          <h4>Não existem provas disponiveis para este evento.</h4><br><br>
        <?php }else{ ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card strpied-tabled-with-hover">
                <div class="card-header ">
                  <h4 class="card-title">Lista de Provas</h4>
                  <p class="card-category">Detalhes das provas disponiveis para este evento</p>
                </div>
                <div class="card-body table-full-width table-responsive">
                  <table class="table table-hover table-striped">
                    <thead>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Escalão</th>
                      <th>Distância</th>
                      <th>Hora</th>
                      <th>Sexo</th>
                      <th>Inscriçoes</th>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      $tamanho = count($provasevento);
                      do{
                        ?>
                        <tr>
                          <?php
                          echo "<td>".$provasevento[$i]->get_id()."</td>";
                          echo "<td>".$provasevento[$i]->get_nome()."</td>";
                          echo "<td>".$provasevento[$i]->get_escalao()."</td>";
                          echo "<td>".$provasevento[$i]->get_distancia()."</td>";
                          echo "<td>".$provasevento[$i]->get_hora()."</td>";
                          echo "<td>".$provasevento[$i]->get_sexo()."</td>";

                          $atletas_nesta_prova = $DAO3->obter_todos_atletas_provas_idprova($provasevento[$i]->get_id());
                          if($atletas_nesta_prova==null){
                            echo "<td><p><small>Nenhum Atleta Inscrito</small></p></td>";
                          }else{
                            echo "<td>";
                            $y = 0;
                            $tamanhoatletas = count($atletas_nesta_prova);
                            do{
                              echo "<div style= 'border: 1px solid black;  margin-left:10px; border-radius: 8px; text-align: center;'>";
                              echo $DAO4->obter_nome_apartir_atleta_id($atletas_nesta_prova[$y]->get_idatleta());
                              ?><br><input id="appt-time" type="time" name="appt-time" step="2"><br>
                            <input type="number" id="quantity" name="quantity" min="1" max="100">
                              <?php
                              echo "</div>";
                              echo "<br><br>";
                              $y++;
                            }while($y<$tamanhoatletas);
                            echo "</td>";
                          }

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
      </div>
    </div>
    <br>
     <button class="btn btn-primary" onclick="location.href='?action=resultadosprovasassoc'">Voltar</button>
  </div>
</div>
