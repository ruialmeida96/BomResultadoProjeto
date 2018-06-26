<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Eventos</h3>

Listar eventos e as informaçoes relativas a estes mesmos
<br>

<?php
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereEvento();
$DAO2= new GereAssociacao();

$eventos=$DAO->obter_todos_eventos();

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Eventos"));

if($eventos == null){ ?>
  <h4>Não existem eventos disponiveis.</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Eventos Disponiveis</h4>
          <p class="card-category">Detalhes dos eventos disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Data de Inicio</th>
              <th>Tipo</th>
              <th>Localização</th>
              <th>Organizadores</th>
              <th>Estado</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($eventos);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$eventos[$i]->get_id()."</td>";
                  echo "<td>".$eventos[$i]->get_nome()."</td>";
                  $data_hoje = date("Y-m-d");
                  $dataprova = $eventos[$i]->get_data();
                  $hoje = strtotime($data_hoje);
                  $data =  strtotime($dataprova);
                  if ($data < $hoje) {
                    echo "<td> <p style=color:red;>".$eventos[$i]->get_data()."*</p></td>";
                  }else{
                    echo "<td>".$eventos[$i]->get_data()."</td>";
                  }
                  echo "<td>".$eventos[$i]->get_tipo()."</td>";
                  echo "<td>".$eventos[$i]->get_local()."</td>";
                  echo "<td>".$eventos[$i]->get_organizadores()."</td>";
                  echo "<td>".mostraEstado($eventos[$i]->get_estado())."</td>";
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
  <p><font color="red">*</font><small>Valores com data a <font color="red">vermelho</font>, indica que a data já passou da data atual </small></p>
<?php }


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
