<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}

$time = date("H");

if ($time < "12") {
  echo "<h3>Bom dia,</h3>";
} else  if ($time >= "12" && $time < "20") {
  echo "<h3>Boa tarde,</h3>";
} else if ($time >= "20") {
  echo "<h3>Boa noite,</h3>";
}

$id_user_clube = $_SESSION['U_ID'];

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
$clube = $DAO->obter_detalhes_clube_userid($id_user_clube);

$atletas_clube = $DAO3->obter_todos_atletas_do_clube($clube->get_id());
$i=0;

$todas_as_inscricoes=$DAO4->obter_todos_atletas_provas();

$clubeid= $DAO->obter_clube_id_clube_userid($id_user_clube);
$obter_todos_os_atletas = $DAO3->obter_todos_atletas_do_clube($clubeid);
?>
<br>
<div class="row">
  <?php if($obter_todos_os_atletas == null){ ?>
    <h4>Não existem Atletas Disponiveis</h4><br><br>
  <?php }else{ ?>
    <div class="col-md-6">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Atletas</h4>
          <p class="card-category">Conjunto de Atletas</p>
        </div>
        <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Email</th>
              <th>Especialidade</th>
              <th>Escalão</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_atletas);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_atletas[$i]->get_id()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_nome()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_email()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_especialidade()."</td>";
                  echo "<td>".mostraescaloes($obter_todos_os_atletas[$i]->get_escalao())."</td>";
                  ?>
                </tr>
                <?php
                $i++;
              }while ($i<$tamanho);
              ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer ">
          <br>
          <hr>
          <a class="stats" href="?action=atletasclube">
            Mais informações >>
          </a>
        </div>
      </div>
    </div>

    <?php
  }
  if($todas_as_inscricoes == null){ ?>
    <h4>Não existem Inscrições em Eventos </h4><br><br>
  <?php }else{
    if( $atletas_clube ==null){
      ?><h4>Não existem Atletas no Clube inscritos em Eventos </h4><br><br><?php
    }else{
    $y=0;
  $a=0;
  do{
    if($DAO4->verificar_atleta_inscricao_geral($atletas_clube[$y]->get_id())){
      $a=1;
    }
    $y++;
  }while($y<count($atletas_clube));

  if($a==1){
    ?>
    <div class="col-md-6">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Inscrições em Eventos</h4>
          <p class="card-category">Conjunto de Inscrições</p>
        </div>
        <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
          <table class="table table-hover table-striped">
            <thead>
              <th>Atleta ID</th>
              <th>Nome Atleta</th>
              <th>Prova ID</th>
              <th>Nome Prova</th>
              <th>Evento</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($todas_as_inscricoes);
              do{
                ?>
                <tr>
                  <?php
                  if($DAO3->verificar_atleta_clube($todas_as_inscricoes[$i]->get_idatleta(),$clube->get_id())){
                    $detalhes_prova = $DAO5->obter_dados_provaid($todas_as_inscricoes[$i]->get_idprova());
                    $evento = $detalhes_prova->get_eventoid();
                    $infoevento = $DAO2->obter_info_evento($evento);
                    $data_hoje = date("Y-m-d");
                    $dataevento = $infoevento->get_data();

                    $hoje = strtotime($data_hoje);
                    $data =  strtotime($dataevento);

                    if(($infoevento->get_estado())==3){
                      if ($data > $hoje) {
                        echo "<td>".$todas_as_inscricoes[$i]->get_idatleta()."</td>";
                        echo "<td>".$DAO3->obter_nome_apartir_atleta_id($todas_as_inscricoes[$i]->get_idatleta())."</td>";
                        echo "<td>".$todas_as_inscricoes[$i]->get_idprova()."</td>";
                        echo "<td>".$DAO5->obter_nome_apartir_prova_id($todas_as_inscricoes[$i]->get_idprova())."</td>";
                        echo "<td>".$infoevento->get_nome()."</td>";?>
                        <?php
                      }
                    }

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
        <div class="card-footer ">
          <br>
          <hr>
          <a class="stats" href="?action=inscricaoprovas">
            Mais informações >>
          </a>
        </div>
      </div>
    </div>
  <?php }else if($a==0){
    ?><h4>Não existem nenhum Atleta do Clube Inscrito em Eventos </h4><?php
  }
}
}?>
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
<br>
<h5>Como Clube poderá ser possivel visualizar <strong>Atletas</strong>, <strong>Inscrições</strong> e <strong>Resultados</strong>.</h5><br>

<h5>No que diz respeito a <strong>Atletas</strong>, é possivel:</h5>
<p>-Adicionar Atleta<br>-Gerir informaçao do Atleta (Editar e Eliminar)</p><br>

<h5>No que diz respeito a <strong>Inscrições</strong>, é possivel:</h5>
<p>-Adicionar Inscrição<br>-Gerir informação de uma Inscrição (Cancelar Inscrição)</p><br>

<h5>No que diz respeito a <strong>Resultados</strong>, é possivel:</h5>
<p>-Listar os Resultadosde Eventos</p><br>
