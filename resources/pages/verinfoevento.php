<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Informação de Evento</h3>
<?php

$eventoid = $_GET["id"];
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereEvento();
$DAO2 = new GereProva();

$provasevento = $DAO2->obter_todas_provas_eventoid($eventoid);


$eventoinfo=$DAO->obter_info_evento($eventoid);
$nome = $eventoinfo->get_nome();
$data =  $eventoinfo->get_data();
$dias =  $eventoinfo->get_dias();
$tipo =  $eventoinfo->get_tipo();
$local =  $eventoinfo->get_local();
$detalhes =  $eventoinfo->get_detalhes();
$organizadores =  $eventoinfo->get_organizadores();

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Apresentação de informação de um Evento"));
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
        <label>Dias de Duração</label><br>
        <?php  echo $dias;  ?>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 pr-1">
        <label>Tipo de Evento</label><br>
        <?php  echo $tipo;  ?>
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
      <div class="col-md-5 pr-1">
        <label>Detalhes</label><br>
        <?php  echo $detalhes;  ?>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 pr-1">
        <label>Organização</label><br>
        <?php  echo $organizadores;  ?>
        <br>
      </div>
    </div>
    <br><br>
    <div class="row">
      <div class="col-md-5 pr-1">
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
                          echo "<td>".mostraescaloes($provasevento[$i]->get_escalao())."</td>";
                          echo "<td>".$provasevento[$i]->get_distancia()."</td>";
                          echo "<td>".$provasevento[$i]->get_hora()."</td>";
                          echo "<td>".$provasevento[$i]->get_sexo()."</td>";
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
     <button class="btn btn-primary" onclick="location.href='?action=eventosassoc'">Voltar</button>
  </div>
</div>

<?php

function mostraescaloes($num){
  if($num==1){
    return "Benjamins A";
  }else if($num==2){
    return "Benjamins B";
  }else if($num==3){
    return "Infantis";
  }else if($num==4){
    return "Iniciados";
  }else if($num==5){
    return "Juvenis";
  }else if($num==6){
    return "Juniores";
  }else if($num==7){
    return "Sub-23";
  }else if($num==8){
    return "Seniores";
  }else if($num==9){
    return "Veteranos 35";
  }else if($num==10){
    return "Veteranos 40";
  }else if($num==11){
    return "Veteranos 45";
  }else if($num==12){
    return "Veteranos 50";
  }else if($num==13){
    return "Veteranos 55";
  }else if($num==14){
    return "Veteranos 60";
  }else if($num==15){
    return "Veteranos 65";
  }else if($num==16){
    return "Veteranos 70";
  }else if($num==17){
    return "Veteranos 75";
  }else if($num==18){
    return "Veteranos 80";
  }else if($num==19){
    return "Veteranos 85";
  }else if($num==20){
    return "Veteranos 90";
  }
}

 ?>
