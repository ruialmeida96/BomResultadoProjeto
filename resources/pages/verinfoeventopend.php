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
                          echo "<td>".$provasevento[$i]->get_escalao()."</td>";
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
    <div class="row">
      <button class="btn btn-primary" onclick="location.href='?action=eventospendentes'">Voltar</button>
      <?php
      $data_hoje = date("Y-m-d");
      $dataprova = $data;

      $hoje = strtotime($data_hoje);
      $data =  strtotime($dataprova);

      if ($data > $hoje) {
        //caso a prova ainda possa vir a acontecer no futuro
        ?>
        <form method="POST" id="Aceita" action="">
          <button type="submit" class="btn btn-success " name="btnAceita" value="<?php echo $eventoid?>">Aceitar</button>
        </form>
        <form method="POST" id="Recusa" action="">
          <button type="submit" class="btn btn-danger  " name="btnRecusa" value="<?php echo $eventoid?>">Recusar</button>
        </form>
      <?php } ?>
    </div>
  </div>
</div>

<?php
if($_SERVER['REQUEST_METHOD']==='POST'){

  if(isset($_POST['btnAceita'])){
    $idevento = $_POST['btnAceita'];

    if($DAO->aceita_evento($idevento)){
      header('Location:?action=eventospendentes');
    }else{
      echo '<script>alert("Ocorreu um erro ao aceitar o evento");</script>';
    }
  }

  if(isset($_POST['btnRecusa'])){
    $idevento = $_POST['btnRecusa'];

    if($DAO->recusa_evento($idevento)){
      header('Location:?action=eventospendentes');
    }else{
      echo '<script>alert("Ocorreu um erro ao recusar o evento");</script>';
    }
  }


}
?>
