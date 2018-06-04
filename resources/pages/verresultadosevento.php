<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Informação de Resultados de Evento</h3>

<p>Listar os Resultados das diferentes Provas de um determinado Evento</p>

<?php

$eventoid = $_GET["id"];
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereprova.class.php');

$DAO = new GereEvento();
$DAO2 = new GereProva();

$provasevento = $DAO2->obter_todas_provas_eventoid($eventoid);


if($provasevento == null){ ?>
  <h4>Não existem provas disponiveis para este evento.</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-8">
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
              <th></th>
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
                  ?>
                  <td>
                  <button class="btn btn-primary" onclick="addProvas(this.value)" <?php echo "value=".$provasevento[$i]->get_id()." id=".$provasevento[$i]->get_id() ?> >Ver</button><br></td>
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

<div id="container"></div>
<div id="valor" style="display: none;"> </div>
<script>

function addProvas(idbotao){
  var myDiv = document.getElementById("container");
  var myDiv2 = document.getElementById("valor");
  myDiv2.innerHTML=idbotao;
  var valorbotao = idbotao;
  myDiv.innerHTML="idbotao=";
  myDiv.innerHTML+=idbotao;
  myDiv.innerHTML+="<br> Escrever mais coisas<br>";
  myDiv.innerHTML+="";
  <?php
  

  //fazer as coisas iguais ao que foi feito para adicionar provas

   ?>



}

</script>
