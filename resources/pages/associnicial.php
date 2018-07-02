<?php
//Proteção da página

if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
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

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gereevento.class.php');
$DAO = new GereClube();
$DAO5 = new GereEvento();
$DAO3 = new GereUtilizador();
$DAO2 = new GereAssociacao();
$associacaoid = $DAO2->obter_detalhes_associação_apartir_userid($_SESSION['U_ID']);
$obter_todos_eventos = $DAO5->obter_todos_eventos_assoc_especial_inscriçao($associacaoid);
$obter_todas_as_assoc = $DAO2->obter_todas_assoc();
$iduserassoc = $_SESSION['U_ID'];
$associacaoid=$DAO2->obter_detalhes_associação_apartir_userid($iduserassoc);
$obter_todos_os_clubes = $DAO->obter_todas_clubes_apartir_da_associd($associacaoid);

?>
<br>
<div class="row">
  <?php if($obter_todos_os_clubes == null && $associacaoid!=1){ ?>
    <h4>Não existem Clubes Disponiveis</h4><br><br>
  <?php }else if($obter_todos_os_clubes != null && $associacaoid!=1 ){ ?>
    <div class="col-md-4">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Clubes</h4>
          <p class="card-category">Conjunto de Clubes</p>
        </div>
        <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Abreviatura</th>
              <th>Localização</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_clubes);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_clubes[$i]->get_id()."</td>";
                  echo "<td>".$DAO2->obter_nome_apartir_id($obter_todos_os_clubes[$i]->get_associd())."</td>";
                  echo "<td>".$obter_todos_os_clubes[$i]->get_abreviatura()."</td>";
                  echo "<td>".$obter_todos_os_clubes[$i]->get_localizacao()."</td>";
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
          <a class="stats" href="?action=clubesassoc">
            Mais informações >>
          </a>
        </div>
      </div>
    </div>

    <?php
  }
  if($obter_todos_eventos == null){ ?>
    <h4>Não existem Eventos Disponiveis</h4><br><br>
  <?php }else{ ?>
    <div class="col-md-8">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Eventos deste Mês</h4>
          <p class="card-category">Conjunto de Regiões</p>
        </div>
        <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Data</th>
              <th>Organizadores</th>
              <th>Estado</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_eventos);
              do{
                $data_hoje = date("Y-m-d");
                $pieces = explode("-", $data_hoje);
                $dataprova = $obter_todos_eventos[$i]->get_data();
                $hoje = strtotime($data_hoje);
                $data =  strtotime($dataprova);
                $pieces2 = explode("-", $dataprova);
                if($pieces2[1]==$pieces[1]){
                  ?>
                  <tr>
                    <?php
                    echo "<td>".$obter_todos_eventos[$i]->get_id()."</td>";
                    if($obter_todos_eventos[$i]->get_associd()==1){
                      echo "<td>".$obter_todos_eventos[$i]->get_nome()." (Evento Nacional)</td>";
                    }else{
                      echo "<td>".$obter_todos_eventos[$i]->get_nome()."</td>";
                    }
                    if ($data < $hoje) {
                      echo "<td> <p style=color:red;>".$obter_todos_eventos[$i]->get_data()."*</p></td>";
                    }else{
                      echo "<td>".$obter_todos_eventos[$i]->get_data()."</td>";
                    }
                    echo "<td>".$obter_todos_eventos[$i]->get_organizadores()."</td>";
                    echo "<td>".mostraEstado($obter_todos_eventos[$i]->get_estado())."</td>";
                    ?>
                  </tr>
                  <?php
                }
                $i++;
              }while ($i<$tamanho);
              ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer ">
          <br>
          <hr>
          <a class="stats" href="?action=eventosassoc">
            Mais informações >>
          </a>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<?php
function mostraEstado($num){
  if($num==1){
    return "Ativo";
  }else if($num==0){
    return "Pendente";
  }else if($num==2){
    return "Recusado";
  }else if($num==4){
    return "Concluido";
  }else if($num==3){
    return "Com inscrições";
  }
}
 ?>

 <br>
 <h5>Como Associação poderá ser possivel visualizar <strong>Clubes</strong>, <strong>Eventos</strong> e <strong>Resultados</strong>.</h5><br>

 <h5>No que diz respeito a <strong>Clubes</strong>, é possivel:</h5>
 <p>-Adicionar Clube<br>-Gerir informaçao do Clube (Editar, Desativar/Ativar e Eliminar)</p><br>

 <h5>No que diz respeito a <strong>Eventos</strong>, é possivel:</h5>
 <p>-Adicionar Evento e respetivas Provas<br>-Gerir informação de um Evento (Editar e Eliminar)<br>-Aceitar/Recusar Eventos<br>Listar informações de Eventos</p><br>

 <h5>No que diz respeito a <strong>Resultados</strong>, é possivel:</h5>
 <p>-Identificar Resultados dos Eventos e suas Provas<br>-Listar Resultados de Eventos</p><br>
 <br>
