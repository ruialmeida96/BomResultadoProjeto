<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Atletas</h3>

Listar atletas e os seus respetivos clubes e associaçoes
<br>

<?php

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereAtleta();
$DAO2 = new GereClube();
$DAO3 = new GereAssociacao();

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Atletas"));


$atletas = $DAO->obter_todos_atletas();

if($atletas == null){ ?>
  <h4>Não existem Atletas na Aplicação</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Atletas na Aplicação</h4>
          <p class="card-category">Detalhes dos atletas disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Nome Exibição</th>
              <th>Contacto</th>
              <th>Email</th>
              <th>Especialidade</th>
              <th>Nacionalidade</th>
              <th>Escalão</th>
              <th>Clube e Associação</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($atletas);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$atletas[$i]->get_id()."</td>";
                  echo "<td>".$atletas[$i]->get_nome()."</td>";
                  echo "<td>".$atletas[$i]->get_nomeexibe()."</td>";
                  echo "<td>".$atletas[$i]->get_contacto()."</td>";
                  echo "<td>".$atletas[$i]->get_email()."</td>";
                  echo "<td>".$atletas[$i]->get_especialidade()."</td>";
                  echo "<td>".$atletas[$i]->get_nacionalidade()."</td>";
                  echo "<td>".mostraescaloes($atletas[$i]->get_escalao())."</td>";
                  echo "<td>".$DAO2->obter_nome_apartir_id($atletas[$i]->get_clube())." - ";
                  $clube_atleta = $DAO2->obter_detalhes_clube_id($atletas[$i]->get_clube());
                  echo "".$DAO3->obter_nome_apartir_id($clube_atleta->get_associd())."</td>";
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
<?php }


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
